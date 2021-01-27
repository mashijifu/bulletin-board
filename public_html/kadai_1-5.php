<!DOCTYPE html>
<head>
<html lang="ja">
<meta charset="UTF-8">
</head>
<body>
    <form action="kadai_1-5.php" method="post">
        <input type="text" name="name">
        <input type="submit" value="送信">
    </form>

    <?php
        $name=$_POST['name'];
        $filename='post1-5.txt';
        $fp=fopen($filename,'w');
        fwrite($fp, $name);
        fclose($fp);
    ?>
</body>
</html>