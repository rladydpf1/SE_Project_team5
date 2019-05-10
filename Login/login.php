<?php

require_once '../Database/db.php';

$db = new DBC;
$db->DBI();

//id와 password값을 post 형태로 받음
$id = $_POST['login_id'];
$pass = $_POST['login_passwd'];

//id와 password에 해당하는 정보 쿼리로 받음
$db->query = "select Ppwd from PROFESSOR where Pnumber='".$id."'";
$db->DBQ();

$num = $db->result->num_rows;
$data = $db->result->fetch_row();

if($num==1)
{
   if ($data[0] == $pass)
   {
      $_SESSION['id'] = $id;
      $_SESSION['regist_type']= 1; // 교수
      echo "<script>location.replace('/');</script>";
   }
   else 
   {
      echo "<script>alert('비밀번호가 맞지 않습니다.');</script>";
      echo "<script>location.replace('/');</script>";
   }
} 
$db->query = "select Spwd from STUDENT where Snumber='".$id."'";
$db->DBQ();

$num = $db->result->num_rows;
$data = $db->result->fetch_row();
else if($num == 1)
{
   if ($data[0] == $pass)
   {
      $_SESSION['id'] = $id;
      $_SESSION['regist_type']= 2; // 학생
      echo "<script>location.replace('/');</script>";
   }
   else 
   {
      echo "<script>alert('비밀번호가 맞지 않습니다.');</script>";
      echo "<script>location.replace('/');</script>";
   }
}
else
{
   echo "<script>alert('아이디가 일치하지 않습니다.');</script>";
   echo "<script>location.replace('/');</script>";
}

$db->DBO();
?>
