<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = './timetable.css';

  $db = new DBC;

  $db->DBI();
  $location_name = 1;
  $date = 1;

  $location_name = $_GET['location_name'];
  $classroom = $_GET['classroom'];
  $date = $_GET['day'];
  $day = ['', 'SUN', 'MON', 'TUE', 'WEN', 'THU', 'FRI', 'SAT'];
  $classrooms;
  $timetable;

  $db->query = "SELECT Class_room FROM CLASSROOM WHERE Lnum = $location_name";
  $db->DBQ();
  $num = $db->result->num_rows;

  for($j = 0 ; $data = $db->result->fetch_row(); $j++)
    $classrooms[$j] = $data[0];

  $base->content .= "<p>".$day[$date]."</p>";


  $base->content .= "<table style='width:100%;background-color: #ffffff; margin-left: auto; margin-right: auto; border-radius: 5px;border-top: solid; border-bottom:solid;'><tr><td>강의실</td>";

  for($i = 8 ; $i < 23; $i++){

     $base->content .= "<td colspan = '12'>$i</td>";

  }
 $base->content .= "</tr>";

 for($i = 0 ; $i < $num; $i++){
   $timetable = array();
   $size = 180;
   $base->content.= "<tr><td>$classrooms[$i]</td>";
   $db->query = "SELECT Cname, Exam_room, Estime, Eftime FROM COURSE, EXAM WHERE Cnumber=Cnum AND Eday = '$day[$date]' AND Exam_room = '$classrooms[$i]'";
   $db->DBQ();


   if($db->result)
     while($data = $db->result->fetch_row()){

       $Stime = explode(':', $data[2]);
       $Etime = explode(':', $data[3]);

       $Stime[0] = intval($Stime[0]);
       $Stime[1] = intval($Stime[1]);
       $Etime[0] = intval($Etime[0]);
       $Etime[1] = intval($Etime[1]);

       $j = intval(($Stime[0] * 60 + $Stime[1] - 480)/5);
       $timetable[$j] = intval(($Etime[0] * 60 + $Etime[1] - 480)/5) - $j;

     }
   for($j = 0; $j < $size; $j ++){

     if($timetable[$j]){

       $base->content .= "<td colspan = '$timetable[$j]' style = 'background : gray;'> </td>";
       $size -= $timetable[$j];
       $size += 1;
       for($k = 0; $k < $timetable[$j] ; $k ++) // 이 자리부터 시간표만큼 테이블을 만들지 않음
         $timetable[$j + $k] = 1;
     }

     else if($timetable[$j] == 1){

     }

     else
       $base->content .= "<td></td>";
   }
   $base->content .= "</tr><tr>";
 }
$base->content .= "</tr></table>";
 $base->LayoutViewer();

?>
