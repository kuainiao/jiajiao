<?php
//---------------------------------------------------------
//�Ƹ�ͨ��ʱ����֧������ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------

require_once ("classes/PayRequestHandler.class.php");
require_once("inc/config.php");

/* �̻��� */
$bargainor_id = "1900000109";

/* ��Կ */
$key = "8934e7d15453e97507ef794cf7b0519d";

/* ���ش�����ַ */
$return_url = "http://localhost/tenpay/return_url.php";

//date_default_timezone_set(PRC);
$strDate = date("Ymd");
$strTime = date("His");

//4λ�����
$randNum = rand(1000, 9999);

//10λ���к�,�������е�����
$strReq = $strTime . $randNum;

/* �̼Ҷ�����,����������32λ��ȡǰ32λ���Ƹ�ֻͨ��¼�̼Ҷ����ţ�����֤Ψһ�� */
$sp_billno = "C".$strReq;

/* �Ƹ�ͨ���׵��ţ�����Ϊ��10λ�̻���+8λʱ�䣨YYYYmmdd)+10λ��ˮ�� */
$transaction_id = $bargainor_id . $strDate . $strReq;

/* ��Ʒ�۸񣨰����˷ѣ����Է�Ϊ��λ */
$total_fee = $_POST['amount'];

/* ��Ʒ���� */
$desc = "�����ţ�" . $transaction_id;

// ����֧����¼�����ݿ�
$_POST["memberid"]=$_POST["memberid"];
$_POST["amount"]=$total_fee;
$_POST["recordno"]=$sp_billno;
$_POST["addtime"]=date("Y-m-d H:i:s");
$_POST["acontent"]=$_POST["acontent"];
$_POST["lang"]=$_COOKIE["cookie_lang"];
$_POST["away"]=iconv("GB2312","UTF-8","�Ƹ�ͨ");
$bw->insert('bw_moneyrecord', $_POST);

/* ����֧��������� */
$reqHandler = new PayRequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);

//----------------------------------------
//����֧������
//----------------------------------------
$reqHandler->setParameter("bargainor_id", $bargainor_id);			//�̻���
$reqHandler->setParameter("sp_billno", $sp_billno);					//�̻�������
$reqHandler->setParameter("transaction_id", $transaction_id);		//�Ƹ�ͨ���׵���
$reqHandler->setParameter("total_fee", $total_fee*100);					//��Ʒ�ܽ��,�Է�Ϊ��λ
$reqHandler->setParameter("return_url", $return_url);				//���ش�����ַ
$reqHandler->setParameter("desc", "�����ţ�" . $transaction_id);	//��Ʒ����

//�û�ip,���Ի���ʱ��Ҫ�����ip��������ʽ�����ټӴ˲���
$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);

//�����URL
$reqUrl = $reqHandler->getRequestURL();

//debug��Ϣ
//$debugInfo = $reqHandler->getDebugInfo();

//echo "<br/>" . $reqUrl . "<br/>";
//echo "<br/>" . $debugInfo . "<br/>";

//�ض��򵽲Ƹ�֧ͨ��
//$reqHandler->doSend();
echo "<script language='javascript' type='text/javascript'>"; echo "window.location.href='$reqUrl'"; echo "</script>";

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk">
	<title>�Ƹ�ͨ��ʱ���ʸ���</title>
</head>
<body>
<br/><a href="<?php echo $reqUrl ?>" target="_blank">�Ƹ�֧ͨ��</a>
</body>
</html>