<?php 
session_start();

if (empty($_SESSION['admin_id'])) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] . "/adminlogin.php");
  exit();
}
require("dbconnect.php");
include('header.php');

$today = date("Y-m-d");

$stmt = $db->query("SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id WHERE events.start_at >= '$today' GROUP BY events.id");
$events = $stmt->fetchAll();

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<main>
  <section class="bg-gray-100 h-screen">
    <?php foreach($events as $event){?>
    <div class="status-box">
      <div class="text-left pt-3 "><a class="font-bold pb-3"><?= $event['name']?></a><br>
        <a class="text-md leading-3"><?= date('Y年n月j日', strtotime($event['start_at'])) ?></a><br>
        <a class="text-sm leading-3"><?= date('H:i', strtotime($event['start_at'])) . '~' . date('H:i', strtotime($event['end_at'])) ?></a>
      </div>
      <div class="pt-3 ml-10 text-right align-middle text-blue-400"><a href="#" class=" text-sm">参加者一覧</a><br>
        <a href="editEvent.php?id=<?=$event['id']?>" class="text-sm">編集</a><br>
        <a href="#" class="text-sm">削除</a>
      </div>
    </div>
    <?php } ?>
  </section>
</main>
<?php include('footer.php') ?>