<?php
    $connection_to_db = new MongoClient();
    $collection= $connection_to_db-> league -> users;
    $filter=array("token"=> $_COOKIE["token"]);
    $user = $collection->findOne($filter);
    $for_delete = array ('$unset' => array("token" => ""));
    $collection ->  update($user, $for_delete);
    $connection_to_db->close();
    setcookie("token","",time()-3600);
    header("Location:/testsite.local/loginform.php");
?>