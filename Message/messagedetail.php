<?php

require_once '../layout.inc';
require_once '../Database/db.php';

$base = new Layout;
$base->link = '../style.css';

if(!isset($_GET['num'])){

    echo "<script>alert('잘못된 경로');location.replace('./login.php');</script>";

}
$num = $_GET['num'];
$link='./messageaprocess.php';
  $base->style = ' th, td{ border-right:1px solid #808080; } h1 {text-align : center;}';
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

    $base->content .= "<table id = 'maintable'>";
    $base->content .= "
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>제목</td>
      <td style='width:400px;'>".$data[5]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>보낸 사람</td>
      <td>".$data[3]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>발신 시각</td>
      <td>".$data[10]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>강의번호</td>
      <td>".$sdata[1]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>건물번호</td>
      <td>".$sdata[0]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>강의실</td>
      <td>".$sdata[2]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>요일</td>
      <td>".$data[8]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>시간</td>
      <td>".$data[6]."~".$data[7]."</td>
    </tr>
    <tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
      <td>내용</td>
      <td style='height:200px'>".$data[9]."</td>
    </tr>

    </table>
    <br>
    <table style='border-collapse : collapse; table-layout:fixed; margin:auto;'>
      <td style='border-right:none;'>
    <form action='./messageprocess.php'>
        <input type = hidden id = 'accept' name = 'accept' value = 1> </input>
        <input type = hidden id = 'num' name = 'num' value = '".$num."'> </input>
        <input type='submit' value='수락'>
        </td>
        <td style='border-right:none;'>
      </form><form action='./messageprocess.php'>
        <input type = hidden id = 'accept' name = 'accept' value = 0> </input>
        <input type = hidden id = 'num' name = 'num' value = '".$num."'> </input>
        <input type='submit' value='거부'>
      </form>
      </td>
      </table>
    ";
  }
}



$base->LayoutMain();

$db->DBO();
?>
