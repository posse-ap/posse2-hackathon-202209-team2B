<?php
require('dbconnect.php');
require('./models/events.php');
  if ($_POST) {
    //その他の取得
    $name = $_POST['name'];
    var_dump($_POST['started-time']);
    $startedTime = $_POST['started-time'];
    $startedTime = strtotime($startedTime);
    var_dump($startedTime);
    $startedTime = DateTime::createFromFormat(DateTime::ISO8601,$startedTime);
    $finishedTime = $_POST['finished-time'];
    $finishedTime = DateTime::createFromFormat(DateTime::ISO8601,$finishedTime);
    $deadline = $_POST['deadline'];
    $deadline = DateTime::createFromFormat(DateTime::ISO8601,$deadline);

    $detail = $_POST['detail'];
    eventCreate($db, $name, $startedTime,$finishedTime, $deadline, $detail);
    header('Location: adminTop.php' );
  }
?>
<?php include('head.php')?>
<body class="bg-gray-100 h-screen w-screen">
<?php include('header.php')?>
  <main class="bg-gray-100 flex justify-center h-screen w-screen">
  <form action="addEvent.php" method="POST" class="w-full text-center">
  <h1 class="text-2xl font-bold mt-5">イベント追加画面</h1>
    <p class="mt-3 text-left ml-12 mb-2">イベント名</p>
      <input name="name" type="text" placeholder="イベント名" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
    <p class="mt-3 text-left ml-12 mb-2">開始時刻</p>
      <input type="datetime-local" name="started-time" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">終了時刻</p>
      <input type="datetime-local" name="finished-time" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">締切日（任意）</p>
    <input type="datetime-local" name="deadline" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg">
      <p class="mt-3 text-left ml-12 mb-2">イベント詳細</p>
      <textarea name="detail" rows="10" cols="60" class="w-3/4 h-20 p-4 text-sm mb-3 rounded-lg"></textarea>
    <div class="flex justify-center">
      <div class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full">
        <button type="submit" class="text-white font-bold leading-10">追加</button>
      </div>
    </div>
  </form>
  </main>
</body>