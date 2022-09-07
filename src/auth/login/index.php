<?php
require("../../dbconnect.php");

session_name();
session_start();

unset($_SESSION['user_id']);

if (!empty($_POST)) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(isset($email) && isset($password)){
    // eメールアドレスバリデーションチェック
    // 空白チェック
    if ($email === '') {
      $err_msg['email'] = 'メールアドレスは入力必須です';
    }
    // 文字数チェック
    elseif (strlen($email) > 255) {
      $err_msg['email'] = 'メールアドレスは255文字で入力してください';
    }
    // パスワードバリデーションチェック
    // 空白チェック
    elseif ($password === '') {
      $err_msg['password'] = 'パスワードを入力してください';
    }
    // 文字数チェック
    elseif (strlen($password) > 255 || strlen($password) < 5) {
      $err_msg['password'] = 'パスワードは６文字以上２５５文字以内で入力してください';
    }
    // 形式チェック
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
      $err_msg['password'] = 'パスワードは半角英数字で入力してください';
    }
  }
}

if(!empty($_POST)) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(!empty($email) && !empty($password)){
  $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
  $login->execute(array(
    $_POST['email'],
    $_POST['password']
  ));
  $user = $login->fetch();
  if($user && empty($err_msg)){
    $_SESSION['user_id'] = $user['id']; 
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php");
    exit();
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
        <?php 
        if(!empty($err_msg)){
          echo $err_msg['email'];
        }
        ?>
        <input type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" name="password">
        <?php 
        if(!empty($err_msg)){
          echo $err_msg['password'];
        }
        ?>
        <!-- <label class="inline-block mb-6">
          <input type="checkbox" checked>
          <span class="text-sm">ログイン状態を保持する</span>
        </label> -->
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/">パスワードを忘れた方はこちら</a>
      </div>
    </div>
  </main>
</body>

</html>