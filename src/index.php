<?php
require('dbconnect.php');
require('./models/event_attendance.php');

session_start();

if (empty($_SESSION['user_id'])) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] . "/auth/login/index.php");
  exit();
}

if($_GET['page_id'] >= 1){
  $page_id = $_GET['page_id'];
}else{
  $page_id = 1;
}
//何ページ目かわかる
$condition = 10*($page_id - 1);


$status = $_GET["status"];
$today = date("Y-m-d");
$user_id = $_SESSION['user_id'];
if (!$_GET["status"]) {
  $stmt = $db->query("SELECT events.id as eventId, event_attendance.id, events.name, events.start_at,events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE  events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC LIMIT $condition, 10");
  $stmt->execute();
  $events = $stmt->fetchAll();
  $stmt = $db->query("SELECT * FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE  events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC");
  $counter = $stmt->fetchAll();
  $count = count($counter);

  //一ページに表示する記事の数をmax_viewに定数として定義
define('max_view',10);
$max_page = ceil($count/max_view);


$max_page = ceil($count/max_view);
} elseif ($_GET["status"] == 1 || $_GET["status"] == 2 || $_GET["status"] == 3) {
  if ($_GET["status"] == 1) {
    $stmt = $db->query("SELECT events.id as eventId, event_attendance.id, events.name, events.start_at, events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.participation='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC LIMIT $condition, 10");
    $stmt->execute();
    $events = $stmt->fetchAll();
    $stmt = $db->query("SELECT *  FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.participation='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC ");
    $counter = $stmt->fetchAll();
    $count = count($counter);

    //一ページに表示する記事の数をmax_viewに定数として定義
  define('max_view',10);
  $max_page = ceil($count/max_view);
  
  } elseif ($_GET["status"] == 2) {
    $stmt = $db->query("SELECT events.id as eventId, event_attendance.id, events.name, events.start_at, events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.nonparticipation='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC LIMIT $condition, 10");
    $stmt->execute();
    $events = $stmt->fetchAll();
    $stmt = $db->query("SELECT * FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.nonparticipation='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC");
    $counter = $stmt->fetchAll();
    $count = count($counter);

    //一ページに表示する記事の数をmax_viewに定数として定義
  define('max_view',10);
  $max_page = ceil($count/max_view);
  
  } elseif ($_GET["status"] == 3) {
    $stmt = $db->query("SELECT events.id as eventId, event_attendance.id, events.name, events.start_at, events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.notsubmitted='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC LIMIT $condition, 10");
    $stmt->execute();
    $events = $stmt->fetchAll();
    $stmt = $db->query("SELECT * FROM event_attendance INNER JOIN events ON event_attendance.event_id=events.id WHERE event_attendance.notsubmitted='1' AND events.start_at >= '$today' AND event_attendance.user_id= '$user_id' GROUP BY  event_attendance.id  ORDER BY events.start_at ASC");
    $counter = $stmt->fetchAll();
    $count = count($counter);

    //一ページに表示する記事の数をmax_viewに定数として定義
  define('max_view',10);
  $max_page = ceil($count/max_view);
  
  };
}
// $stmt = $db->query("SELECT events.id
//                     AS eventId, event_attendance.id, events.name, events.start_at, events.end_at,event_attendance.user_id,event_attendance.participation,event_attendance.nonparticipation,event_attendance.notsubmitted, count(event_attendance.id) AS total_participants  
//                     FROM event_attendance 
//                     INNER JOIN events ON event_attendance.event_id=events.id 
//                     WHERE $where
//                     GROUP BY  event_attendance.id  
//                     ORDER BY events.start_at 
//                     ASC");
// $stmt->execute();
// $events = $stmt->fetchAll();



