<?php
  
  function slack($message, $channel)
{
    $ch = curl_init("https://slack.com/api/chat.postMessage");
    $data = http_build_query([
        "token" => "xoxb-4054051295236-4052119093938-XFE0qpwwJu86gbYKT8fNP3xC",
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
// slack('Hello world', '#ハッカソン');

  ?>
