<?php
require_once (ROOT.'/models/Wifi.php');

class WifiController {
    function actionList($id) {

        echo json_encode(Wifi::wifiList($id));

        return true;
    }

    function actionAdd($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        echo json_encode(["id" => Wifi::add($data['ssid'], $data['password'], $id)]);

        return true;
    }

    function actionEdit($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        Wifi::edit($id, $data['ssid'], $data['password']);

        return true;
    }

    function actionDelete($id) {
        Wifi::delete($id);

        return true;
    }
}