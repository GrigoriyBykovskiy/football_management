<?php
    try{
        $connection_to_db = new MongoClient();
        $collection= $connection_to_db-> league -> users;
        $filter=array("token"=> $_COOKIE["token"]);
        $user = $collection->findOne($filter);
        if ($user!==null){
				echo '<table id="output" align="center" class="table">';
				echo '<caption align="right"><h2>Профиль игрока</h2></caption>';
                echo '<tr>';
                echo '<th scope="row" width="50%" align="center">Логин</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["login"].'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th scope="row" width="50%" align="center">Имя</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["name"].'</td>';
                echo '</tr>';
				echo '<tr>';
                echo '<th scope="row" width="50%" align="center">Фамилия</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["surname"].'</td>';
                echo '</tr>';
				echo '<tr>';
				echo '<th scope="row" width="50%" align="center">Кодовое слово</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["key_word"].'</td>';
                echo '<tr>';
				echo '<th scope="row" width="50%" align="center">Статус</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["status"].'</td>';
                echo '</tr>';
				echo '<tr>';
				echo '<th scope="row" width="50%" align="center">Позиция</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["position"].'</td>';
                echo '</tr>';
				echo '<tr>';
				echo '<th scope="row" width="50%" align="center">Команда</th>';
                echo '<td scope="row" width="50%" align="center">'.$user["team"].'</td>';
                echo '</tr>';
            echo '</table>';
        }
     } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 localhost:/testsite.local/loginform.php",true);
    }
?>