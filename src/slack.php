<?php
  $token = "xoxb-4054051295236-4052119093938-XFE0qpwwJu86gbYKT8fNP3xC";//上記でコピーした「OAuth Access Token」
  $channel = "ハッカソン";//投稿するチャンネル名(もしくはチャンネルID) 
  $text = "hello world";//投稿するメッセージ

  $channel = urlencode($channel);//文字列をURLエンコードする(例えば日本語はそのままURLとして使用できない)
  $text = urlencode($text);

  $url = "https://slack.com/api/chat.postMessage?token=${token}&channel=%23${channel}&text=${text}";
  $response = file_get_contents($url);
  return $response;//特に意味はない。

