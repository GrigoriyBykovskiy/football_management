<?php
    try{
        $connection_to_db = new MongoClient();
        $collection= $connection_to_db-> league -> users;
        $filter=array("token"=> $_COOKIE["token"]);
        $user = $collection->findOne($filter);
        if ($user!==null){
            if ($user["status"]==="player"){
                    if ($_GET["member"]===$user["login"]){
                            $client = array(
                            "login" => $user["login"],
                            "password" => $user["password"],
                            "key_word" => $user["key_word"],
						    "token"=> $user["token"],
                            "name" => $user["name"],
                            "surname"=> $user["surname"],
                            "status"=> $user["status"],
                            "position"=> $user["position"],
                            "team"=> "undefined"
                            );
                        $option=array("upsert" => true);
                        $collection->update($member, $client, $option);
                        echo "Вы покинули команду";
                        $connection_to_db -> close(); 
                    }
                    else{
                        echo "У вас нет прав на это действие";
                        $connection_to_db -> close();
                    }    
            }
            else{
                $filter=array("team"=> $user["team"],"login"=>$_GET["member"]);
                $member = $collection->findOne($filter);
                 if ($member!==null){
                    $client = array(
                            "login" => $member["login"],
                            "password" => $member["password"],
                            "key_word" => $member["key_word"],
						    "token"=> $member["token"],
                            "name" => $member["name"],
                            "surname"=> $member["surname"],
                            "status"=> $member["status"],
                            "position"=> $member["position"],
                            "team"=> "undefined"
                            );
                    $option=array("upsert" => true);
                    $collection->update($member, $client, $option);
                    echo "Удаление прошло успешно";
                    $connection_to_db -> close();
                 }
            }
        }
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>