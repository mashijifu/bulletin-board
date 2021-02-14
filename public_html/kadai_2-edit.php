<?php

    if(isset($_POST['btn_edit'])){  //DelpasswordがPOSTされていないなら、機能しない
        
        if((empty($_POST['editNo']))||(empty($_POST['Editpasscode']))){
            echo '編集番号とパスワードの両方を入力してください';
            exit();
        }

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

            $editNo = $_POST['editNo'];
            $edit_pass = $_POST['Editpasscode'];
    
            $stm=$pdo->prepare("SELECT * FROM $tb_name");
            $stm->execute();

            foreach($stm as $loop){
                if(($editNo == $loop['id'])&&($edit_pass == $loop['password'])){
                    $stmt = $pdo->prepare('SELECT * FROM $tb_name WHERE id = :id');

                    $stmt->execute(array(':id' => $editNo));

                    $result = 0;

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }

        } catch (Exception $e) {
            echo 'エラーが発生しました。:' . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>編集</title>

    <div class="contact-form">
        <h2>編集</h2>
        <?php if($result){ ?>
            <form action="kadai_2-update.php" method="post">
                    <input type="hidden" name="id" value="<?php if (!empty($result['id'])) echo(htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'));?>">
                <p>
                    <label>お名前：</label>
                    <input type="text" name="name" value="<?php if (!empty($result['name'])) echo(htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8'));?>">
                </p>
                <p>
                    <label>メッセージ：</label>
                    <input type="text" name="comment" value="<?php if (!empty($result['comment'])) echo(htmlspecialchars($result['comment'], ENT_QUOTES, 'UTF-8'));?>">
                </p>

                <input type="submit" value="編集する">

            </form>
        <?php }else{ ?>
            <p>編集番号とパスワードが合っていません。</p>
        <?php } ?>
    </div>
        <a href="kadai_2-index.php">投稿一覧へ</a>
</body>
</html>