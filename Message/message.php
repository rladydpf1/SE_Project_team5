
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


$sender = '0000';
$receiver = '0001';
$course_number = '3';
$location = '융복';
$class_room = '351호';
$day = '수';
$stime = '13';
$ftime = '14';
$scnumber='4';


$base = new Layout;
$base->link = '../style.css';

$id = $_SESSION['id'];

$base->content = "<form action='messageSender.php' method='post'>
<fieldset style='width: 400px; margin-left: auto; margin-right: auto; border: none;'>
<p> 쪽지 </p>
<table style='margin-bottom: -15px;'>
  <tr>
    <td style='text-align:left;'><label for='title' id='msg-table-text'>제목</label></td>
    <td><input type='text' id='title' name='title'maxlength='40' size='30' required/></td>
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
    <td style='text-align:left;'><label for='contents' id='msg-table-text'>내용</label></td>
    <td><p style='text-align:left;'><textarea name='contents' rows='10' cols='80' type='text' required></textarea></p></td>
  </tr>
</table>


  <p><input type='submit' value='전송' id='submit-btn'/></p>
</fieldset>
  <input type = hidden id = 'sender' name = 'sender' value = '".$id."'> </input>
  <input type = hidden id = 'receiver' name = 'receiver' value = '".$receiver."'> </input>
  <input type = hidden id = 'rcnumber' name = 'rcnumber' value = '".$course_number."'> </input>
  <input type = hidden id = 'location' name = 'location' value = '".$location."'> </input>
  <input type = hidden id = 'class_room' name = 'class_room' value = '".$class_room."'> </input>
  <input type = hidden id = 'day' name = 'day' value = '".$day."'> </input>
  <input type = hidden id = 'stime' name = 'stime' value = '".$stime."'> </input>
  <input type = hidden id = 'ftime' name = 'ftime' value = '".$ftime."'> </input>
  <input type = hidden id = 'scnumber' name = 'scnumber' value = '".$scnumber."'> </input>
</form>";

$base->LayoutMain();
?>
