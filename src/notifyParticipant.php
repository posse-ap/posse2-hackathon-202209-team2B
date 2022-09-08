<?php

require("dbconnect.php");
require("./slack.php");
mb_language('ja');
mb_internal_encoding('UTF-8');


$objDateTime = new DateTime('tomorrow');
$event_day=$objDateTime->format('Y-m-d');
$stmt = $db->query("SELECT events.id AS eventId, event_attendance.id, events.name, events.start_at,events.end_at,events.detail,event_attendance.user_id,users.name AS userName,users.email AS userEmail,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
                    FROM event_attendance 
                    INNER JOIN events ON event_attendance.event_id=events.id 
                    INNER JOIN users ON event_attendance.user_id=users.id 
                    WHERE  DATE_FORMAT(events.start_at, '%Y-%m-%d') = '$event_day' AND event_attendance.participation='1'
                    GROUP BY  event_attendance.id 
                    ORDER BY events.id
                    ASC");
$stmt->execute();
$events = $stmt->fetchAll();


foreach($events as $event){
  if($event['eventId'] != $_SESSION['event_id']){
    $eventId = $event['eventId'];
    $stmt = $db->query("SELECT events.id AS eventId, event_attendance.id, events.name, events.start_at,events.end_at,events.detail,event_attendance.user_id,users.name AS userName,users.email AS userEmail,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
    FROM event_attendance 
    INNER JOIN events ON event_attendance.event_id=events.id 
    INNER JOIN users ON event_attendance.user_id=users.id 
    WHERE  DATE_FORMAT(events.start_at, '%Y-%m-%d') = '$event_day' AND event_attendance.participation='1' AND events.id = $eventId GROUP BY  event_attendance.id");
    $stmt->execute();
    $participations = $stmt -> fetchAll();
    // var_dump($participations);
    $member = array();
    foreach($participations as $participation){
      $user_name = "";
      $user_name = $participation['userName'];
      // echo $user_name;
      $member = array_merge($member, (array)$user_name);
    }
    $event_start_date = $event['start_at'];
    $event_end_date = $event['end_at'];
    $event_name = $event['name'];
    $event_detail = $event['detail'];
    var_dump($member);
    $lists = implode('@', $member);
    $body_message =
          <<<EOT
    @$lists\n
    ${event_start_date}~${event_end_date}に${event_name}を開催します。\n
    イベント内容：${event_detail}
    http://localhost/

    EOT;
    slack($body_message, '#ハッカソン');
    unset($_SESSION['event_id']);
    $_SESSION['event_id'] = $event['eventId'];
  }
}

$title = "イベント前日です。参加者の皆さんは忘れないようにお願いします。";
echo ($event_day);


// require('notifymail.php');