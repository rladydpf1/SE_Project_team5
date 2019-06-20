
<?php

require_once '../layout.inc';


$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$rcnumber = $_POST['rcnumber'];
$scnumber = $_POST['scnumber'];
$location = $_POST['location'];
$class_room = $_POST['class_room'];
$day = $_POST['day'];
$stime = $_POST['stime'];
$ftime = $_POST['ftime'];

/*
$sender = '0000';
$receiver = '0001';
$course_number = '3';
$location = '융복합관';
$class_room = '1 351';
$day = '수';
$stime = '13:00:00';
$ftime = '14:30:00';
$scnumber='4';*/


$base = new Layout;
$base->link = '../style.css';

$id = $_SESSION['id'];

$base->content = "<form action='messageSender.php' method='post'>
<h1 style='text-align : center;'> 쪽지 </h1>
<table style='border-collapse : collapse; table-layout:fixed; margin:auto;' >
  <tr>
    <td style=' text-align: center;width:100px;'>제목</td>
    <td><input type='text' id='title' name='title'maxlength='40' size='80' required/></td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'>받는 사람 </td>
    <td>".$receiver."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'> 강의 번호 </td>
    <td>".$rcnumber."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'> 건물번호 </td>
    <td>".$location."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'>강의실 </td>
    <td>".$class_room."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'> 요일 </td>
    <td>".$day."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'>시간 </td>
    <td>".$stime."~".$ftime."</td>
  </tr>
  <tr>
    <td style=' text-align: center;width:100px;'>내용</td>
    <td><textarea name='contents' rows='10' cols='80' type='text' required></textarea></td>
  </tr>
</table>


  <div style = 'text-align:center'><input type='submit' value='전송' id='submit-btn' style='border-collapse : collapse; table-layout:fixed; margin:auto;'/></p></div>
  <input type = hidden id = 'sender' name = 'sender' value = '".$id."'> </input>
  <input type = hidden id = 'receiver' name = 'receiver' value = '".$receiver."'> </input>
  <input type = hidden id = 'rcnumber' name = 'rcnumber' value = '".$rcnumber."'> </input>
  <input type = hidden id = 'scnumber' name = 'scnumber' value = '".$scnumber."'> </input>
  <input type = hidden id = 'location' name = 'location' value = '".$location."'> </input>
  <input type = hidden id = 'class_room' name = 'class_room' value = '".$class_room."'> </input>
  <input type = hidden id = 'day' name = 'day' value = '".$day."'> </input>
  <input type = hidden id = 'stime' name = 'stime' value = '".$stime."'> </input>
  <input type = hidden id = 'ftime' name = 'ftime' value = '".$ftime."'> </input>
</form>";

$base->LayoutMain();
?>
