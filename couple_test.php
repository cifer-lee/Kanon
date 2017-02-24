<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->exchange->orders;
$collection_matches = $client->exchange->matches;

function insert_order($order_id, $dir, $quantity, $price) {
    /*
    $client = new MongoDB\Client('mongodb://localhost:27017');
    $collection = $client->exchange->orders;
     */
    global $collection;

    $rst = $collection->insertOne([
        'id' => $order_id,
        'dir' => $dir,
        'quantity' => $quantity,
        'price' => $price
        ]);

    //echo "Insert new order, id: $order_id, count " . $rst->getInsertedCount() . "\n";
}

function couple_order() {
    /*
    $client = new MongoDB\Client('mongodb://localhost:27017');
    $collection = $client->exchange->orders;
    $collection_matches = $client->exchange->matches;
     */
    global $collection;
    global $collection_matches;

    $asks = $collection->find(
        ['dir' => 0],
        ['sort' => ['price' => -1, 'id' => 1]]
    )->toArray();

    $bids = $collection->find(
        ['dir' => 1],
        ['sort' => ['price' => -1, 'id' => 1]]
    )->toArray();

    $count_ask = count($asks);
    $count_bid = count($bids);
    for ($i = 0, $j = 0 ; $i < $count_ask && $j < $count_bid ; ) {
        if ($asks[$i]['price'] < $bids[$j]['price']) {
            ++$j;
            continue;
        }

        /* Bargain price */
        $price = ($asks[$i]['price'] + $bids[$j]['price']) / 2;
        $ask_id = $asks[$i]['id'];
        $bid_id = $bids[$j]['id'];

        if ($asks[$i]['quantity'] == $bids[$j]['quantity']) {
            /* Bargain quantity */
            $quantity = $asks[$i]['quantity'];

            $collection->deleteOne(['id' => $asks[$i]['id']]);
            $collection->deleteOne(['id' => $bids[$j]['id']]);

            ++$i;
            ++$j;
        } else if ($asks[$i]['quantity'] > $bids[$j]['quantity']) {
            $quantity = $bids[$j]['quantity'];

            $asks[$i]['quantity'] -= $quantity;
            $collection->deleteOne(['id' => $bids[$j]['id']]);
            $collection->updateOne(['id' => $asks[$i]['id']], ['$set' => ['quantity' => $asks[$i]['quantity']]]);

            ++$j;
        } else if ($asks[$i]['quantity'] < $bids[$j]['quantity']) {
            $quantity = $asks[$i]['quantity'];

            $bids[$j]['quantity'] -= $quantity;
            $collection->deleteOne(['id' => $asks[$i]['id']]);
            $collection->updateOne(
                ['id' => $bids[$j]['id']],
                ['$set' => ['quantity' => $bids[$j]['quantity']]]
            );

            ++$i;
        }

        $collection_matches->insertOne([
            'ask_id' => $ask_id,
            'bid_id' => $bid_id,
            'quantity' => $quantity,
            'price' => $price,
            'date' => time()
        ]);

        //echo "Coupled order $ask_id and $bid_id\n";
        return [
            'ask_id' => $ask_id,
            'bid_id' => $bid_id,
            'quantity' => $quantity,
            'price' => $price
        ];
    }

    return [];
}

function couple_assert($caseid, $expect, $rst) {
    if (array_diff_assoc($expect, $rst)) {
        exit("Assert failed on test case $caseid\n");
    }
}

/* Reset to initial state */
$client->exchange->drop();

insert_order(1, 0, 10, 400);
couple_assert(1, [], couple_order());

insert_order(2, 0, 10, 420);
couple_assert(2, [], couple_order());

insert_order(3, 1, 5, 420);
couple_assert(3, [
    'bid_id' => 3,
    'ask_id' => 2,
    'quantity' => 5,
    'price' => 420
], couple_order());

insert_order(4, 1, 3, 410);
couple_assert(4, [
    'bid_id' => 4,
    'ask_id' => 2,
    'quantity' => 3,
    'price' => 415
], couple_order());

/* try a wrong case */
insert_order(5, 1, 3, 410);
couple_assert(5, [
    'bid_id' => 4,
    'ask_id' => 2,
    'quantity' => 2,
    'price' => 416  // !This is the error point: right bargain price should be 415 here
], couple_order());
