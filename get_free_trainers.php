<?php
    try{
        $connection_to_db = new MongoClient();
        $collection=$connection_to_db-> league -> users;
        $filter=array("status"=> "trainer","team"=> "undefined");
        $list_of_trainers = $collection->find($filter);
        if ($list_of_trainers!==null){
            echo '<table class="table" id="output" align="center">';
			echo '<caption><h2>Свободные тренера</h2></caption>';
            echo '<tr>';
            echo '<th width="50%" align="center">Имя тренера</th>';
            echo '<th width="50%" align="center">Действие</th>';
            echo '</tr>';
            while($item=$list_of_trainers->getNext()){
                echo '<tr>';
                echo '<td width="50%" align="left">'.$item["name"].'</td>';
                echo '<td width="50%" align="left"><button class="btn btn-success" id="'.$item["login"].'" onclick="add_trainer(this.id)">добавить</button></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        $connection_to_db->close();
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>