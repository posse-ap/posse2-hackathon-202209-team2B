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
}