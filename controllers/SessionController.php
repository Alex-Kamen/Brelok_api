<?php
require_once (ROOT.'/models/Session.php');

class SessionController {
	public function actionAuth() {
        $data = json_decode(file_get_contents('php://input'), true);

        echo json_encode(Session::auth($data['login'], $data['password']));

		return true;
	}

    public function actionLogout() {
        // later

        return true;
    }

    public function actionRegister() {
        $data = json_decode(file_get_contents('php://input'), true);
        Session::register($data['login'], $data['password']);

	    return true;
    }
}