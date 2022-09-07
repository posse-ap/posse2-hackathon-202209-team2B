<?php
require("./dbconnect.php");

session_name();
session_start();

unset($_SESSION['admin_id']);

if(!empty($_POST)) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(!empty($email) && !empty($password)){
  $login = $db->prepare('SELECT * FROM users WHERE email=? AND admin = 1');
  $login->execute(array(
    $email
  ));
  $user = $login->fetch();
  if(!empty($user) && password_verify($password, $user['password'])){
    $_SESSION['admin_id'] = $user['id']; 
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/adminTop.php");
    exit();
  }else{
    $err_msg = "メールまたはパスワードが違います";
  }
}else{
  $err_msg = "メールまたはパスワードが違います";
}
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>
<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5 bg-gray-100">
      <div class="h-full">
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>
  <main class="bg-gray-100 h-screen">
  <div class="w-full mx-auto p-5">
    <div class="font-bold text-base mt-4 mb-3">ログイン</div>
    <form action="/adminLogin.php" method="POST">
    <input type="email" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3 ">
        <input type="password" name="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3">
    </div>
    <?php 
        echo $err_msg;
        ?>
    <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/">パスワードを忘れた方はこちら</a>
      </div>
  </div>
  </main>
  <footer>

  </footer>
</body>
