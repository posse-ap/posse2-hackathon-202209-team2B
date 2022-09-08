

<?php


require("dbconnect.php");
mb_language('ja');
mb_internal_encoding('UTF-8');


$event_day = date("Y-m-d", strtotime('+3 day')). "\n";
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

$to = "hackathon-teamX@posse-ap.com";
$subject = "PHPからメール送信サンプル";
$body = "本文";
$headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];

$name = "テスト";
$date = "2021年08月01日（日） 21:00~23:00";
$event = "縦モク";
$body = 
<<<EOT
{$name}さん
${date}に${event}を開催します。
参加／不参加の回答をお願いします。
http://localhost/
EOT;

mb_send_mail($to, $subject, $body, $headers);
echo "donedone";
echo "$to";
echo "$subject";
echo "$body";
echo "$headers";

// if (mail("example@example.com", "TEST MAIL", "This is a test message.", "From: from@example.com")) {
//     echo "メールが送信されました。";
//   } else {
//     echo "メールの送信に失敗しました。";
//   }
  

// $event_day = date("Y-m-d", strtotime('+3 day')). "\n";
// $stmt = $db->query("SELECT events.id 
//                     AS eventId, event_attendance.id, events.name, events.start_at,events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
//                     FROM event_attendance 
//                     INNER JOIN events ON event_attendance.event_id=events.id 
//                     WHERE  DATE_FORMAT(events.start_at, '%Y-%m-%d') = '$event_day' 
//                     GROUP BY  event_attendance.id 
//                     ORDER BY events.start_at 
//                     ASC");
// $stmt->execute();
// $events = $stmt->fetchAll();

// foreach ($events as $event){


//     $event_name= $event['name'];
//     $event_start_at= $event['start_at'];
//     $event_end_at= $event['end_at'];

//     $to = "";
//     $subject = "イベント開催のお知らせ";
//     $body = "$event";
//     $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
    
//     $name = "博士太朗";
//     $date = "$event_start_at ~ $event_end_at";
//     $event = "$event_name";
//     $body = <<<EOT
//     {$name}さん
    
//     ${date}に${event}を開催します。
//     参加／不参加の回答をお願いします。
    
//     http://localhost/
//     EOT;




// if (mb_send_mail("example@example.com", $subject,$body , $headers)) {
//     echo "メールが送信されました。";
//   } else {
//     echo "メールの送信に失敗しました。";
//   }
  
  
    
    // mb_send_mail($to, $subject, $body, $headers);
    // echo "メールを送信しました";
    
    // $condition = 'participation';
    // var_dump($date);
    // var_dump(getUserByAttendanceStatus($db, $condition));
// }
