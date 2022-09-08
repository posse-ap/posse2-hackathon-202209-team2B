<?php
require('./slack.php');
foreach ($events as $event) {

    $to = $event['userEmail'];
    $subject = "$title";
    // $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $user_name = $event['userName'];
    $event_start_date = $event['start_at'];
    $event_end_date = $event['end_at'];
    $event_name = $event['name'];
    $event_detail = $event['detail'];
    $event_body =
        <<<EOT
    {$user_name}さん\n
    ${event_start_date}~${event_end_date}に${event_name}を開催します。\n
    イベント内容：${event_detail}
    http://localhost/

    EOT;

    slack($event_body, '#ハッカソン');

    // mb_send_mail($to, $subject, $event_body, $headers);
    // echo "$to";
    // echo "$subject";
    // echo "$event_body";
    // echo "$headers";
}
