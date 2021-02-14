<?php

try {

    $dbname = "mysql:host=127.0.0.1; dbname=co_19_313_99sv_coco_com; charset=utf8";
    $db_user = "co-19-313.99sv-c";
    $db_pass = "E7zKLgce";

    $pdo = new PDO(
        $dbname,
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false,
        ]
    );

    $tb_name='keijiban';

    $stmt = $dbh->prepare('UPDATE users SET name = :name, comment = :comment WHERE id = :id');

    $stmt->execute(array(':name' => $_POST['name'], ':message' => $_POST['message'], ':id' => $_POST['id']));
    // $stmt->execute(array(':name' => $_POST['name'], ':comment' => $_POST['comment']));

    echo "情報を更新しました。";

} catch (Exception $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>更新完了</title>
  </head>
  <body>          
  <p>
      <a href="kadai_2-index.php">投稿一覧へ</a>
  </p> 
  </body>
</html>