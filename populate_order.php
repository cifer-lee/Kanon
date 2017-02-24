<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->exchange->orders;

$i = 0;
while (1) {
    $rst = $collection->insertOne([
        'id' => ++$i,
        'dir' => rand(0, 1),
        'quantity' => rand(1, 100),
        'price' => rand(100, 500)
        ]);
    echo "Insert new order, id: $i, count " . $rst->getInsertedCount() . "\n";

    sleep(rand(1, 2));
}
