<?php
require_once '../layout.inc';
require_once '../Database/db.php';
$base = new Layout;
$base->link = '../style.css';
$db = new DBC;
$db->DBI();
if(!isset($_GET['num'])){
    echo "<script>alert('잘못된 경로');location.replace('./login.php');</script>";
}
$num = $_GET['num'];
$accept = $_GET['accept'];
echo $accept;
echo $num;

if ($accept == 0) { // 거절한 경우
    $db->query = "SELECT Receiver, Sender, Title FROM MESSAGE WHERE Mnumber = ".$num;
    $db->DBQ();
    $data = $db->result->fetch_row();
    $db->query = "UPDATE MESSAGE
        SET Receiver = '".$data[0]."', Sender = '".$data[1]."', Title = '<거절>".$data[2]."', Mtime = NOW()
        WHERE Mnumber = ".$num;
    $db->DBQ();
    echo "<script>alert('거절하였습니다.');history.back();</script>";
}

elseif ($accept == 1) { // 수락한 경우
    $db->query = "SELECT MAX(Enumber) FROM EXAM";
    $db->DBQ();
    $data = $db->result->fetch_row();
    $num = $db->result->num_rows;
    $max_number = 1;
    if ($num >= 1) {
        $max_number = $data[0] + 1;
    }
    $db->query = "SELECT SCnumber, Course_room, Mstime, Mftime, Mday
        FROM MESSAGE, COURSE WHERE Mnumber = ".$num." AND Cnumber = RCnumber";
    $db->DBQ();
    $data = $db->result->fetch_row();
    $db->query = "INSERT INTO EXAM VALUES (".$max_number.", ".$data[0].", '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."')";

    $db->query = "SELECT Receiver, Sender, Title FROM MESSAGE WHERE Mnumber = ".$num."";
    $db->DBQ();
    $data = $db->result->fetch_row();
    $db->query = "UPDATE MESSAGE
        SET Receiver = '".$data[0]."', Sender = '".$data[1]."', Title = '<수락> '.'".$data[2]."', Mtime = NOW()
        WHERE Mnumber = ".$num."";
    echo "<script>alert('수락하였습니다.');history.back();</script>";
}

$base->LayoutMain();
$db->DBO();
?>
