<?php

$db = new PDO('mysql:host=localhost;dbname=my_volley;chartset=utf8', 'root', '');

$results["error"] = false;
$results["message"] = [];

if (!empty($_POST)) {

    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $sql = $db->prepare("SELECT * FROM users WHERE pseudo = :login");
        $sql->execute([":login" => $login]);
        $row = $sql->fetch(PDO::FETCH_OBJ);

        if ($row) {
            if (password_verify($password, $row->password)) {
                $results["error"] = false;
                $results["login"] = $row->pseudo;
            } else {
                $results["error"] = true;
                $results["message"] = "Login ou mot de passe incorrect";
            }
        } else {
            $results["error"] = true;
            $results["message"] = "Login ou mot de passe incorrect";
        }
    } else {
        $results['error'] = true;
        $results['message'] = "Veuillez remplir tous les champs";
    }
    echo json_encode($results);
}
