<?php

require("dbconnect.php");
mb_language('ja');
mb_internal_encoding('UTF-8');


$objDateTime = new DateTime('+3 day ');
$event_day=$objDateTime->format('Y-m-d');
$stmt = $db->query("SELECT events.id AS eventId, event_attendance.id, events.name, events.start_at,events.end_at,events.detail,event_attendance.user_id,users.name AS userName,users.email AS userEmail,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
                    FROM event_attendance 
                    INNER JOIN events ON event_attendance.event_id=events.id 
                    INNER JOIN users ON event_attendance.user_id=users.id 
                    WHERE  DATE_FORMAT(events.start_at, '%Y-%m-%d') = '$event_day' AND event_attendance.notsubmitted='1'
                    GROUP BY  event_attendance.id 
                    ORDER BY events.start_at 
                    ASC");
$stmt->execute();
$events = $stmt->fetchAll();
$title = "イベント3日前です。このメールが送られた方は今すぐ回答をお願いします。";
echo ($event_day);

require('notsubmittedmail.php');