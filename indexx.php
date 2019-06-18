<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<?php
 
echo "<h1>Ex. 구구단 출력하기</h1>";
 
for($i=2;$i<=9;$i++){
    echo $i."단 입니다.<br/>";
    for($j=1;$j<=9;$j++){
        echo $i." X ".$j." = ".($i*$j)."<br/>";
    }
    echo "<br/>";
}
 
?>
</body>
</html>