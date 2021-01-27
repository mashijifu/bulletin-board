<!DOCTYPE html>
<head>
<html lang="ja">
<meta charset="UTF-8">
</head>
<body>
    <form action="kadai_1-6.php" method="post">
        <input type="text" name="name">
        <input type="submit" value="送信">
    </form>

    <?php
        $name=$_POST['name'];
        $filename='post1-6.txt';
        $fp=fopen($filename,'a');
        fwrite($fp, $name.PHP_EOL);
        fclose($fp);
    ?>
</body>
</html>