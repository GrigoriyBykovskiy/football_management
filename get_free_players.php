<?php
    try{
        $connection_to_db = new MongoClient();
        $collection=$connection_to_db-> league -> users;
        $filter=array("status"=> "player","team"=> "undefined");
        $list_of_players = $collection->find($filter);
        if ($list_of_players!==null){
                echo '<table class="table" id="output" align="center">';
				echo '<caption><h2>Свободные игроки</h2></caption>';
                echo '<tr>';
                echo '<th width="33%" align="center">Имя игрока</th>';
                echo '<th width="33%" align="center">Позиция в команде</th>';
                echo '<th width="33%" align="center">Действие</th>';
                echo '</tr>';
                while($item=$list_of_players->getNext()){
                    echo '<tr>';
                    echo '<td width="30%" align="center">'.$item["name"].'</td>';
                    echo '<td width="50%" align="center">'.$item["position"].'</td>';
                    echo '<td width="20%" align="center"><button class="btn btn-success" id="'.$item["login"].'"onclick="add_player(this.id)">добавить</button></td>';
                    echo '</tr>';
                }
                echo '</table>';
        }
        $connection_to_db->close();
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>