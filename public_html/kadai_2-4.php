<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sample</title>
</head>
<body>
    <form action="kadai_2-4.php" method="post">
        名前：<br />
        <input type="text" name="name" size="30" value="" placeholder="名前" /><br />
        <br />
        コメント：<br />
        <textarea type="text" name="comment" size="30" value="" placeholder="コメント" ></textarea><br />
        <br />
        削除：<br />
        <input type="number" name="delete" size="30" value="" placeholder="削除する番号" /><br />
        <br />
        <input type="submit" value="登録する" />
        <input type="submit" value="削除する" />
    </form>
    <?php

        $filename = "kadai_2-4.txt";

        if((isset($_POST["delete"])) && ($_POST["delete"] != "")) {

            $delete = $_POST['delete'];

            $fp = fopen($filename, "r");
            while (!feof($fp)){
                $lines[] = fgets($fp);
            }
            fclose($fp);

            $fp = fopen($filename, "w");
            foreach($lines as $line) {
                $del = explode("<>",$line);
                if($del[0] != $delete)
                {
                    fwrite($fp, $line);
                }
            }
            fclose($fp);

        }
        
        if((isset($_POST['name'])) && (isset($_POST['comment']))) {

            if((($_POST['name']) != "") || (($_POST['comment']) != "")){
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