<?php
require("../../dbconnect.php");

session_name();
session_start();

unset($_SESSION['user_id']);

if(!empty($_POST)) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(!empty($email) && !empty($password)){
  $login = $db->prepare('SELECT * FROM users WHERE email=?');
  $login->execute(array(
    $email
  ));
  $user = $login->fetch();
  if(password_verify($password, $user['password'])){
    $_SESSION['user_id'] = $user['id']; 
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?page_id=1");
    exit();
  }else{
    $err_msg = "メールまたはパスワードが違います";
  }
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
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ログイン</h2>
      <form action="/auth/login/index.php" method="POST">
        <input type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" name="email">
        <input type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" name="password">
        <?php 
        echo $err_msg;
        ?>
        <!-- <label class="inline-block mb-6">
          <input type="checkbox" checked>
          <span class="text-sm">ログイン状態を保持する</span>
        </label> -->
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="pasReset.php">パスワードを忘れた方はこちら</a>
      </div>
    </div>
  </main>
</body>

</html>