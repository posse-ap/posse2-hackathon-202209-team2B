<?php 
require("./dbconnect.php");
require('./models/events.php');

session_start();

if(!empty($_GET['id'])){
$id = $_GET['id'];
$stmt = $db->query("SELECT * FROM events WHERE id = $id");
$event = $stmt -> fetch();
}

if($_POST){
  $event_id = $_POST['id'];
  $condition = "id = $event_id";
  $edit_name = $_POST['edit_name'];
  $edit_start= $_POST['edit_start'];
  $start = strtotime($edit_start);
  $edit_end = $_POST['edit_end'];
  $finish = strtotime($edit_end);
  $edit_limit = $_POST['edit_limit'];
  $dead = strtotime($edit_limit);
  $edit_detail = $_POST['edit_detail'];
  if(strlen($edit_name) < 255){
    if(strlen($edit_detail) < 255){
      if($finish >= $start){
        if($start >= $dead){
          eventUpdate($db, $edit_name, $edit_start, $edit_end, $edit_limit, $edit_detail, $condition);
          header("Location: http://" . $_SERVER['HTTP_HOST'] . "/adminTop.php");
          exit();
        }else{
          unset($_SESSION['err_msg']);
          $_SESSION['err_msg'] = "締め切り日を開始時刻より前にしてください。";
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/editEvent.php?id=$event_id");
        exit();
        }
      }else{
        unset($_SESSION['err_msg']);
          $_SESSION['err_msg'] = "開始時刻を終了時刻より前にしてください。";
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/editEvent.php?id=$event_id");
        exit();
      }
    }else{
      unset($_SESSION['err_msg']);
      $_SESSION['err_msg'] = "詳細は255文字以内で記載してください。";
      header("Location: http://" . $_SERVER['HTTP_HOST'] . "/editEvent.php?id=$event_id");
      exit();
    }
  }else{
    unset($_SESSION['err_msg']);
          $_SESSION['err_msg'] = "イベント名は255文字以内で記載してください。";
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/editEvent.php?id=$event_id");
    exit();
}
}
?>
<?php include('header.php') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<main class="bg-gray-100 flex justify-center h-screen w-screen">
  <div class="w-full text-center h-full">
    <h1 class="text-2xl font-bold mt-5">イベント編集画面</h1>
    <form action="/editEvent.php" method="post"> 
      <input type="hidden" value="<?= $event['id'] ?>" name="id">
    <p class="mt-3 text-left ml-12 mb-2">イベント名</p>
      <input type="text" placeholder="イベント" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="<?= $event['name'] ?>" name="edit_name" required>
    <p class="mt-3 text-left ml-12 mb-2">開始時刻</p>
      <input id="edit_start" type="datetime-local" name="edit_start" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="<?= $event['start_at'] ?>" name="edit_start" required>
      <p class="mt-3 text-left ml-12 mb-2">終了時刻</p>
      <input id="edit_end" type="datetime-local" name="edit_end" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="<?= $event['end_at'] ?>" name="edit_end" required>
      <p class="mt-3 text-left ml-12 mb-2">締切日（任意）</p>
    <input id="edit_limit" type="datetime-local" name="edit_limit" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" value="<?= $event['deadline'] ?>" name="edit_limit" required>
      <p class="mt-3 text-left ml-12 mb-2">イベント詳細</p>
      <textarea name="edit_detail" rows="10" cols="60" class="w-3/4 h-20 p-4 text-sm mb-3 rounded-lg" ><?= $event['detail'] ?></textarea>
      <?php
      if(!empty($_SESSION['err_msg'])){
      ?>
        <div><?= $_SESSION['err_msg'];?></div>
      <?php
      }
      ?>
    <div class="flex justify-center mb-10">
      <label for="edit_submit" class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full" required>
        <input id="edit_submit" type="submit" class="bg-transparent text-white font-bold leading-10" value="変更">
      </div>
    </div>
    </form>
  </div>
  <script>
              const config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
              }
              var start_calender = document.getElementById("edit_start");
              var fp = flatpickr(start_calender, config);

              var end_calender = document.getElementById("edit_end");
              var fd = flatpickr(end_calender, config);

              var dead_calender = document.getElementById("edit_limit");
              var fd = flatpickr(dead_calender, config);
              </script>
</main>
<?php include('footer.php') ?>