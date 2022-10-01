<?php
require_once(ROOT."/components/Db.php");

class Wifi {
    public static function wifiList($deviceId) {
        $db = Db::getConnection();

        $result = $db->prepare(
            "SELECT * FROM wifi JOIN device_wifi ON (wifi.id = device_wifi.wifiId AND device_wifi.deviceId = :deviceId)");

        $result->bindParam(":deviceId", $deviceId, PDO::PARAM_INT);
        $result->execute();
        $wifiList = [];
        $i = 0;

        while($row = $result->fetch()) {
            $wifiList[$i]['id'] = $row['id'];
            $wifiList[$i]['ssid'] = $row['ssid'];
            $wifiList[$i]['password'] = $row['password'];
            $wifiList[$i]['deviceId'] = $row['deviceId'];
            $i++;
        }

        return $wifiList;
    }
    
    public static function add($ssid, $password, $deviceId) {
        $db = Db::getConnection();

        $result = $db->prepare("INSERT INTO wifi (ssid, password) VALUES (:ssid, :password)");
        $result->bindParam(":ssid", $ssid, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_STR);
        $result->execute();

        $lastId = $db->lastInsertId();

        $result = $db->prepare("INSERT INTO device_wifi (deviceId, wifiId) VALUES (:deviceId, :wifiId)");
        $result->bindParam(":deviceId", $deviceId, PDO::PARAM_INT);
        $result->bindParam(":wifiId", $lastId, PDO::PARAM_INT);
        $result->execute();

        return $lastId;
    }

    public static function edit($id, $ssid, $password) {
        $db = Db::getConnection();

        $result = $db->prepare("UPDATE wifi SET ssid = :ssid, password = :password WHERE id = :id");
        $result->bindParam(":ssid", $ssid, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_STR);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
    }

    public static function delete($id) {
        $db = Db::getConnection();

        $result = $db->prepare("DELETE FROM wifi WHERE id = :id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();

        $result = $db->prepare("DELETE FROM device_wifi WHERE wifiId = :id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
    }
}