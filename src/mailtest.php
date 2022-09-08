

<?php


require("dbconnect.php");
mb_language('ja');
mb_internal_encoding('UTF-8');


$event_day =  strtotime('+1 day'). "\n";
$stmt = $db->query("SELECT events.id AS eventId, event_attendance.id, events.name, events.start_at,events.end_at,event_attendance.user_id,users.name AS userName,users.email AS userEmail,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
                    FROM event_attendance 
                    INNER JOIN events ON event_attendance.event_id=events.id 
                    INNER JOIN users ON event_attendance.user_id=users.id 
                    WHERE  DATE_FORMAT(events.start_at, '%Y-%m-%d') >= '$event_day' 
                    GROUP BY  event_attendance.id 
                    ORDER BY events.start_at 
                    ASC");
$stmt->execute();
$events = $stmt->fetchAll();
echo ($event_day);

foreach ( $events as $event){

    
    
    $to = $event['userEmail'];
    $subject = "PHPからメール送信サンプル";
    $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
    $user_name = $event['userName'];
    $event_start_date = $event['start_at'];
    $event_end_date = $event['end_at'];
    $event_name = $event['name'];
    $event_body =
    <<<EOT
    {$user_name}さん
    ${event_start_date}~${event_end_date}に${event_name}を開催します。
    参加／不参加の回答をお願いします。
    http://localhost/
    EOT;
    
    mb_send_mail($to, $subject, $event_body, $headers);
    echo "$to";
    echo "$subject";
    echo "$event_body";
    echo "$headers";
}
