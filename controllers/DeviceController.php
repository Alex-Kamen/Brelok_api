<?php
require_once (ROOT.'/models/Device.php');

class DeviceController {
    function actionList() {
        $data = json_decode(file_get_contents('php://input'), true);

        echo json_encode(Device::deviceList($data['id']));

        return true;
    }

    function actionAdd() {
        $data = json_decode(file_get_contents('php://input'), true);

        echo json_encode(["id" => Device::add($data['api_key'], $data['name'], $data['userId'])]);

        return true;
    }

    function actionEdit($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        Device::edit($data['api_key'], $data['name'], $id);

        return true;
    }

    function actionDelete($id) {
        Device::delete($id);

        return true;
    }

    function actionSetStatus($key, $status) {
        Device::setStatus($key, $status);

        return true;
    }

    function actionSetLocation($key, $lat, $lng) {
        Device::setLocation($key, $lat, $lng);

        return true;
    }
}