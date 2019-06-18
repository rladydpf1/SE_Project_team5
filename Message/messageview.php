
<?php

require_once '../layout.inc';
require_once '../Database/db.php';

$base = new Layout;
$base->link = '../style.css';

$db = new DBC;

$db->DBI();

$id = $_SESSION['id'];

$db->query = "SELECT Mnumber, Title, Sender, Lname, Course_room, Mstime, Mftime, Mday, Mtime
FROM MESSAGE, LOCATION, CLASSROOM, COURSE
WHERE Receiver = '".$id."' AND RCnumber = Cnumber AND Course_room = Class_room AND Lnum = Lnumber;";
$db->DBQ();

if($db->result){
  $base->content .="<table style='margin-bottom: -15px;'>
  <tr>
    <th>제목</th>
    <th>보낸 사람</th>
    <th>건물 이름</th>
    <th>강의실</th>
    <th>시간</th>
    <th>요일</th>
    <th>보낸 시각</th>
  </tr>
  ";
  while($data = $db->result->fetch_row())
    $base->content .= "<tr>
      <td><a href='./messagedetail.php?num=".$data[0]."'>".$data[1]."</a></td>
      <td>".$data[2]."</td>
      <td>".$data[3]."</td>
      <td>".$data[4]."</td>
      <td>".$data[5]."~".$data[6]."</td>
      <td>".$data[7]."</td>
      <td>".$data[8]."</td>
      </tr>
    ";
  $base->content .="</table>";
}
$db->DBO();

$base->LayoutMain();


?>
