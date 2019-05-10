<?php

require_once '../layout.inc';

require_once '../db.php';



$db = new DBC;

$db->DBI();



$base = new Layout;

$base->link = '../style.css';


//registi에서 post로 회원가입 정보 받아옴
$id = $_POST['id'];

$pass1 = $_POST['pass1'];

$pass2 = $_POST['pass2'];

$regist_type=$_POST['regist_type'];

$name = $_POST['name'];

$phone = $_POST['phone'];

$address = $_POST['address'];

$mail = $_POST['mail'];

$date = date('Y-m-d');

//설정되지 않은 변수가 있다면 이전 페이지로 되돌아감
if(!isset($id) || !isset($pass1) || !isset($pass2) || !isset($mail) ||
   !isset($regist_type) || !isset($name) || !isset($phone) || !isset($address))
{
header("Content-Type: text/html; charset=UTF-8");
echo "<script>alert('빈 칸이 존재합니다.');history.back();</script>";
exit;
}


if($pass1 == $pass2) //비밀번호가 동일하면 비밀번호 저장

{

	$pass = $pass1;

} else //비밀번호가 동일하지않으면 alert하며 이전 페이지로 돌아감

{

	header("Content-Type: text/html; charset=UTF-8");

	echo "<script>alert('비밀번호가 맞지 않습니다.');history.back();</script>";

	exit;

}


//member에 회원정보 db 삽입
$db->query = "insert into member values
('".$id."', password('".$pass."'), '".$mail."', '".$date."', 1,'".$regist_type."', '".$address."', '".$phone."', '".$name."')";

$db->DBQ();



if(!$db->result) //쿼리가 제대로 실행되지 않았을경우

{

	header("Content-Type: text/html; charset=UTF-8");

	echo "<script>alert('회원가입에 실패하였습니다.');history.back();</script>";

	$db->DBO();

	exit;



} else

{

	echo "<script>alert('".$id."님의 회원가입을 환영합니다. 로그인 화면으로 이동합니다.');location.replace('./login.php');</script>";

	$db->DBO();

	exit;

}





$base->content = "";



$base->LayoutMain();



?>
