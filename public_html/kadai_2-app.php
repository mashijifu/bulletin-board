<?php
    if( !empty($_POST['btn_submit']) ) {
        var_dump($_POST);
    }    
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ひと言掲示板</title>
<body>
    <form method="post">
        <div>
            <label for="view_name">名前</label>
            <input id="view_name" type="text" name="view_name" value="">
        </div>
        <div>
            <label for="message">コメント</label>
            <textarea id="message" name="message"></textarea>
        </div>
        <input type="submit" name="btn_submit" value="送信">
    </form>
</body>