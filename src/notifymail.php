<?php
foreach ($events as $event) {

    $to = $event['userEmail'];
    $subject = "$title";
    $user_name = $event['userName'];
    $event_start_date = $event['start_at'];
    $event_end_date = $event['end_at'];
    $event_name = $event['name'];
    $event_detail = $event['detail'];
    $event_body =
        <<<EOT
    {$user_name}さん
    ${event_start_date}~${event_end_date}に${event_name}を開催します。
    イベント内容：${event_detail}
    http://localhost/

    EOT;
}
