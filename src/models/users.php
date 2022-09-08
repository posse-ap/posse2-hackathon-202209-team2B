<?php
// ユーザー追加
function userCreate($db, $name, $email, $password, $admin)
{
    $stmt = $db->prepare(
        'INSERT INTO 
`users` (
    `name`,
    `email`,
    `password`,
    `admin`
) 
VALUES
(?,?,?,?)
'
    );
    $password= password_hash( $password,PASSWORD_DEFAULT);
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->bindValue(2, $email, PDO::PARAM_STR);
    $stmt->bindValue(3, $password,PDO::PARAM_STR);
    $stmt->bindValue(4, $admin, PDO::PARAM_INT);
    $stmt->execute();
    $id = $db -> lastInsertId();
    return $id;
}

// 全読み込み
function userRead($db)
{
    $stmt = $db->prepare("select * from users");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}

// githubのログイン認証
function checkGithub($db, $condition)
{
    $stmt = $db->prepare("select * from users where github_account = '$condition'");
    $stmt->execute();
    $output = $stmt->fetchAll();
    return $output;
}