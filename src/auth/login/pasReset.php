<?php
session_start();
require("../../dbconnect.php");

if (!empty($_POST)) {
    $login = $db->prepare('SELECT * FROM users WHERE email=?');
    $login->execute(array(
        $_POST['mail']
    ));
    $user = $login->fetch();

    if ($user) {
        $mail = $_POST['mail'];
        $_SESSION['reset_mail'] = $mail;
        $passResetToken = md5(uniqid(rand(), true));
        date_default_timezone_set('Asia/Tokyo');
        $stmt = $db->prepare(
            'INSERT INTO 
            `userpassreset` (
                `token`,
                `mail`
            ) 
        VALUES
            (?,?)
        '
        );
        $stmt->bindValue(1, $passResetToken, PDO::PARAM_STR);
        $stmt->bindValue(2, $mail, PDO::PARAM_STR);
        $stmt->execute();

        mb_language("ja");
        mb_internal_encoding("UTF-8");


        $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
        $to = $mail;
        $title = 'パスワード変更について';
        $content = "以下のリンクからパスワードの再設定をよろしくお願いします。\n\n http://localhost/auth/login/pasReset.php?token=" . $passResetToken;
        $ret = mb_send_mail($to, $title, $content, $headers);
    } else {
        echo 'メールアドレスが正しくありません';
        $error = 'fail';
    }
}


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $SQL = "SELECT * FROM userpassreset where token = ?";
    $stmt = $db->prepare($SQL);
    $stmt->bindValue(1, $token, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($data)) {
        echo $error;
        exit;
    } else {
        $limitTime = date("Y-m-d H:i:s", strtotime("-10 minute"));
    }
    if ((strtotime($data["updated_at"])) >= strtotime($limitTime)) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/login/reset.php');
    } else {
        echo '失敗';
    }
}

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
    <header>
    </header>
    <h1 class="reset_sentence2">パスワードの再設定が必要です</h1><br>
    <p class="reset_sentence3">
        恐れ入りますが、登録されたメールアドレスをご入力いただき、<br><br>
        受信されたメールの案内にしたがってパスワードの再設定をお願いします。
    </p>

    <section class="login">
        <form action="pasReset.php" method="POST" class="login-container">
            <p>登録しているメールアドレス</p>
            <p><input type="mail" name="mail" placeholder="mail" required></p>
            <input type="submit" value="確定">
        </form>
    </section>
    <?php if ($ret) : ?>
        <p class="reset_sentence4">
            記入いただいたメールアドレス宛にメールを送信しました<br><br>
            確認した後、パスワードの再設定をお願いします。
        <?php endif; ?>
        </p>
</body>

</html>