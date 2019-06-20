<?php
require_once '../Database/db.php';
require_once '../layout.inc';

$base = new Layout;
$base->link = './timetable.css';

echo "<br>".$sender = $_POST['sender'];
echo "<br>".$receiver = $_POST['receiver'];
echo "<br>".$rcnumber = $_POST['rcnumber'];
echo "<br>".$day = $_POST['day'];
echo "<br>".$stime = $_POST['stime'];
echo "<br>".$ftime = $_POST['ftime'];
echo "<br>".$scnumber=$_POST['scnumber'];
echo "<br>".$title=$_POST['title'];
echo "<br>".$contents=$_POST['contents'];

$db = new DBC;
$db->DBI();

$db->query="SELECT MAX(Mnumber) FROM MESSAGE";
$db->DBQ();
$num = $db->result->num_rows;
$data = $db->result->fetch_row();


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
  $db->DBQ();
  

  echo "<script>window.location.href = window.location.href.split('/Message/')[0] + '/Course%20List/main_view.php'</script>";
}

?>
