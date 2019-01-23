<?php
    try{
        $connection_to_db = new MongoClient();
        $collection= $connection_to_db-> league -> users;
        $filter=array("token"=> $_COOKIE["token"]);
        $user = $collection->findOne($filter);
        if ($user!==null){
            if ($user["team"]==="undefined"){
                    echo "У вас нет прав на это действие";
                    $connection_to_db -> close();   
            }
            else{
                if ($user["status"]==="player"){
                    echo "У вас нет прав на это действие";
                    $connection_to_db -> close();   
                }
                else{
                    $filter=array("team"=> "undefined","login"=>$_GET["member"]);
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
                                "team"=> $user["team"]
                                );
                        $option=array("upsert" => true);
                        $collection->update($member, $client, $option);
                        echo "Добавление прошло успешно ok";
                        $connection_to_db -> close();                    
                    }
                }   
            }
        }
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>