<?php
  
  function slack($message, $channel)
{
    $ch = curl_init("https://slack.com/api/chat.postMessage");
    $data = http_build_query([
        "token" => "xoxb-4054051295236-4052119093938-L8w2lpq4tSWsK7gALMIJ9f3S",
    	"channel" => $channel, //"#mychannel",
    	"text" => $message, //"Hello, Foo-Bar channel message.",
    	"username" => "Test App"
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}

// Example message will post "Hello world" into the random channel
slack('Hello world', '#ハッカソン');

$url = "https://slack.com/api/users.lookupByEmail?email=naoki1010nissy@gmail.com&token=xoxb-4054051295236-4052119093938-L8w2lpq4tSWsK7gALMIJ9f3S";

$header = [
    // headerに追加したい情報
    // 例）
    "Authorization: Bearer xoxb-4054051295236-4052119093938-L8w2lpq4tSWsK7gALMIJ9f3S",
    "User-Agent: Awesome-Octocat-App",
    "Content-Type: application/json; charset=utf-8"
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
    var_dump($userInfo);





  ?>
