<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order);
	//unset($_SESSION['wherememberlist']);
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
		if( $_GET['act']=="k")
	{
		$_SESSION['wherexylistss']="";
		}
	htqx("6.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="xylist.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script></head>

<body>
<?php
	//echo $_SESSION['quanxian'];
//echo strlen(strstr($_SESSION['quanxian'],"6.3"));
//删除数据
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
htqx("6.4");
	if($bw->delete('bw_qjj', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}

//重置密码为123456 2016-10-29
if($action == 'editmm')
{
htqx("6.4");
	//print_r($_POST);
	$sql = "UPDATE bw_qjj SET password = '".md5(123456)."' WHERE id = ".$_GET['id'];
	if($bw->query($sql))
	{
		$bw->msg('处理成功!', 'xylist.php');	
	}else{
		$bw->msg('处理失败!', 'xylist.php');	
	}
}

//删除多条数据
if(!empty($_POST['deleteSelect']))
{
	//die($_SESSION['quanxian']);
htqx("6.4");
	//print_r($_POST);
	if(isset($_POST['id']))
	{
		$id = implode(',', $_POST['id']);
		
		//deleteSelect shsyBtn qxshBtn
		if(!empty($_POST['deleteSelect']))
		{
			if($bw->delete('bw_qjj', "id IN (".$id.")"))
			{
				$bw->msg('删除成功!');	
			}else{
				$bw->msg('删除失败!');	
			}
		}
	}
}
if(!empty($_POST['shsyBtn']))
	{
	htqx("6.3");
		unset($_POST['shsyBtn']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
			$xxf='xxf'.$_POST['id'][$i];
				$sql = "UPDATE bw_qjj SET xxf = ".$_POST[$xxf]." WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			}
		}
		
			$bw->msg('设置信息费成功!');
	}
	
	
	if(!empty($_POST['fenpei']))
	{
	htqx("6.3");
		unset($_POST['fenpei']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
			$jyidfp='jyid'.$_POST['id'][$i];

				if($_POST[$jyidfp]!="")
				{
				$sql = "insert into bw_order(jyid,xyid,ifdd,ddzt,addtime,username,lang) values(".$_POST[$jyidfp].",{$_POST['id'][$i]},2,1,'".date("y-m-d H:i:s")."','".$_SESSION['username']."','".$Lang."')";
				$sql1 = "update bw_qjj set zt='正在试教' where id={$_POST['id'][$i]}";
				$bw->query($sql);
				$bw->query($sql1);
			    }
			}
		}
			$bw->msg('分配教员成功!');
	}
	
	
	if(!empty($_POST['cxfb']))
	{
	htqx("6.3");
		unset($_POST['cxfb']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
				$sql1 = "update bw_qjj set zt='未安排',addtime='".date("y-m-d H:i:s")."',username='".$_SESSION['username']."' where id={$_POST['id'][$i]}";
				$bw->query($sql1);
			}
		}
			$bw->msg('设置从新发布成功!');
	}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>学员编号:<input name="ddbh" id="ddbh" size="8" />&nbsp;姓名:
<input name="xyname" id="xyname" size="8" />
  &nbsp;电话:
  <input name="tel" id="tel" size="8" />
  &nbsp;求教科目:<input name="qjkm" id="qjkm" size="8" />
&nbsp;所在区域:
<select name="szqy" id="szqy">
	  <option value="">--请选择--</option>
			  <?php
	$dir=$diaoquData["quyu"];
	$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
	for($i=0;$i<count($split_dir);$i++)
	
	{  ?>
	  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
	<?php
	}
	?>
</select>
&nbsp;学员年级:
<select name="xynj" id="xynj">
	  <option value="">--请选择--</option>
			  <?php
	$dir=$diaoquData["nianji"];
	$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
	for($i=0;$i<count($split_dir);$i++)
	
	{  ?>
	  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
	<?php
	}
	?>
</select>
&nbsp;学员类型:
<select name="xylx">
	<option selected="selected" value="">--请选择--</option>
	<option value="零基础">零基础</option>
	<option value="补差型">补差型</option>
	<option value="提高型">提高型</option>
	<option value="拔尖型">拔尖型</option>
</select>
&nbsp;状态:
<select name="zt">
	<option selected="selected" value="">--请选择--</option>
    <option value="未安排">未安排</option>
	<option value="正在试教">正在试教</option>	
    <option value="已安排">已安排</option>
    <option value="成功">成功</option>
</select>
&nbsp;<input type="submit" value="搜索" />
</td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="50" align="center"><strong>ID</strong></td>
    <td width="77" align="center"><strong>学员编号</strong></td>
    <td width="88" align="center"><strong>联系人</strong></td>
    <td width="100" align="center"><strong>学员年级</strong></td>
    <td width="98" align="center"><strong>学员类型</strong></td>
    <td width="120" align="center"><strong>求教学科</strong></td>
    <td width="100" align="center"><strong>所在区域</strong></td>
    <td width="100" align="center"><strong>状态</strong></td>
    <td width="80" align="center"><strong>信息费</strong></td>
    <td width="80" align="center"><strong>教员id</strong></td>
    <td width="100" align="center"><strong>发布时间</strong></td>
    <td width="114" align="center"><strong>操作</strong></td>
    <td width="100" align="center">是否显示</td>
  </tr>
