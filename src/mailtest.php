<?php
require("dbconnect.php");
require(realpath("models/event_attendance.php"));
mb_language('ja');
mb_internal_encoding('UTF-8');

$to = "hackathon-teamX@posse-ap.com";
$subject = "PHPからメール送信サンプル";
$body = "本文";
$headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];

$name = "テスト";
$date = "2022年08月01日（日） 21:00~23:00";
$event = "縦モク";
$body = <<<EOT
{$name}さん

${date}に${event}を開催します。
参加／不参加の回答をお願いします。

http://localhost/
EOT;

mb_send_mail($to, $subject, $body, $headers);
echo "メールを送信しました";

$condition = 'participation';
var_dump(getUserByAttendanceStatus($db, $condition));