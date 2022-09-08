<?php
//イベントとユーザで絞り込む
function getEventStatus($db, $eventId, $userId)
{
    $stmt = $db->prepare("select participation, nonparticipation, notsubmitted  from event_attendance where event_id = $eventId and user_id = $userId ");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}

//イベントの出欠ステータスに応じたユーザを取得
function getUserByAttendanceStatus($db, $condition)
{
    $stmt = $db->prepare("select events.name, events.start_at, users.name from event_attendance inner join users on users.id = event_attendance.user_id inner join events on events.id = event_attendance.event_id where $condition = 1 && start_at >= now() order by events.name");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}

//イベントごとの参加答者を取得
function getUserByAttendanceStatusByEvent($db, $eventId)
{
    $stmt = $db->prepare("select events.name, events.start_at, users.name from event_attendance inner join users on users.id = event_attendance.user_id inner join events on events.id = event_attendance.event_id where participation = 1 && event_id = $eventId && start_at >= now() order by events.name");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}