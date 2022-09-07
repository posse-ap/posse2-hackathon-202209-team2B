<?php
// 過去のイベントのみを表示させる
function eventRead($db)
{
    $stmt = $db->prepare("select * from users");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}

// 追加
function eventCreate($db, $name, $start_at, $end_at, $deadline, $detail)
{
    $result = False;
    try {
    $stmt = $db->prepare(
            "INSERT INTO
    `events` (
    `name`,
    `start_at`,
    `end_at`,
    `deadline`,
    `detail`
    )
    VALUES(?,?,?,?,?)"
        );

        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $start_at, PDO::PARAM_STR);
        $stmt->bindValue(3, $end_at, PDO::PARAM_STR);
        $stmt->bindValue(4, $deadline, PDO::PARAM_INT);
        $stmt->bindValue(5, $detail, PDO::PARAM_INT);
        $stmt->execute();
    } catch (\Exception $e) {
        echo $e->getMessage();
        return $result;
        //ここでエラーページに飛ばしたい
        //→その際にもどるボタンで、前いたページに遷移させる
    }
}

// 編集
function eventUpdate($db, $name, $start_at, $end_at, $deadline, $detail, $condition)
{
    $result = False;
    try {
        $stmt = $db->prepare("UPDATE `events` SET name=?, `start_at`=?, `end_at`=?, `deadline`=? ,`detail`=? WHERE $condition");
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $start_at, PDO::PARAM_STR);
        $stmt->bindValue(3, $end_at, PDO::PARAM_STR);
        $stmt->bindValue(4, $deadline, PDO::PARAM_STR);
        $stmt->bindValue(5, $detail, PDO::PARAM_STR);
        $stmt->execute();
    } catch (\Exception $e) {
        echo $e->getMessage();
        return $result;
        //ここでエラーページに飛ばしたい
        //→その際にもどるボタンで、前いたページに遷移させる
    }
}
