<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->exchange->orders;
$collection_matches = $client->exchange->matches;

while (1) {
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

        echo "Coupled order $ask_id and $bid_id\n";
    }

    sleep(3);
}
