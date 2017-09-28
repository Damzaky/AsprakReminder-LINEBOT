<?php
require __DIR__ . '/vendor/autoload.php';
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('	TOKEN	');//ganti jadi channel tokenmu
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '	SECRET	']);//ganti jadi channel secret botmu

$h = file_get_contents('https://	YOURHOSTING.domain	/getsheet.php');//ganti jadi URL tempat kamu naro file getsheet.php
if ($h!="no") {
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($h);
$response = $bot->pushMessage('	USER ID / ROOM ID / GROUP ID YANG DITUJU', $textMessageBuilder);//ganti jadi ID yang dituju
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}
?>