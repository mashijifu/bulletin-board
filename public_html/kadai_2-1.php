<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sample</title>
</head>
<body>
    <form action="kadai_2-1.php" method="post">
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
        $filename="kadai_2-1.txt";

        $fp=fopen($filename, 'a');
        $count = count(file($filename));
        $next = $count + 1;
        fwrite($fp, $next."<>".$name."<>".$comment."<>".date('Y-m-d').PHP_EOL);
        while ($line = fgets($fp)) {
            echo "$line<br />";
        }
        fclose($fp);
        
    ?>
</body>
</html>