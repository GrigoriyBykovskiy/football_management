<?php
    try{
        $connection_to_db = new MongoClient();
        $collection= $connection_to_db-> league -> users;
        $filter=array("token"=> $_COOKIE["token"]);
        $user = $collection->findOne($filter);
        if (!isset($_COOKIE["token"])) header('HTTP/1.0 302 94.19.185.233:/testsite.local/loginform.php',true);
        else{
            if ($user!==null){
                echo  json_encode($user);
            }
        }
     } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 localhost:/testsite.local/loginform.php",true);
    }
?>