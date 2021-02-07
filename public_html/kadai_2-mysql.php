<?php
    // 変数の初期化 & 日時の取得
    date_default_timezone_set('Asia/Tokyo');
    $sql = null;
    $res = null;
    $dbh = null;
    $date = date('Y-m-d H:i:s');

    try {
        // DBへ接続
        $dbh = new PDO("mysql:host=127.0.0.1; dbname=co_19_313_99sv_coco_com; charset=utf8", 'co-19-313.99sv-c', 'E7zKLgce');
        
        $sql = 'CREATE TABLE user_list (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(20),
            age INT(11),
            registry_datetime DATETIME
        
        ) engine=innodb default charset=utf8';

        $res = $dbh->query($sql);
        
        // 挿入
        $sql = "INSERT INTO user_list (
            id, name, age, registry_datetime
        ) VALUES (
            1, '太郎', 18, '$date'
        )";

        $res = $dbh->query($sql);

        $sql = "INSERT INTO user_list (
            id, name, age, registry_datetime
        ) VALUES (
            2, '次郎', 28, '$date'
        )";

        $res = $dbh->query($sql);

        // 更新
        $sql = "UPDATE user_list SET age = 50 WHERE id = 1";

        // SQL実行
        $res = $dbh->query($sql);

        // 削除
        $sql = "DELETE FROM user_list WHERE id = 2";

        // SQL実行
        $res = $dbh->query($sql);


        // 取得
	    $sql = "SELECT * FROM user_list";

        // SQL実行
        $res = $dbh->query($sql);

        // $aryColumn = $res -> fetchAll(PDO::FETCH_ASSOC);

        // 取得したデータを出力
        foreach( $res as $value ) {
            echo "$value[id]<br>";
            echo "$value[name]<br>";
            echo "$value[age]<br>";
            echo "$value[registry_datetime]<br>";
            
            
        }
    
    } catch(PDOException $e) {
        
        echo $e->getMessage();
        die();
    }
    
    // 接続を閉じる
    $dbh = null;

?>