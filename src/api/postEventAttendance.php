<?php
session_start();
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

$participationId = $_POST['eventId_0'];
$nonparticipationId = $_POST['eventId_1'];
$userId = $_SESSION['user_id'];

if (!empty($participationId) && empty($nonparticipationId)) {
  $stmt = $db->prepare('UPDATE event_attendance SET participation=1, nonparticipation=0, notsubmitted=0 WHERE event_id =? AND user_id =?');
  $stmt->execute(array($participationId, $userId));
}elseif(empty($participationId) && !empty($nonparticipationId)){
  $stmt = $db->prepare('UPDATE event_attendance SET participation=0, nonparticipation=1, notsubmitted=0 WHERE event_id =? AND user_id =?');
  $stmt->execute(array($nonparticipationId, $userId));
}
