<?php
//イベントとユーザで絞り込む
function getEventStatus($db, $eventId, $userId)
{
    $stmt = $db->prepare("select participation, nonparticipation, notsubmitted  from event_attendance where event_id = $eventId and user_id = $userId ");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}