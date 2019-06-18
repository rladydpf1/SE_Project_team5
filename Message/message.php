
<?php

require_once '../layout.inc';
/*
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$course_number = $_POST['course_number'];
$location = $_POST['location'];
$class_room = $_POST['class_room'];
$day = $_POST['day'];
$stime = $_POST['stime'];
$ftime = $_POST['ftime'];*/


$sender = '보냄';
$receiver = '받음';
$course_number = '1';
$location = '융복';
$class_room = '351호';
$day = '수';
$stime = '13시';
$ftime = '14시';


$base = new Layout;
$base->link = '../style.css';

$id = $_SESSION['id'];

$base->content = "<form action='messageSender.php' method='post'>
<fieldset style='width: 400px; margin-left: auto; margin-right: auto; border: none;'>
<p> 쪽지 </p>
<table style='margin-bottom: -15px;'>
  <tr>
    <td style='text-align:left;'><label for='Title' id='msg-table-text'>제목</label></td>
    <td><input type='text' id='Title' name='Title'maxlength='40' size='30' required/></td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='sender' id='msg-table-text'> 보내는 사람 </td>
    <td>".$sender."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Receiver' id='msg-table-text'> 강의 번호 </td>
    <td>".$course_number."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Receiver' id='msg-table-text'> 건물번호 </td>
    <td>".$location."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Receiver' id='msg-table-text'> 강의실 </td>
    <td>".$class_room."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Receiver' id='msg-table-text'> 요일 </td>
    <td>".$day."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Receiver' id='msg-table-text'> 시간 </td>
    <td>".$stime."~".$ftime."</td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='body' id='msg-table-text'>내용</label></td>
  </tr>
</table>

<p style='text-align:left;'><textarea name='body' rows='10' cols='80' type='text' required></textarea></p>
  <p><input type='submit' value='전송' id='submit-btn'/></p>
</fieldset>
</form>";

$base->LayoutMain();
?>