function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link href="top.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
      <!-- 
      <div>
        <a href="/auth/login" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ログイン</a>
      </div>
      -->
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">フィルター</h2>
        <div class="flex">
          <?php
          if (!$_GET["status"]) {
            echo
            '
            <a href="/" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">全て</a>
            <a href="/?status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a>
            <a href="/?status=2" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a>
            <a href="/?status=3" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a>
  
            ';
          } elseif ($_GET["status"] == 1 || $_GET["status"] == 2 || $_GET["status"] == 3) {
            if ($_GET["status"] == 1) {
              echo
              '
              <a href="/" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">全て</a>
              <a href="/?status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">参加</a>
              <a href="/?status=2" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a>
              <a href="/?status=3" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a>
              ';
            } elseif ($_GET["status"] == 2) {
              echo
              '
              <a href="/" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">全て</a>
              <a href="/?status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a>
              <a href="/?status=2" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">不参加</a>
              <a href="/?status=3" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a>
              ';
            } elseif ($_GET["status"] == 3) {
              echo
              '
              <a href="/" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">全て</a>
              <a href="/?status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a>
              <a href="/?status=2" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a>
              <a href="/?status=3" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">未回答</a>
              ';
            };
          }
          ?>
        </div>
      </div>

      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
        </div>

        <?php foreach ($events as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          $attendanceUserByEvent = getUserByAttendanceStatusByEvent($db, $event['eventId']);
          ?>
          <form class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?= $event['eventId']; ?>">
            <input type="hidden" name="eventId" value="<?= $event['name'] ?>">
            <div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <div>
                <?php
                if (!$_GET["status"]) {
                  if ($event["notsubmitted"] == 1) {
                    echo
                    '
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 ';
                ?>
                  <?php echo date("m月d日", strtotime('-3 day', $end_date));
                    echo '</p>';
                  } elseif ($event["nonparticipation"] == 1) {
                    echo
                    '
                  <p class="text-sm font-bold text-gray-300">不参加</p>
                  ';
                  } elseif ($event["participation"] == 1) {
                    echo
                    '
                  <p class="text-sm font-bold text-green-400">参加</p>
                  ';
                  };
                } elseif ($_GET["status"] == 1 || $_GET["status"] == 2 || $_GET["status"] == 3) {
                  if ($_GET["status"] == 3) {
                    echo
                    '
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 ';
                  ?>
                <?php echo date("m月d日",  $end_date);
                    echo '</p>';
                  } elseif ($_GET["status"] == 2) {
                    echo
                    '
                  <p class="text-sm font-bold text-gray-300">不参加</p>
                  ';
                  } elseif ($_GET["status"] == 1) {
                    echo
                    '
                  <p class="text-sm font-bold text-green-400">参加</p>
                  ';
                  };
                }

                ?>
              </div>
            </div>
          </form>
          <div id="accordion" class="accordion-container">
                <h4 class="accordion-title js-accordion-title">
                  <p class="text-sm"><span class="text-xl"><?php echo count($attendanceUserByEvent); ?></span>人参加 ></p>
                </h4>
                <div class="accordion-content">
                <?php foreach ($attendanceUserByEvent as $attendanceUser) : ?>
                  <p><?= $attendanceUser['name'] ?></p>
                  <?php endforeach; ?>
                </div>
          </div>
        <?php endforeach; ?>
        <div class="paging">
        <?php if($status == 1 || $status == 2 || $status == 3){?>
        <?php for($i = 1; $i <= $max_page; $i++){ ?>
          <?php if($i == $page_id){ ?>
            <a tabindex="-1"><?= $i ?></a>
          <?php }else{ ?>
            <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . "/index.php?page_id=$i&status=$status"?>"><?= $i ?></a>
          <?php } ?> 
        <?php } ?>
        <?php } else {?>
          <?php for($i = 1; $i <= $max_page; $i++){ ?>
          <?php if($i == $page_id){ ?>
            <a tabindex="-1"><?= $i ?></a>
          <?php }else{ ?>
            <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . "/index.php?page_id=$i"?>"><?= $i ?></a>
          <?php } ?> 
        <?php } ?>
        <?php } ?>
        </div>
      </div>
    </div>
  </main>

  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <div id="modalInner"></div>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="/js/main.js"></script>
</body>

</html>