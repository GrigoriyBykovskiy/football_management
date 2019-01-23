<?php
    try{
        include "lib/lib_hash.php";
            if (isset($_POST["login"])&&isset($_POST["key_word"])&&isset($_POST["new_password"])&&($_POST["repeat_new_password"]))
                if ($_POST["new_password"]==$_POST["repeat_new_password"]) {
                   $connection_to_db = new MongoClient();
                   $collection= $connection_to_db-> league-> users;
                   $filter=array("login"=> $_POST["login"]);
                   $user = $collection->findOne($filter);
			       if (($user["key_word"]==$_POST["key_word"])&&$user!==null){
						    $token= create_token();
                            $client = array(
                            "login" => $_POST["login"],
                            "password" => create_password_hash ($_POST["new_password"]),
                            "key_word" => $_POST["key_word"],
						    "token"=> $token,
                            "name" => $user["name"],
                            "surname"=> $user["surname"],
                            "status"=> $user["status"],
                            "position"=> $user["position"],
                            "team"=> $user["team"]
                            );
                            $option=array("upsert" => true);
                            $collection->update($user, $client, $option);
                            setcookie ("token", $token);
                            header('Location:/testsite.local/index.html');
			       }
			       else{
				        echo '<p align="center">Wrong login/key word!</p>';
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
    <title>Восстановление</title>
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
    <form class="card card-block m-x-auto bg-faded form-width" id="form" action="restore_password.php" method="post">
        <legend class="m-b-1 text-xs-center">Форма восстановления пароля</legend>
        <div class="form-group input-group">
			 <span class="has-float-label">
			 <input class="form-control" id="login" name="login" type="text" placeholder="логин" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
			 <label for="login">Логин</label>
			 </span>
        </div>
		<div class="form-group input-group">
			 <span class="has-float-label">
			 <input class="form-control" id="key_word" name="key_word" type="text" placeholder="Кодовое слово" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
			 <label for="key_word">Кодовое слово</label>
			 </span>
        </div>
        <div class="form-group has-float-label">
            <input class="form-control" id="new_password" name="new_password" type="password" placeholder="••••••••" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
            <label for="new_password">Новый пароль</label>
        </div>
        <div class="form-group has-float-label">
            <input class="form-control" id="repeat_new_password" name="repeat_new_password" type="password" placeholder="••••••••"/ pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required/>
            <label for="repeat_new_password">Повторите пароль</label>
        </div>
        <div class="text-xs-center">
            <button class="btn btn-block btn-primary" type="submit">Восстановить</button>
        </div>
    </form>
</div>
</body>
</html>