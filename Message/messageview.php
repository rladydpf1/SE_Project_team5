
<?php

require_once '../layout.inc';
require_once '../Database/db.php';

$base = new Layout;
$base->link = '../style.css';

$db = new DBC;

$db->DBI();

$id = $_SESSION['id'];

$db->query = "SELECT Mnumber, Sender, tiltle FROM MESSAGE WHERE Receiver = '".$id."'";
$db->DBQ();

if($db->result){
  while($data = $db->result->fetch_row())
    $base->content .= " 발신인 : ".$data[1]." 제목 : <a href = './messagedetail.php?num=".$data[0]."'>".$data[2]."</a><br/>";
}
$base->content .= "<button type='button' onclick='location.href=".'"./message.php"'."'>버튼</button>";
$db->DBO();

$base->LayoutMain();


?>