<form name="listForm" action="?" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_qjj";
 // die($Lang);
  //where    = '1=1 and sfhy =0 and lang="'.$Lang.'" ';
  $where    = '1=1 and sfhy =0';
  // die($where);
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['ddbh']))
	  {
		$where = $where." and id LIKE '%".$_POST['ddbh']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['qjkm']))
	  {
		$where = $where." and qjkm LIKE '%".$_POST['qjkm']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['xyname']))
	  {
		$where = $where." and name LIKE '%".$_POST['xyname']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['tel']))
	  {
		$where = $where." and tel = '".$_POST['tel']."'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['szqy']))
	  {
		$where = $where." and szqy LIKE '%".$_POST['szqy']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['xynj']))
	  {
		$where =$where." and xynj LIKE '%".$_POST['xynj']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	  if(!empty($_POST['xylx']))
	  {
		$where =$where." and xylx LIKE '%".$_POST['xylx']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
	   if(!empty($_POST['zt']))
	  {
		$where =$where." and zt LIKE '%".$_POST['zt']."%'";
		$_SESSION['wherexylistss'] = $where;
	  }
  }
  if($_SESSION['wherexylistss']=="")
  {
	  $_SESSION['wherexylistss'] = $where;
  }


 // die($where.$_SESSION['wherexylistss']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherexylistss'],"id DESC",$pageSize);
  //print_r($list);exit();
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherexylistss'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><?php if($list[$i]['ifnew']==1){echo "<font color='#FF0000'>[新]</font>";}?><a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><?php echo $list[$i]['id']; ?></a></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><?php echo $list[$i]['name']; ?></a></td>
    <td align="center"><?php echo $list[$i]['xynj']; ?></td>
    <td align="center"><?php echo $list[$i]['xylx']; ?></td>
    <td align="center"><?php echo $list[$i]['qjkm']; ?></td>
    <td align="center"><?php echo $list[$i]['szqy']; ?></td>
    <td align="center"><?php if($list[$i]['zt']=="正在试教"){echo "<font color='#FF0000'>".$list[$i]['zt']."</font>";}elseif($list[$i]['zt']=="未安排"){echo $list[$i]['zt'];}elseif($list[$i]['zt']=="已安排"){echo $list[$i]['zt'];}elseif($list[$i]['zt']=="成功"){echo "<font color='#0000FF'>".$list[$i]['zt']."</font>";} ?></td>
    <td align="center"><input name="xxf<?php echo $list[$i]['id']; ?>" type="text" id="xxf" value="<?php echo $list[$i]['xxf']; ?>" size="10"/></td>
    <td align="center"><input name="jyid<?php echo $list[$i]['id']; ?>" type="text" id="jyid" value="<?php
     if($list[$i]['zt']=="正在试教"){
	 	$jyorder = $bw->selectOnly('jyid', 'bw_order', 'xyid = '.$list[$i]['id'].' and ifdd=2', ' id desc');
		echo $jyorder["jyid"];
	 }
	?>" size="10"/></td>
    <td align="center"><?php echo date("Y-m-d",strtotime($list[$i]['addtime']));?></td>
    <td align="center"><a href="###" style="color:red" onclick="javascript:if(confirm('确定要修改密码为123456?')){window.location.href='?action=editmm&id=<?php echo $list[$i]['id']; ?>'}">密码重置</a>&nbsp;&nbsp;<a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><img src="images/pen.gif" alt="修改信息" title="修改信息" /></a>&nbsp;&nbsp;<a href="###" onclick="javascript:if(confirm('是否删除')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}"><img src="images/delete.gif"/></a></td>
    <td align="center">
	 <?php if($list[$i]['isshow']=="2")
	 {
	 echo "<span style='color:green'>是</span>";
	 }
	 
     if($list[$i]['isshow']=="" || $list[$i]['isshow']=="1")
	 {
	 echo "<span style='color:green'>否</span>";
	 }?>	</td> </td>
    </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="13" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  <tr>
    	    <td align="left"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />&nbsp;<input type="submit" value="分配教员" name="fenpei" id="fenpei" />&nbsp;<input type="submit" value="从新发布" name="cxfb" id="cxfb" />&nbsp;<input type="submit" value="更改信息费" name="shsyBtn" id="shsyBtn" /></td>
    	    <td align="right">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="?page=1">第一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				跳到
				<select name="page_SEL" id="page_SEL">
						<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
		    </select></td>
  	    </tr>
  	  </table></td>
  </tr>
</form>
</table>

</body>
</html>