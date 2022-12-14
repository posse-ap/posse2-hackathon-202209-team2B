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
        <h1 ><span class="advice">パスワードの再設定が必要です</span></h1><br>
    <p class="text-md">
        恐れ入りますが、<span class="address">登録されたメールアドレス</span>をご入力いただき、<br><br>
        受信されたメールの案内にしたがってパスワードの再設定をお願いします。
    </p>

    <section class="w-full">
        <form action="pasReset.php" method="POST" class="w-screen h-screen">
            <p class="pt-10 text-sm pb-3">登録しているメールアドレス</p>
            <p><input type="mail" name="mail" placeholder="mail" class="h-16 w-4/5 rounded-md p-3 mb-4" required></p>
                <input type="submit" value="確定">
        </form>
    </section>
    <?php if ($ret) : ?>
        <p class="reset_sentence4">
            記入いただいたメールアドレス宛にメールを送信しました<br><br>
            確認した後、パスワードの再設定をお願いします。
        <?php endif; ?>
        </p>
        </div>
    </main>
</body>

</html>