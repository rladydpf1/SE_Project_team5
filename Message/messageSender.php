<?php
require_once '../Database/db.php';
require_once '../layout.inc';

$base = new Layout;
$base->link = './timetable.css';

$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$rcnumber = $_POST['rcnumber'];
$day = $_POST['day'];
$stime = $_POST['stime'];
$ftime = $_POST['ftime'];
$scnumber=$_POST['scnumber'];
$title=$_POST['title'];
$contents=$_POST['contents'];

$db = new DBC;
$db->DBI();

$db->query="SELECT MAX(Mnumber) FROM MESSAGE";
$db->DBQ();
$num = $db->result->num_rows;
$data = $db->result->fetch_row();

//echo $sender;
echo $data[0];

if($data[0]==NULL){
  $db->query="INSERT INTO MESSAGE VALUES (1, '$receiver', $rcnumber, '$sender', $scnumber, '$title','$stime', '$ftime', '$day',' $contents', NOW())";
}
else {
  $db->query="INSERT INTO MESSAGE VALUES (".$data[0]." + 1, '$receiver', $rcnumber, '$sender', $scnumber, '$title','$stime', '$ftime', '$day',' $contents', NOW())";
}

if($db->result->num_rows<1){
  echo 'error';
}
else {
  echo 'no';
  $db->DBQ();
  $db->DBO();
}

?>
