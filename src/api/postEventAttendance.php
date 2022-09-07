<?php
session_start();
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

$eventId = $_POST['eventId'];
$userId = $_SESSION['user_id'];

if ($eventId > 0) {
  $stmt = $db->prepare('UPDATE event_attendance SET participation=1, nonparticipation=0, notsubmitted=0 WHERE event_id =? AND user_id =?');
  $stmt->execute(array($eventId, $userId));
}
