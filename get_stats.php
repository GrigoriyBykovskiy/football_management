<?php
    try{
        $connection_to_db = new MongoClient();
        $collection=$connection_to_db-> league -> teams;
        $list_of_games=$collection->find();
        $key=array("games won"=>-1);
        $list_of_games -> sort($key);
        $list_of_games -> limit(100);
        if ($list_of_games!==null){
            echo '<table class="table" id="output" align="center">';
			echo '<caption><h2>Статистика команд</h2></caption>';
            echo '<tr>';
            echo '<th width="39%" align="center">Название команды</th>';
            echo '<th width="30%" align="center">Игр сыграно</th>';
            echo '<th width="31%" align="center">Игр выиграно</th>';
            echo '</tr>';
            while($item=$list_of_games->getNext()){
                echo '<tr>';
                echo '<td width="39%" align="center">'.$item["name"].'</td>';
                echo '<td width="30%" align="center">'.$item["games played"].'</td>';
                echo '<td width="31%" align="center">'.$item["games won"].'</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        $connection_to_db->close();
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>