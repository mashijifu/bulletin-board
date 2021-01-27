<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>
        <?php
            $fp = fopen("sample.txt", "w");
            fwrite($fp, "sample.txtに書き込みました");
            fclose($fp);
        ?>
    </p>
</body>
</html>