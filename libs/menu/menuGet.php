<?php
include_once('../utils.php');
header('Content-Type: text/html; charset=UTF-8');
$ACC_TOKEN=$utils->getAccessToken();

$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$ACC_TOKEN;

$cu = curl_init();
curl_setopt($cu, CURLOPT_URL, $MENU_URL);
curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
$menu_json = curl_exec($cu);
$menu = json_decode($menu_json);
curl_close($cu);

echo $menu_json;

?>