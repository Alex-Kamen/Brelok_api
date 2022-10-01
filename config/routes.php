<?php 

return Array(
	"auth" => "session/auth",
    "register" => "session/register",
    "logout" => "session/logout",
    "wifi/list/([0-9]+)" => "wifi/list/$1",
    "wifi/add/([0-9]+)" => "wifi/add/$1",
    "wifi/edit/([0-9]+)" => "wifi/edit/$1",
    "wifi/delete/([0-9]+)" => "wifi/delete/$1",
    "device/list" => "device/list",
    "device/add" => "device/add",
    "device/edit/([0-9]+)" => "device/edit/$1",
    "device/delete/([0-9]+)" => "device/delete/$1",
    "device/status/([A-Za-z0-9]+)/([0-9]+)" => "device/setStatus/$1/$2",
    "device/location/([A-Za-z0-9]+)/([0-9.,]+)/([0-9.,]+)" => "device/setLocation/$1/$2/$3",
);