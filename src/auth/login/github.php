<?php
require("../../dbconnect.php");
require('../../models/users.php');

define('CLIENT_ID', '30693a31496631f37dce');
define('CLIENT_SECRET', 'e909c4a815fcd9b9f414d37422c1712e859330e7');

session_start();
unset($_SESSION['user_id']);

if (empty($_GET['code'])) {
    // Authrize URLの構築
    $params = array(
                    'client_id' => CLIENT_ID,
                    'scope' => 'user',  // 必須ではない。下記説明参照。
                    );
    $authorizeUrl = 'https://github.com/login/oauth/authorize?'
                . http_build_query($params);

    header('Location: ' . $authorizeUrl);
} else {
    // アクセストークン取得
    $accessTokenUrl = 'https://github.com/login/oauth/access_token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $accessTokenUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    $params = array(
                    'client_id' => CLIENT_ID,
                    'client_secret' => CLIENT_SECRET,
                    'code' => $_GET['code'],
                    );
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $res = curl_exec($curl);
    curl_close($curl);
    // echo $res;

    $value = explode("=", $res);
$value = explode("&",$value[1]);
$accessToken = $value[0];

// $_SESSION['token'] = $accessToken;

// var_dump($_SESSION['token']);
$url = "https://api.github.com/user?access_token=${accessToken}";

$header = [
    // headerに追加したい情報
    // 例）
    "Authorization: Bearer ${accessToken}",
    "User-Agent: Awesome-Octocat-App"
    ];

    $test=curl_init();
    curl_setopt($test,CURLOPT_URL, $url);
    curl_setopt($test, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($test, CURLOPT_HTTPHEADER, $header);
    curl_setopt($test,CURLOPT_SSL_VERIFYPEER, FALSE); // 証明書の検証を無効化
    curl_setopt($test,CURLOPT_SSL_VERIFYHOST, FALSE); // 証明書の検証を無効化
    curl_setopt($test,CURLOPT_RETURNTRANSFER, TRUE); // 返り値を文字列に変更
    curl_setopt($test,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡
    
    $output= curl_exec($test);
    
    // エラーハンドリング用
    $errno = curl_errno($test);
    // コネクションを閉じる
    curl_close($test);
    
    // エラーハンドリング
    if ($errno !== CURLE_OK) {
    //エラー処理
    }

    $userInfo = json_decode($output);
    


    if($userInfo->login){
        $condition = $userInfo->login;
        if(checkGithub($db, $condition)){
            $userId = checkGithub($db, $condition)[0]['id'];
            $_SESSION['user_id'] = $userId;
            header('Location: ../../index.php');
    }else{
        return;
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
    <title>Document</title>
</head>

<body>
    <p>aa</p>
</body>
<script src="../../js/api.js"></script>

</html>