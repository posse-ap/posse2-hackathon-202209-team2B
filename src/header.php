<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Schedule | POSSE</title>
</head>

<body class="bg-gray-100 h-screen w-screen">


  <header class="header">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
    <input type="checkbox" id="menu" />
    <label for="menu" class="menu">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <nav class="nav">
      <ul class="font-bold">
        <li><a href="adminTop.php">イベント一覧</a></li>
        <li><a href="addEvent.php">イベント追加</a></li>
        <li class="last-sentense"><a href="addMember.php">ユーザー追加</a></li>
      </ul>
      <div class="touser">
        <a href="../auth/login/index.php">ユーザ画面へ</a><br><br>
        <a href="../auth/login/index.php">ログアウト</a>
      </div>
    </nav>
  </header>