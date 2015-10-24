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
}
