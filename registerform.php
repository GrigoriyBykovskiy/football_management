<?php
    try{
        include "lib/lib_hash.php";
        if (isset($_COOKIE["token"])) header('Location:/testsite.local/index.html');
        if (isset($_POST["login"])&&isset($_POST["password"])&&isset($_POST["repeat_password"])&&(isset($_POST["key_word"]))){
            if ($_POST["password"]==$_POST["repeat_password"]&&$_POST["status"]!=="bad_status") {
               $connection_to_db = new MongoClient();
               $collection= $connection_to_db-> league-> users;
               $filter=array("login"=> $_POST["login"]);
               $user = $collection->findOne($filter);
               /*Check that login not used*/
               if ($user===null){
                    if ($_POST["status"]=="owner"){
                       $collection= $connection_to_db-> league-> teams;
                       $filter=array("team"=> $_POST["team"]);
                       $team = $collection->findOne($filter);
                           if ($team!==null){
                                $connection_to_db->close();
                                echo '<p align="center">Team with the same name already exist!</p>';      
                           }
                           else{
                                $team = array( 
                                "name" => $_POST["team"], 
                                "games played"=> 0,
                                "games won"=> 0
                                );
                                $collection->insert($team);   
                                $collection= $connection_to_db-> league-> users;      
                                $token= create_token();
                                $client = array( 
                                "login" => $_POST["login"], 
                                "password" => create_password_hash ($_POST["password"]),
							    "key_word" => $_POST["key_word"],							
                                "token"=> $token,
                                "name" => $_POST["name"],
                                "surname"=> $_POST["surname"],
                                "status"=> $_POST["status"],
							    "position"=> $_POST["status"],
                                "team"=> $_POST["team"]
                                );
                                $collection->insert($client);
                                $connection_to_db->close();
                                setcookie ("token", $token);
                                header('Location:/testsite.local/index.php'); 
                            }
                    }
                    if ($_POST["status"]=="player"){
                        $token= create_token();
                        $client = array(
                        "login" => $_POST["login"],
                        "password" => create_password_hash ($_POST["password"]),
                        "key_word" => $_POST["key_word"],
						"token"=> $token,
                        "name" => $_POST["name"],
                        "surname"=> $_POST["surname"],
                        "status"=> $_POST["status"],
                        "position"=> $_POST["position"],
                        "team"=> "undefined"
                        );
                        $collection->insert($client);
                        $connection_to_db->close();
                        setcookie ("token", $token);
                        header('Location:/testsite.local/index.html');
                    }
                    if ($_POST["status"]=="trainer"){
                        $token= create_token();
                        $client = array( 
                        "login" => $_POST["login"], 
                        "password" => create_password_hash ($_POST["password"]), 
                        "key_word" => $_POST["key_word"],
						"token"=> $token,
                        "name" => $_POST["name"],
                        "surname"=> $_POST["surname"],
                        "status"=> $_POST["status"],
						"position"=> $_POST["status"],
                        "team"=> "undefined"
                        );
                        $collection->insert($client);
                        $connection_to_db->close();
                        setcookie ("token", $token);
                        header('Location:/testsite.local/index.html');
                    }
                }
                else{
                    $connection_to_db->close();
                    echo '<p align="center">User with the same login already exists!</p>';
                }
            }
            else{
                echo '<p align="center">Check fields password, repeat password and status!</p>';
            }
        }
    } catch(MongoConnectionException $e) {
       header("HTTP/1.0 500 Server Mongodb is not avalaible");
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/bootstrap.minreg.css">
	<link rel="shortcut icon" href="favicon.ico">
    <style>
        .form-width {max-width: 25rem;}
        .has-float-label {
            position: relative; }
        .has-float-label label {
            position: absolute;
            left: 0;
            top: 0;
            cursor: text;
            font-size: 75%;
            opacity: 1;
            -webkit-transition: all .2s;
            transition: all .2s;
            top: -.5em;
            left: 0.75rem;
            z-index: 3;
            line-height: 1;
            padding: 0 1px; }
        .has-float-label label::after {
            content: " ";
            display: block;
            position: absolute;
            background: white;
            height: 2px;
            top: 50%;
            left: -.2em;
            right: -.2em;
            z-index: -1; }
        .has-float-label .form-control::-webkit-input-placeholder {
            opacity: 1;
            -webkit-transition: all .2s;
            transition: all .2s; }
        .has-float-label .form-control:placeholder-shown:not(:focus)::-webkit-input-placeholder {
            opacity: 0; }
        .has-float-label .form-control:placeholder-shown:not(:focus) + label {
            font-size: 150%;
            opacity: .5;
            top: .3em; }

        .input-group .has-float-label {
            display: table-cell; }
        .input-group .has-float-label .form-control {
            border-radius: 0.25rem; }
        .input-group .has-float-label:not(:last-child) .form-control {
            border-bottom-right-radius: 0;
            border-top-right-radius: 0; }
        .input-group .has-float-label:not(:first-child) .form-control {
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
            margin-left: -1px; }
    </style>
</head>
<body>
<div class="p-x-1 p-y-3">
    <form class="card card-block m-x-auto bg-faded form-width" id="form" action="registerform.php" method="post">
        <legend class="m-b-1 text-xs-center">Форма регистрации</legend>
        <div class="form-group input-group">
             <span class="has-float-label">
             <input class="form-control" id="name" name="name" type="text" placeholder="Имя" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
             <label for="name">Имя</label>
             </span>
            <span class="has-float-label">
             <input class="form-control" id="surname" name="surname" type="text" placeholder="Фамилия" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
             <label for="surname">Фамилия</label>
             </span>
        </div>
        <div class="form-group input-group">
         <span class="has-float-label">
         <input class="form-control" id="login" name="login" type="text" placeholder="логин" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
         <label for="login">Логин</label>
         </span>
        </div>
        <div class="form-group has-float-label">
            <input class="form-control" id="password" name="password" type="password" placeholder="••••••••" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
            <label for="password">Пароль</label>
        </div>
        <div class="form-group has-float-label">
            <input class="form-control" id="repeat_password" name="repeat_password" type="password" placeholder="••••••••"/ pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
            <label for="repeat_password">Повторите пароль</label>
        </div>
		<div class="form-group input-group">
			 <span class="has-float-label">
			 <input class="form-control" id="key_word" name="key_word" type="text" placeholder="Кодовое слово" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
			 <label for="key_word">Кодовое слово</label>
         </span>
        </div>
        <div class="form-group has-float-label">
            <select class="form-control custom-select" id="status" name="status" onchange="check_status(event)" >
                <option value="bad_status">Выберите статус</option>
                <option value="player">Игрок</option>
                <option value="trainer">Тренер</option>
                <option value="owner">Владелец команды</option>
            </select>
            <label for="status">Ваш статус</label>
        </div>
        <div class="form-group has-float-label" id="additional_field"></div>
        <script>
            function check_status(event) {
                if (document.getElementById("status").value == "owner") {
                    var output=document.getElementById("additional_field");
                    var previous_choose_player=document.getElementById("position");
                    if (previous_choose_player!=null) {
                        var position_1=document.getElementById("position_bad");
                        var position_2=document.getElementById("attack");
                        var position_3=document.getElementById("defender");
                        var position_4=document.getElementById("midfielder");
                        var position_5=document.getElementById("goalkeeper");
                        previous_choose_player.removeChild(position_1);
                        previous_choose_player.removeChild(position_2);
                        previous_choose_player.removeChild(position_3);
                        previous_choose_player.removeChild(position_4);
                        previous_choose_player.removeChild(position_5);
                        output.removeChild(previous_choose_player);
                    }
                    var input = document.createElement("input");
                    input.setAttribute("class", "form-control");
                    input.setAttribute("id", "team");
                    input.setAttribute("name", "team");
                    input.setAttribute("placeholder", "Название команды");
                    var output = document.getElementById("additional_field");
                    output.appendChild(input);
                }
                if (document.getElementById("status").value == "player") {
                    var output=document.getElementById("additional_field");
                    var previous_choose_owner=document.getElementById("team");
                    if (previous_choose_owner!=null) {
                        console.log(previous_choose_owner);
                        output.removeChild(previous_choose_owner);
                    }
                    var input = document.createElement("select");
                    input.setAttribute("class", "form-control custom-select");
                    input.setAttribute("id", "position");
                    input.setAttribute("name", "position");
                    var input_field_option_1 = document.createElement("option");
                    input_field_option_1.setAttribute("value","position_bad");
                    input_field_option_1.setAttribute("id","position_bad");
                    var input_field_option_2 = document.createElement("option");
                    input_field_option_2.setAttribute("value","attack");
                    input_field_option_2.setAttribute("id","attack");
                    var input_field_option_3 = document.createElement("option");
                    input_field_option_3.setAttribute("value","defender");
                    input_field_option_3.setAttribute("id","defender");
                    var input_field_option_4 = document.createElement("option");
                    input_field_option_4.setAttribute("value","midfielder");
                    input_field_option_4.setAttribute("id","midfielder");
                    var input_field_option_5 = document.createElement("option");
                    input_field_option_5.setAttribute("value","goalkeeper");
                    input_field_option_5.setAttribute("id","goalkeeper");
                    var text_option_1 = document.createTextNode("выберите позицию");
                    input_field_option_1.appendChild(text_option_1);
                    var text_option_2 = document.createTextNode("нападающий");
                    input_field_option_2.appendChild(text_option_2);
                    var text_option_3 = document.createTextNode("полузащитник");
                    input_field_option_3.appendChild(text_option_3);
                    var text_option_4 = document.createTextNode("защитник");
                    input_field_option_4.appendChild(text_option_4);
                    var text_option_5 = document.createTextNode("голкипер");
                    input_field_option_5.appendChild(text_option_5);
                    input.appendChild(input_field_option_1);
                    input.appendChild(input_field_option_2);
                    input.appendChild(input_field_option_3);
                    input.appendChild(input_field_option_4);
                    input.appendChild(input_field_option_5);
                    var output=document.getElementById("additional_field");
                    output.appendChild(input);
                }
                if (document.getElementById("status").value == "trainer"||document.getElementById("status").value == "bad_status"){
                    var output=document.getElementById("additional_field");
                    var previous_choose_player=document.getElementById("position");
                    var previous_choose_owner=document.getElementById("team");
                    if (previous_choose_player!=null) {
                        output.removeChild(previous_choose_player);
                    };
                    if (previous_choose_owner!=null) {
                        output.removeChild(previous_choose_owner);
                    };
                }
            }
        </script>
        <div class="text-xs-center">
            <button class="btn btn-block btn-primary" type="submit">Регистрация</button>
        </div>
    </form>
</div>
</body>
</html>