<?php 
    session_start();
    require('../../dbconnect.php');
    $error = [];
    // echo $_SESSION['reset_mail'];
    $reset_mail = $_SESSION['reset_mail'];
    $new_password = sha1($_POST['new']);
    $stmt = $db->prepare('SELECT count(*) from users where password=?');
    $stmt->bindValue(1, $new_password, PDO::PARAM_STR);
    $stmt->execute();
    $exist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {
    if (intval($exist['count(*)'] == 0)) {
    if (sha1($_POST['new']) == sha1($_POST['new_check'])){
    $stmt = $db->prepare('UPDATE `users` SET password=? WHERE `email`=?');
    $stmt->bindValue(1, $new_password, PDO::PARAM_STR);
    $stmt->bindValue(2, $reset_mail, PDO::PARAM_STR);
    $stmt->execute();
    $error['change'] = 'nothing';
    // header('Location: http://' . $_SERVER['HTTP_HOST'] . '/client/login.php');
    // exit();
    }else{
        $error['change'] = 'no_match';
        echo '確認用と一致しませんでした';
    }
    }else{
        $error['change'] = 'no_one';
        echo '同じパスワードがすでに使われております。別のパスワードにしてください';
    }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <h1 class="reset_sentence">パスワード変更画面です</h1>
    <section class="login">
        <form action="../login/reset.php" method="POST" class="login-container">
            <p>新しいパスワード</p>
            <p><input type="password" name="new" placeholder="Password" required></p>
            <p>新しいパスワード(確認)</p>
            <p><input type="password" name="new_check" placeholder="Password" required></p>
            <?php if (isset($error['change']) && $error['change'] === 'no_match') : ?>
                <span>確認用と一致しませんでした</span>
            <?php endif; ?>
            <?php if (isset($error['change']) && $error['change'] === 'no_one') : ?>
                <span>同じパスワードがすでに使われております。別のパスワードにしてください</span>
            <?php endif; ?>
            <p><input type="submit" value="確定"></p>
            <?php if (isset($error['change']) && $error['change'] === 'nothing') : ?>
                <span>パスワードが変更されました、再ログインしてください</span>
            <?php endif; ?>
            <p><a href="index.php">ログイン画面はこちら</a></p>
        </form>
    </section>
</body>

</html>