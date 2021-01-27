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
            $fp = fopen("sample.txt", "r");
            while ($line = fgets($fp)) {
              echo "$line<br />";
            }
            fclose($fp);
        ?>
    </p>
</body>
</html>