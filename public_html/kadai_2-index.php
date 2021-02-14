<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>


    <?php
        $dbname = "mysql:host=127.0.0.1; dbname=co_19_313_99sv_coco_com; charset=utf8";
        $db_user = "co-19-313.99sv-c";
        $db_pass = "E7zKLgce";

        try{
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

            // テーブル作成
            $tb_name='keijiban';

            $sql= "CREATE TABLE IF NOT EXISTS $tb_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(20),
            comment VARCHAR(200),
            post_date DATETIME,
            password VARCHAR(10) 
            )ENGINE=InnoDB DEFAULT CHARSET=utf8";

            $stmt=$pdo->prepare($sql);
            $stmt->execute();

            // テーブルの存在を確認
            // $rs=$pdo->query("SHOW TABLES");
            // $table=$rs->fetchAll(PDO::FETCH_COLUMN);
            // if(in_array($tb_name,$table)){
            //     echo "テーブルの存在を確認しました"."<br>";
            //     echo "テーブル名：".$tb_name."<br>";
            // }else{
            //     echo "テーブル：".$tb_name."がありません";
            // }
    
            //新規投稿機能  
            if(isset($_POST['btn_submit'])) {
    
                // 表示名の入力チェック
                if( empty($_POST['name']) ) {
                    $error_message[] = '表示名を入力してください。';
                    exit();
                } else {
                    $view_name = htmlspecialchars( $_POST['name'], ENT_QUOTES);
                }
                
                // メッセージの入力チェック
                if( empty($_POST['comment']) ) {
                    $error_message[] = 'コメントを入力してください。';
                    exit();
                } else {
                    $view_comment = htmlspecialchars( $_POST['comment'], ENT_QUOTES);
                    // $clean['comment'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['comment']);
                }
        
                // パスワードの入力チェック
                if( empty($_POST['passcode']) ) {
                    $error_message[] = '表示名を入力してください。';
                    exit();
                } else {
                    $view_passcode = htmlspecialchars( $_POST['passcode'], ENT_QUOTES);
                }
    
                    $id=NULL;
    
                    $sql = "INSERT INTO $tb_name (id,name,comment,post_date,password) VALUES (:id, :name, :comment, now(), :password)";
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindValue( ':id', $id, PDO::PARAM_INT );
                    $stmt->bindValue( ':name', $view_name, PDO::PARAM_STR );
                    $stmt->bindValue( ':comment', $view_comment, PDO::PARAM_STR );
                    // $stmt->bindValue( ':date', $date, PDO::PARAM_STR );
                    $stmt->bindValue( ':password', $view_passcode, PDO::PARAM_STR );
                    $stmt->execute();
                    // $list = $number . "<>" . $name . "<>" . $comment . "<>" . $date."<>".$password."<>";  //投稿内容
    
                    //INSERT内容をブラウザで確認
                    // $stmt=$pdo->prepare("SELECT * FROM $tb_name");
                    // $stmt->execute();
                    // foreach($stmt as $loop){
                    //     echo "number:".$loop['number']."<br>".
                    //         "name:".$loop['name']."<br>".
                    //         "message:".$loop['message']."<br>".
                    //         "regi_date:".$loop['regi_date']."<br>".
                    //         "password:".$loop['password']."<br>";
                    // }
    
                    //投稿が成功したことを示すメッセージ
                    // $success_message = 'メッセージを送信しました';
    
    
    
                // }
                    //編集実行機能  つまり新規投稿と編集で分岐する
                // }else{
    
                //     $edit_number = $_POST['edit-number']; //読み込んだファイルの中身を配列に格納する
                //     $ret_array = file($filename);
                //     $fp = fopen($filename,"w");     //ファイルを開き、中身を空に 
    
                //     foreach ($ret_array as $line) {   //配列の数だけループ
                //         $edit_date= explode("<>",$line);
    
                //             //新稿番号と編集番号が一致・不一致で分ける
                //         if ($edit_date[0] == $edit_number) {
    
                //             //編集のフォームで送信された値で上書きする（$edit_numberが$numberと変わっている）
                //             fwrite($fp, $edit_number. "<>" . $name . "<>" . $comment . "<>" . $date . "<>" . $edit_date[4] . "\n");
    
                //         } else {
                //             fwrite($fp,$line);  //不一致なら書き込む
                //         }
                //     }
                //     fclose($fp);
    
                // }
            }
    
            // 削除機能
            if(isset($_POST['btn_delete'])){  //DelpasswordがPOSTされていないなら、機能しない
    
                if((empty($_POST['deleteNo']))||(empty($_POST['Delpasscode']))){
                    echo '削除番号とパスワードの両方を入力してください';
                    exit();
                }
        
                $deleteNo = $_POST['deleteNo'];
                $delete_pass = $_POST['Delpasscode'];
        
                $stmt=$pdo->prepare("SELECT * FROM $tb_name");
                $stmt->execute();
    
                foreach($stmt as $loop){
                    if(($deleteNo==$loop['id'])&&($delete_pass==$loop['password'])){                
                        //DELETEの処理
                        $sql="DELETE FROM $tb_name WHERE id=:id";
                        $stmt=$pdo->prepare($sql);
                        $stmt->bindValue(':id',$deleteNo,PDO::PARAM_INT);
                        $stmt->execute();
                        echo "メッセージを削除しました";
    
                        $reset_num="SET @i = 0; UPDATE $tb_name SET id = (@i := @i+1)";
                        $stmt=$pdo->prepare($reset_num);
                        $stmt->execute();
                    }else{
                        echo "パスワードまたは削除番号が間違っています";
                        exit(); // $stmtに複数値が入っている場合、1件目で終了してしまうけど良いのでしょうか？
                    }
                }
    
                
            }
            
        }catch(PDOException $e){
            header('Content_Type:text/plain;charset=UTF-8',true,500);
            exit($e->getMessage());
        }
        
        
        //編集選択機能
        // if (!empty($_POST['edit']) &&!empty($_POST['Editpasscode'])) {

        //     //入力データの受け取りを変数に代入
        //     $Editpassword = $_POST['Editpasscode'];
        //     $edit = $_POST['edit'];

        //     //読み込んだファイルの中身を配列に格納する
        //     $editCon = file($filename);

        //     foreach ($editCon as $line) {  
        //         $editdata = explode("<>",$line);

        //         //投稿番号と編集対象番号が一致したらその投稿の「名前」と「コメント」を取得
        //         if (($edit == $editdata[0]) && ($Editpassword == $editdata[4])) {

        //             //投稿のそれぞれの値を取得し変数に代入
        //             $editnumber = $editdata[0];
        //             $editname = $editdata[1];
        //             $editcomment = $editdata[2];

        //         //既存の投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる
        //         //formのvalue属性で対応
        //         }
        //     }
        // }
    ?>




    <form action="kadai_2-index.php" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>">
        <!-- <input type="hidden" name="edit-number" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>"> -->
        <input id="password" type="password" name="passcode" value="<?php if(isset($editpassword)) {echo $editpassword;} ?>" placeholder="パスワードを入力してください">
        <input type="submit" name="btn_submit" value="送信">
    </form>


    <form action="kadai_2-index.php" method="post">
        <input type="text" name="deleteNo" placeholder="削除対象番号">
        <input id="password" type="password" name="Delpasscode"  value="" placeholder="パスワードを入力してください">
        <input type="submit" name="btn_delete" value="削除">
    </form>

    <form action="kadai_2-edit.php" method="post">
        <input type="text" name="editNo" placeholder="編集対象番号">
        <input id="password" type="password" name="Editpasscode"  value="" placeholder="パスワードを入力してください">
        <a href="kadai_2-6-edit.php"><input type="submit" name="btn_edit" value="編集"></a>
    </form>



    <?php      

        $stmt=$pdo->prepare("SELECT * FROM $tb_name");
        $stmt->execute();

        //表示機能
        if ($stmt) { 
    
            foreach($stmt as $loop){ //取得したデータを全てループ処理で表示する
                echo $loop['id'] . " " . $loop['name'] . " " . $loop['comment'] . " " . $loop['post_date'] . " " . $loop['password'] ."<br>"; //取得した値を表示する
            }
        }

        //接続を閉じる
        $pdo = null;

    ?>

  </body>
</html>