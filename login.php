<?php

require_once './db.php';

$db = new DBC;
$db->DBI();

//id와 password값을 post 형태로 받음
$id = $_POST['login_id'];
$pass = $_POST['login_passwd'];

//id와 password에 해당하는 정보 쿼리로 받음
$db->query = "select id, pass, permit,regist_type from member where id='".$id."' and pass=password('".$pass."')";
$db->DBQ();

$num = $db->result->num_rows;
$data = $db->result->fetch_row();
$db->DBO();

//해당하는 정보가 1개면 접속을 하고 세션값으로 나머지 정보를 받으며 메인페이지로 돌아감
if($num==1)
{
   $_SESSION['id'] = $id;
   $_SESSION['permit'] = $data[2];
   $_SESSION['regist_type']=$data[3];
   echo "<script>location.replace('/');</script>";
} else if(($id!="" || $pass!="") && $data[0]!=1) //아이디 비밀번호 정보가 맞지않을 경우
{
   echo "<script>alert('아이디와 비밀번호가 맞지 않습니다.');</script>";
}
?>
