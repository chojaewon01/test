<?
session_start();

include("../board_func.php");
include("../classdb.php");
include("./sess_admin.php");


//$mode = $id;

$id = $_GET["id"];
$cpage = $_GET["cpage"];
$no = $_GET["no"];
$method = $_GET["method"];
$word = $_GET["word"];
//$id="free";
$return_url = $PHP_SELF;



$obj1 = new db;

include("../board/new_board_config.inc");

?>
<html>
<head>
<title>������(<?=$nm?>) �Խ����Դϴ�.-</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../board.css" rel="stylesheet" type="text/css">

</head>

<body>
<br><br><br>
 <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=$nm?> ����</h3>



<table width="800" border="0" cellspacing="0" cellpadding="0">
	<tr> 
		<td width="560" colspan="2"> <br> 
                        <?
	if($mode == "insert") {
		include("../board/board_if.php");
} else 	if($mode == "modify") {
		include("../board/board_mf.php");
} else 	if($mode == "reply") {
		include("../board/board_rf.php");
} else 	if($mode == "view") {
		include("../board/board_vf.php");
} else 	if($mode == "del") {
		include("../board/board_df.php");
} else {
		include("../board/board_lf.php");
}
?>
		</td>
	</tr>
</table>





</body>
</html>
