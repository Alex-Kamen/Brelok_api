<?php
require_once(ROOT."/components/Db.php");
require_once(ROOT."/models/Wifi.php");

class Device {
    public static function deviceList($userId) {
        $db = Db::getConnection();

        $result = $db->prepare(
            "SELECT * FROM device JOIN user_device ON (device.id = user_device.deviceId AND user_device.userId = :userId)");

        $result->bindParam(":userId", $userId, PDO::PARAM_INT);
        $result->execute();
        $deviceList = [];
        $i = 0;

        while($row = $result->fetch()) {
            $deviceList[$i]['id'] = $row[0]; // device id
            $deviceList[$i]['name'] = $row['name'];
            $deviceList[$i]['api_key'] = $row['api_key'];
            $deviceList[$i]['status'] = $row['status'];
            $deviceList[$i]['lat'] = $row['lat'];
            $deviceList[$i]['lng'] = $row['lng'];
            $i++;
        }

        return $deviceList;
    }

    public static function add($api_key, $name, $userId) {
        $db = Db::getConnection();

        $result = $db->prepare("INSERT INTO device (api_key, name) VALUES (:api_key, :name)");
        $result->bindParam(":api_key", $api_key, PDO::PARAM_STR);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->execute();

        $lastId = $db->lastInsertId();

        $result = $db->prepare("INSERT INTO user_device (deviceId, userId) VALUES (:deviceId, :userId)");
        $result->bindParam(":userId", $userId, PDO::PARAM_INT);
        $result->bindParam(":deviceId", $lastId, PDO::PARAM_INT);
        $result->execute();

        return $lastId;
    }

    public static function edit($api_key, $name, $id) {
        $db = Db::getConnection();

        $result = $db->prepare("UPDATE device SET name = :name, api_key = :api_key WHERE id = :id");
        $result->bindParam(":api_key", $api_key, PDO::PARAM_STR);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
    }

    public static function delete($id) {
        $db = Db::getConnection();

        $result = $db->prepare("DELETE FROM device WHERE id = :id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();

        $result = $db->prepare("DELETE FROM user_device WHERE deviceId = :id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
    }

    public static function setStatus($api_key, $status) {
        $db = Db::getConnection();

        $result = $db->prepare("UPDATE device SET status = :status WHERE api_key = :api_key");
        $result->bindParam(":api_key", $api_key, PDO::PARAM_STR);
        $result->bindParam(":status", $status, PDO::PARAM_INT);
        $result->execute();
    }

    public static function setLocation($api_key, $lat, $lng) {
        $db = Db::getConnection();

        $result = $db->prepare("UPDATE device SET lat = :lat, lng = :lng WHERE api_key = :api_key");
        $result->bindParam(":api_key", $api_key, PDO::PARAM_STR);
        $result->bindParam(":lat", $lat, PDO::PARAM_STR);
        $result->bindParam(":lng", $lng, PDO::PARAM_STR);
        $result->execute();
    }
}