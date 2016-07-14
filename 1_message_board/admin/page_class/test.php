<?php
require_once 'page.class.php';
$pg = new Page(105,10);
$str = $pg -> showpage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>分页</title>
    <link href="page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
    <?php echo $str;?>
</div>
</body>
</html>