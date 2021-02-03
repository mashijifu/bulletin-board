<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>


    <?php
        $filename = "kadai_2-6.txt";


                    //新規投稿機能  
        if (!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['passcode'])) {

            $name = $_POST['name'];
            $comment = $_POST['comment'];
            $date = date("Y年m月d日 H時i分");
            $password=$_POST['passcode'];


            //編集対象番号が入力されているなら
            if (empty($_POST['edit-number'])) {
            //ファイルの存在がある場合は投稿番号+1、なかったら1を指定する
                if (file_exists($filename)) {
                    $number = count(file($filename)) + 1;
                } else {
                    $number = 1;
                }



                $list = $number . "<>" . $name . "<>" . $comment . "<>" . $date."<>".$password."<>";  //投稿内容


                //ファイルを追記保存モードで開く
                $fp = fopen($filename,"a");
                fwrite($fp,$list . "\n");
                fclose($fp);




                //編集実行機能  つまり新規投稿と編集で分岐する
            }else{

                $edit_number = $_POST['edit-number']; //読み込んだファイルの中身を配列に格納する
                $ret_array = file($filename);
                $fp = fopen($filename,"w");     //ファイルを開き、中身を空に 

                foreach ($ret_array as $line) {   //配列の数だけループ
                    $edit_date= explode("<>",$line);

                        //新稿番号と編集番号が一致・不一致で分ける
                    if ($edit_date[0] == $edit_number) {

                        //編集のフォームで送信された値で上書きする（$edit_numberが$numberと変わっている）
                        fwrite($fp, $edit_number. "<>" . $name . "<>" . $comment . "<>" . $date . "<>" . $edit_date[4] . "\n");

                    } else {
                        fwrite($fp,$line);  //不一致なら書き込む
                    }
                }
                fclose($fp);

            }
        }



                            //削除機能
        if((!empty($_POST['deleteNo'])) && (!empty($_POST['Delpasscode']))){  //DelpasswordがPOSTされていないなら、機能しない


            $Delpassword=$_POST['Delpasscode'];
            $delete=$_POST['deleteNo']; //$deleteの定義づけ
            $delcons=file($filename); //file関数で開くテキストファイルの指定
            $fp=fopen($filename,"w");//ファイル読み込み、中身を空にする
            $id=1;


            foreach($delcons As $delcon){ //ループ処理を行う
                $deldata=explode("<>", $delcon); //カッコで抽出

                if(($delete == $deldata[0]) && (strcmp($Delpassword,$deldata[4]) == 0) {
                    echo "削除されました";
                    
                }else{
                    if ($deldata[0] > $delete) {
                        $id = $deldata[0] - 1;
                    }
                    fwrite($fp, $id . "<>" . $deldata[1] . "<>" . $deldata[2] . "<>" . $deldata[3] . "<>" . $deldata[4] . PHP_EOL);

                    // if($deldata[0] != $delete){ //削除番号と行番号が一致・不一致
                    // fwrite($fp,$delcon[$j]); //行内容をファイルに書き込む

                    // }else{
                    // fwrite($fp, ""); //書き込まない（つまり削除）、行を詰める
                    // }
                }

                fclose($fp); //ファイルを閉じる

            }
        }




                //編集選択機能
        if (!empty($_POST['edit']) &&!empty($_POST['Editpasscode'])) {

            //入力データの受け取りを変数に代入
            $Editpassword = $_POST['Editpasscode'];
            $edit = $_POST['edit'];

            //読み込んだファイルの中身を配列に格納する
            $editCon = file($filename);

            foreach ($editCon as $line) {  
                $editdata = explode("<>",$line);

                //投稿番号と編集対象番号が一致したらその投稿の「名前」と「コメント」を取得
                if (($edit == $editdata[0]) && ($Editpassword == $editdata[4])) {

                    //投稿のそれぞれの値を取得し変数に代入
                    $editnumber = $editdata[0];
                    $editname = $editdata[1];
                    $editcomment = $editdata[2];

                //既存の投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる
                //formのvalue属性で対応
                }
            }
        }
    ?>




    <form action="kadai_2-6.php" method="post">
    <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
    <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>">
    <input type="hidden" name="edit-number" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
    <input id="password" type="password" name="passcode" value="<?php if(isset($editpassword)) {echo $editpassword;} ?>" placeholder="パスワードを入力してください">
    <input type="submit" name="submit" value="送信">
    </form>


    <form action="kadai_2-6.php" method="post">
    <input type="text" name="deleteNo" placeholder="削除対象番号">
    <input id="password" type="password" name="Delpasscode"  value="" placeholder="パスワードを入力してください">
    <input type="submit" name="delete" value="削除">
    </form>

    <form action="kadai_2-6.php" method="post">
    <input type="text" name="edit" placeholder="編集対象番号">
    <input id="password" type="password" name="Editpasscode"  value="" placeholder="パスワードを入力してください">
    <input type="submit" value="編集">
    </form>



    <?php      


                        //表示機能
        $filename = "kadai_2-6.txt";
        if (file_exists($filename)) { 
            $array = file($filename); //読み込んだファイルの中身を配列に格納する


            foreach ($array as $word) { //取得したファイルデータを全てループ処理で表示する
            $getdata = explode("<>",$word);  //explode関数でそれぞれの値を取得
            echo $getdata[0] . " " . $getdata[1] . " " . $getdata[2] . " " . $getdata[3] . $getdata[4] . " " ."<br>"; //取得した値を表示する
            }
        }


    ?>

  </body>
</html>