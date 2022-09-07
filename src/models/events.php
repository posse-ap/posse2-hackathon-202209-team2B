<?php
// 過去のイベントのみを表示させる
function eventRead($db)
{
    $stmt = $db->prepare("select * from users");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}

