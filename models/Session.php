<?php
require_once(ROOT."/components/Db.php");

class Session {
    public static function auth($login, $password) {
        $db = Db::getConnection();

        $result = $db->prepare("SELECT * FROM user WHERE login = :login AND password = :password");
        $result->bindParam(":login", $login, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();

        if($user) {
            return array(
                'id' => $user['id'],
                'login' => $user['login']
            );
        }
    }

    public static function logout() {
        // later
    }

    public static function register($login, $password) {
        $db = Db::getConnection();

        $result = $db->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
        $result->bindParam(":login", $login, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_STR);
        $result->execute();
    }
}