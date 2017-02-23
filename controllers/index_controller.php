<?php

class IndexController extends \Kanon\Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        /*
        include 'Snoopy.class.php';

        $snoopy = new Snoopy;
        //$snoopy->fetch("http://www.baidu.com");
        $snoopy->fetchform("http://jw.qdu.edu.cn/academic");

        header('Content-type: text/html');
        ob_start();
        print_r($snoopy->cookies);

        while(list($key,$val) = each($snoopy->headers)) {
            echo $key.": ".$val.'<br>';
        }

        ob_get_flush();
         */

        
        /*
        $snoopy->fetchlinks("http://www.phpbuilder.com/");
        print $snoopy->results;

        $submit_url = "http://lnk.ispi.net/texis/scripts/msearch/netsearch.html";

        $submit_vars["q"] = "amiga";
        $submit_vars["submit"] = "Search!";
        $submit_vars["searchhost"] = "Altavista";

        $snoopy->submit($submit_url,$submit_vars);
        print $snoopy->results;
         */

        /*
        $snoopy->maxframes=5;
        $snoopy->fetch("http://www.ispi.net/");
        echo "<PRE>\n";
        echo htmlentities($snoopy->results[0]); 
        echo htmlentities($snoopy->results[1]); 
        echo htmlentities($snoopy->results[2]); 
        echo "</PRE>\n";

        $snoopy->fetchform("http://www.altavista.com");
        print $snoopy->results;
         */
    }

    public function get_order() {

        require 'vendor/autoload.php';

        $args = func_get_args();
        $params = $args[0];

        $client = new MongoDB\Client('mongodb://localhost:27017');
        $collection = $client->exchange->orders;
        $collection_matches = $client->exchange->matches;

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
        }

        $asks = $collection->find(
            ['dir' => 0],
            [
                'limit' => 20,
                'sort' => ['price' => -1, 'id' => 1]
            ]
        )->toArray();

        $bids = $collection->find(
            ['dir' => 1],
            [
                'limit' => 20,
                'sort' => ['price' => -1, 'id' => 1]
            ]
        )->toArray();

        $matches = $collection_matches->find(
            [
                'date' => ['$gt' => intval($params[0])]
            ],
            [
                'limit' => 30,
                'sort' => ['date' => -1]
            ]
        )->toArray();

        $rst = array(
            'asks' => $asks,
            'bids' => $bids,
            'matches' => $matches
        );

        ob_start();
        echo json_encode($rst);
        ob_end_flush();

        exit;
    }
}
