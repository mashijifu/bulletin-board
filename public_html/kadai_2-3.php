<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sample</title>
</head>
<body>
    <form action="kadai_2-3.php" method="post">
        名前：<br />
        <input type="text" name="name" size="30" value="" /><br />
        <br />
        コメント：<br />
        <textarea type="text" name="comment" size="30" value="" ></textarea><br />
        <br />
        <input type="submit" value="登録する" />
    </form>
    <?php
        $name=$_POST['name'];
        $comment=$_POST['comment'];
        $filename="kadai_2-3.txt";

        $fp=fopen($filename, 'a');
        // $count = count(file($filename));
        // $next = $count + 1;
        // fwrite($fp, $next . "<>" . $name . "<>" . $comment . "<>" . date('Y-m-d') . PHP_EOL);
        // fclose($fp);
        
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

        // // 取得したファイルデータ(配列)を全て表示する
        // for($i=0; $i < count($ret_array); $i++) {
        //     $text[$k]=explode("<>", $ret_array[$i]);
        // // 配列を順番に表示する
        //     echo($ret_array[$i] . "<br/>" );
        // }
    ?>
</body>
</html>