<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sample</title>
</head>
<body>
    <?php

        $filename = "kadai_2-5.txt";

        // 新規投稿 
        if((isset($_POST['name'])) && (isset($_POST['comment']))) {
            
            if(((($_POST['name']) != "") || (($_POST['comment']) != ""))){
                $name=$_POST['name'];
                $comment=$_POST['comment'];

                if (empty($_POST['edit-number'])) {
                // ファイルを全て配列に入れる
                    if(file_exists($filename)){
                        $text = file_get_contents($filename);
                    }else{
                        $text = "";
                    }
                        
                    $text_rows = explode("\n",$text);//改行で分解
                    $count = count($text_rows);//行数をカウント
                    $add_text = $count."<>".$name."<>".trim($comment)."<>".date('Y-m-d');//追加したい文章
                    // array_unshift($text_rows, $add_text);//配列の先頭に追加
                    array_push($text_rows, $add_text);
                    $write_text = implode("\n", $text_rows);//改行でくっつける
                    file_put_contents($filename, $write_text);
            
                }else{

                    // 編集
                    $edit_number = $_POST['edit-number'];

                    $e_lines=file($filename);

                    $fp = fopen($filename, "w");
                    foreach($e_lines as $e_line) {
                        $edi = explode("<>",$e_line);
                        if($edi[0] == $edit_number){
                            fwrite($fp, $edit_number."<>".$name."<>".trim($comment)."<>".date('Y-m-d')."\n");
                        }else{
                            fwrite($fp, $e_line);
                        }
                    }
                    fclose($fp);
                    $edit_flag=0;
                
                }

            }else{
                            
                echo "<br>"."名前またはコメントが入力されていません。";
                
            }
        }

        // 編集選択
        if (!empty($_POST['editnum'])) {

            //入力データの受け取りを変数に代入
                $edit = $_POST['editnum'];
         
            //読み込んだファイルの中身を配列に格納する
                $editCon = file($filename);
         
                foreach ($editCon as $ed_line) {  
                    $editdata = explode("<>",$ed_line);
                
                    //投稿番号と編集対象番号が一致したらその投稿の「名前」と「コメント」を取得
                    if ($edit == $editdata[0]) {
            
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
    <form action="kadai_2-5.php" method="post">
        名前：<br />
        <input type="text" name="name" size="30" placeholder="名前" value="<?php if(isset($editname)){ 
                                                                                        echo $editname;
                                                                                    } ?>" ><br />
        <br />
        コメント：<br />
        <input type="text" name="comment" size="30" placeholder="コメント" value="<?php if(isset($editcomment)){
                                                                                                    echo $editcomment;
                                                                                            } ?>" >
        <br />
        <input type="hidden" name="edit-number" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
        <input type="submit" value="登録する" />
        <br>
        
    </form>
    <form action="kadai_2-5.php" method="post">
        編集：<br />
        <input type="text" name="editnum" placeholder="編集する番号">
        <input type="submit" value="編集する" />
    </form>

    <?php
        if(file_exists($filename)){
            $array=file($filename);

            foreach ($array as $arr) {
                if($arr === ""){
                    continue;
                }
                $ret = explode("<>", $arr);
                echo $ret[0];
                echo $ret[1];
                echo $ret[2];
                echo $ret[3];
                echo "<br>";
            }
        }
    ?>
</body>
</html>