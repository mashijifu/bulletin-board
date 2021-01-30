<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sample</title>
</head>
<body>
    <form action="kadai_2-5.php" method="post">
        名前：<br />
        <input type="text" name="name" size="30" value="" placeholder="名前" /><br />
        <br />
        コメント：<br />
        <textarea type="text" name="comment" size="30" value="" placeholder="コメント" ></textarea><br />
        <br />
        削除：<br />
        <input type="number" name="edit" size="30" value="" placeholder="編集する番号" /><br />
        <br />
        <input type="submit" value="登録する" />
        <input type="submit" value="編集する" />
    </form>
    <?php

        $filename = "kadai_2-5.txt";

        if((isset($_POST["edit"])) && ($_POST["edit"] != "")) {

            $edit = $_POST['edit'];

            $fp = fopen($filename, "r");
            while (!feof($fp)){
                $e_lines[] = fgets($fp);
            }
            fclose($fp);

            $fp = fopen($filename, "w");
            foreach($e_lines as $e_line) {
                $edi = explode("<>",$e_line);
                if($edi[0] == $edit)
                {
                    $newname=$edi[1];
                    $newcomment=$edi[2];
                    var_dump($edi);
                    fwrite($fp, $edit."<>".$newname."<>".trim($newcomment)."<>".date('Y-m-d'));
                }else{
                    fwrite($fp, $e_line);
                }
            }
            fclose($fp);

        }
        
        if((isset($_POST['name'])) && (isset($_POST['comment']))) {

            if(((($_POST['name']) != "") || (($_POST['comment']) != "")) && !isset($_POST['edit'])){
                $name=$_POST['name'];
                $comment=$_POST['comment'];
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
                
                foreach ($text_rows as $text_row) {
                    if($text_row === ""){
                        continue;
                    }
                    $ret = explode("<>", $text_row);
                    echo $ret[0];
                    echo $ret[1];
                    echo $ret[2];
                    echo $ret[3];
                    echo "<br>";
                }
        
            }else{

                echo "<br>"."名前またはコメントが入力されていません。";
                
            }
        

        }

    ?>
</body>
</html>