<?php 
require("dbconnect.php");
include('header.php') ?>
<main class="bg-gray-100 flex justify-center h-screen w-screen">
  <div class="w-full text-center h-full">
    <h1 class="text-2xl font-bold mt-5">イベント編集画面</h1>
    <p class="mt-3 text-left ml-12 mb-2">イベント名</p>
      <input type="text" placeholder="イベント" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
    <p class="mt-3 text-left ml-12 mb-2">開始時刻</p>
      <input type="datetime-local" name="started-time" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">終了時刻</p>
      <input type="datetime-local" name="finished-time" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">締切日（任意）</p>
    <input type="datetime-local" name="deadline" class="w-3/4 h-15 p-4 text-sm mb-3 rounded-lg" required>
      <p class="mt-3 text-left ml-12 mb-2">イベント詳細</p>
      <textarea rows="10" cols="60" class="w-3/4 h-20 p-4 text-sm mb-3 rounded-lg"></textarea>
    <div class="flex justify-center mb-10">
      <div class="mt-3 text-center w-3/4 h-10 bg-gradient-to-r from-blue-500 to-blue-200 rounded-full" required>
        <p class="text-white font-bold leading-10">変更</p>
      </div>
    </div>
  </div>
</main>
<?php include('footer.php') ?>