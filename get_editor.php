<?php
    try{
        $connection_to_db = new MongoClient();
        $collection= $connection_to_db-> league -> users;
        $filter=array("token"=> $_COOKIE["token"]);
        $user = $collection->findOne($filter);
        if ($user!==null){
            if ($user["team"]==="undefined"){
                    echo '<table class="table" id="output" align="center">';
                    echo '<tr>';
                    echo '<td width="33%" align="center"></td>';
                    echo '<td width="33%" align="center">Вы не состоите в команде</td>';
                    echo '<td width="33%" align="center"></td>';
                    echo '</tr>';
                    $connection_to_db -> close();    
            }
            else{
                $connection_to_db = new MongoClient("mongodb://127.0.0.1:27017");
                $collection= $connection_to_db -> league -> users;
                $filter=array("team"=> $user["team"]);
                $list= $collection->find($filter);
                    if ($list!==null){
                            echo '<table class="table" id="output" align="center">';
							echo '<caption><h2>Редактор команды</h2></caption>';
                            echo '<tr>';
                            echo '<th width="35%" align="left">Имя</th>';
                            echo '<th width="45%" align="left">Занимаемая позиция</th>';
                            echo '<th width="20%" align="center">Действие</th>';
                            echo '</tr>';
                            while($item=$list->getNext()){
                                echo '<tr>';
                                echo '<td width="35%" align="left">'.$item["name"].'</td>';
                                echo '<td width="45%" align="left">'.$item["position"].'</td>';
                                echo '<td width="20%" align="center"><button class="btn btn-danger" id="'.$item["login"].'"onclick="delete_team_member(this.id)">удалить</button></td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                    }
                $connection_to_db -> close();
            }
        }
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>