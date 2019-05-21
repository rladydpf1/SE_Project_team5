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

$db->query = "SELECT Sender, tiltle, Contents, Mtime FROM MESSAGE WHERE Mnumber = '".$num."'";

$db->DBQ();

if($db->result){

    $data = $db->result->fetch_row();
    $base->content .= " 발신인 : ".$data[0]."<br/>";
    $base->content .= " 발신 시각 : ".$data[3]."<br/>";
    $base->content .= " 제목 : ".$data[1]." <br/>";
    $base->content .= " 내용 : ".$data[2]." <br/>";
}

$base->LayoutMain();

$db->DBO();
?>
