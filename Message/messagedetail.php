<?php

require_once '../layout.inc';
require_once '../Database/db.php';

$base = new Layout;
$base->link = '../style.css';

if(!isset($_GET['num'])){

    echo "<script>alert('잘못된 경로');location.replace('./login.php');</script>";

}
$num = $_GET['num'];

$db = new DBC;

$db->DBI();

$db->query = "SELECT * FROM MESSAGE WHERE Mnumber = ".$num;

$db->DBQ();

if($db->result){

  $data = $db->result->fetch_row();
  $db->query = "SELECT Lname,Cname,Course_room  FROM LOCATION, CLASSROOM, COURSE WHERE Cnumber = ".$data[2]." AND Course_room = Class_room AND Lnum = Lnumber;";
  $db->DBQ();
  if($db->result){
    $sdata = $db->result->fetch_row();
    $base->content .= "
      제목 : ".$data[5]." <br/>
      보낸 사람 : ".$data[3]." <br/>
      강의번호 : ".$sdata[1]." <br/>
      건물번호 : ".$sdata[0]." <br/>
      강의실 : ".$sdata[2]." <br/>
      요일 : ".$data[8]." <br/>
      시간 : ".$data[6]."~".$data[7]." <br/>
      내용 : ".$data[9]." <br/>
      발신 시각 : ".$data[10]." <br/>

      ";
  }
}

$base->LayoutMain();

$db->DBO();
?>
