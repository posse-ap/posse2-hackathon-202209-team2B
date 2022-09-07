<?php
require('dbconnect.php');
require('./models/events.php');
  if ($_POST) {
    //その他の取得
    $name = $_POST['name'];
    $startedTime = $_POST['started-time'];
    $start = strtotime($startedTime);
    $finishedTime = $_POST['finished-time'];
    $finish = strtotime($finishedTime);
    $deadline = $_POST['deadline'];
    $dead = strtotime($deadline);
    $detail = $_POST['detail'];
    if($finish >= $start){
      if($start >= $dead){
      eventCreate($db, $name, $startedTime, $finishedTime, $deadline, $detail); 
      header('Location: adminTop.php' );
      }else{
        $err_msg = "締め切り日を開始時刻より前にしてください。";
      }
    }else{
      $err_msg = "開始時刻を終了時刻より前にしてください。";
    }
  }
?>
<?php include('head.php')?>
<body class="bg-gray-100 h-screen w-screen">
<?php include('header.php')?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <main class="bg-gray-100 flex justify-center h-screen w-screen">
  <form action="addEvent.php" method="POST" class="w-full text-center">
  <h1 class="text-2xl font-bold mt-5">イベント追加画面</h1>
    <p class="mt-3 text-left ml-12 mb-2">イベント名</p>
      <input name="name" type="text" placeholder="イベント名" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
    <p class="mt-3 text-left ml-12 mb-2">開始時刻</p>
      <input type="date" name="started-time" id="start_display" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">終了時刻</p>
      <input type="date" name="finished-time" id="end_display" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">締切日</p>
    <input type="date" name="deadline" id="end_submit" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg">
    <?php
    if(!empty($err_msg)){?>
      <div><?= $err_msg; ?></div> 
    <?php
    }
    ?>
      <p class="mt-3 text-left ml-12 mb-2">イベント詳細</p>
      <textarea name="detail" rows="10" cols="60" class="w-3/4 h-20 p-4 text-sm mb-3 rounded-lg"></textarea>
    <div class="flex justify-center">
      <div class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full">
        <button type="submit" class="text-white font-bold leading-10">追加</button>
      </div>
    </div>
  </form>
  </main>
              <script>
              const config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
              }
              var start_calender = document.getElementById("start_display");
              var fp = flatpickr(start_calender, config);

              var end_calender = document.getElementById("end_display");
              var fd = flatpickr(end_calender, config);

              var dead_calender = document.getElementById("end_submit");
              var fd = flatpickr(dead_calender, config);
              </script>
</body>