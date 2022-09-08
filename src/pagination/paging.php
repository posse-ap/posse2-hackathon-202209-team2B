
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>サンプル</title>
</head>
<body>
<?php
//一ページに表示する記事の数をmax_viewに定数として定義
define('max_view',10);
// //必要なページ数を求める
// $count = $pdo->prepare('SELECT COUNT(*) AS count FROM events');
// $count->execute();
// $total_count = $count->fetch(PDO::FETCH_ASSOC);
// $pages = ceil($total_count['count'] / max_view);
// var_dump($pages);
//デフォルトの値
$page_id = 1;
$page_id = $_GET['page_id'];
$condition = 10*($page_id - 1);

$stmt = $db->query('SELECT COUNT( * ) FROM event_attendance');
$count = $stmt->fetch();
$count = (int)$count[0];
$max_page = ceil($count/max_view);
// var_dump($max_page);
//現在いるページのページ番号を取得
$stmt = $db->query("SELECT * FROM event_attendance WHERE id >= 0 LIMIT '$condition',10");
$limit = $stmt -> fetchAll();
// var_dump($limit);
// var_dump((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
?>
<article>
<?php foreach($limit as $result) {?>
<div><?= $result['id'] ?></div>
<?php } ?>
<?php for($i = 1; $i <= $max_page; $i++) {?>
<a href="<?= "http://" . $_SERVER['HTTP_HOST'] . "/pagination/paging.php" . "?page_id=$i" ?>"><?= $i ?></a>
<?php } ?>
</article>
</body>
</html>




<!-- //ページネーションを表示

//必要なページ数を求める -->


