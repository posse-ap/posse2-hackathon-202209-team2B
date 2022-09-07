<?php 
    session_start();
    require('../../dbconnect.php');
    $error = [];
    $newPassword= $_POST['new'];
    $reset_mail = $_SESSION['reset_mail'];
    if($_POST){
    if ($newPassword === '') {
        $err_msg['password'] = '入力してください';
    }
      // 文字数チェック
    elseif (strlen($newPassword) > 255 || strlen($newPassword) < 5) {
        $err_msg['password'] = '６文字以上２５５文字以内で入力してください';
    }
      // 形式チェック
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $newPassword)) {
        $err_msg['password'] = '半角英数字で入力してください';
    }
    }

    if(empty($err_msg)){
        if (!empty($_POST)) {
        if ($_POST['new'] == $_POST['new_check']){
        $new_password = password_hash($_POST['new'], PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE `users` SET password=? WHERE `email`=?');
        $stmt->bindValue(1, $new_password, PDO::PARAM_STR);
        $stmt->bindValue(2, $reset_mail, PDO::PARAM_STR);
        $stmt->execute();
        $error['change'] = 'nothing';
        // header('Location: http://' . $_SERVER['HTTP_HOST'] . '/client/login.php');
        }else{
            $error['change'] = 'no_match';
            // echo '確認用と一致しませんでした';
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./login.css">
    <title>Schedule | POSSE</title>
</head>

<body>
    <header class="bg-white h-16">
        <div class="items-center w-full h-full mx-auto pl-2 pr-5">
            <div class="h-full">
                <img src="/img/header-logo.png" alt="" class="h-full w-1/2">
            </div>
        </div>
    </header>
    <main class="bg-gray-100 h-screen w-screen">
        <div class="text-center pt-10">
        <h1><span class="changing">パスワード変更画面です</span></h1>
    <section class="w-full">
        <form action="../login/reset.php" method="POST" class="login-container">
            <p class="pt-3 text-lg font-bold pb-3">新しいパスワード</p>
            <p><input type="password" name="new" placeholder="Password" class="h-16 w-4/5 rounded-md p-3 mb-4" required></p>
            <p class="pt-3 text-lg font-bold pb-3">新しいパスワード(確認)</p>
            <p><input type="password" name="new_check" placeholder="Password" class="h-16 w-4/5 rounded-md p-3 mb-4" required></p>
            <?php if (isset($error['change']) && $error['change'] === 'no_match') : ?>
                <span>確認用と一致しませんでした</span>
            <?php endif; ?>
            <?php
            if (!empty($err_msg['password'])){
                echo $err_msg['password'];
            }
            ?>
            <p><input type="submit" value="確定"></p>
            <?php if (isset($error['change']) && $error['change'] === 'nothing') : ?>
                <span>パスワードが変更されました、再ログインしてください</span>
            <?php endif; ?>
            <p class="pt-3"><a href="index.php" class="login-page">ログイン画面はこちら</a></p>
        </form>
    </section>
    </main>
        </div>
</body>

</html>