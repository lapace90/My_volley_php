<?php

$result["error"] = false;
$result["message"] = [];

function dbconnect()
{
    $db = new PDO('mysql:host=localhost;dbname=my_volley;chartset=utf8', 'root', '');

    return $db;
}

function createUser($login, $email, $password)
{
    $db = dbconnect();

    try {
        $req = $db->prepare('INSERT INTO users (pseudo, email, password) VALUES(?,?,?)');
        $req->execute([$login, $email, $password]);
    } catch (Exception $e) {
        $result['error'] = true;
        $result["message"] = "Erreur lors de l'inscription";
    }
}



if (!empty($_POST)) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $result["error"] = true;
        $result["message"] = "Merci de fournir une adresse email valide.";
    } else if ($_POST['password'] !== $_POST['password2']) {
        $result["error"] = true;
        $result["message"] = "Les deux mots de passe ne correspondent pas.";
    } else {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        createUser($_POST['login'], $_POST['email'], $hash);
    }

    echo json_encode($result);
}
