<?php

require_once '../layout.inc';
require_once '../Database/db.php';

$base = new Layout;
$base->link = '../style.css';


$db = new DBC;

$db->DBI();

$location_num='-';
$classroom_name='-';

if(isset($_POST['course_number'])){
  $Cnumber = $_POST['course_number'];
}
else {
  echo "ERROR";
}

$location_name = $_GET['location_name'];
$classroom = $_GET['classroom'];
$timetable_data = array();
$day = ['MON' => 2, 'THU' => 3, 'WEN' => 4, 'TUR' => 5, 'FRI' => 6, 'SAT' => 7, 'SUN' => 1];
/*
$array = "new Array(1, 2, 3, 4, 5)";
$base->script = "var arr = $array; var i; document.write($Cnumber); for(i = 0 ; i < arr.length ; i ++)document.write(arr[i]);";
*/
$base->content = "<iframe name = 'timetable' src = 'timetable_view.php?day=2&location_name=1&classroom=1+345' width = '100%' height = '200px'  frameborder=0 framespacing=0 marginheight=0 marginwidth=0 scrolling=no vspace=0 style = 'margin-left: auto; margin-right: auto; width = '100%''></iframe>

   <form action='./timetable_view.php' target='timetable' method='GET'>
     <div>
        <p style = 'text-align : center;'> 시험 일정 선택 </p>
        <table style='width: 60%;background-color: #ffffff; margin-left: auto; margin-right: auto; border-radius: 5px; height: 500px; border-top: solid; border-bottom:solid;'>
           <tr>

              <td><label for='course_name' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>강의명</label></td>

              <td class='text' style='margin-top:10px;'>
                 ".$Cnumber."
              </td>

           </tr>
           <tr>

              <td><label for='day' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>요일</label></td>

              <td>
                <select name='day' id = 'day'>
                  <option value = '1'>일</option>
                  <option value = '2'>월</option>
                  <option value = '3'>화</option>
                  <option value = '4'>수</option>
                  <option value = '5'>목</option>
                  <option value = '6'>금</option>
                  <option value = '7'>토</option>
                </select>
              </td>
           </tr>

           <tr>

              <td><label for='location_name' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>건물번호</label></td>

              <td>
                <select name='location_name' id = 'location'>";

$db->query = "SELECT * FROM LOCATION";

$db->DBQ();

if($db->result){
  while($data = $db->result->fetch_row()){
    if($location_num == $data[1]){
      $base->content .= " <option value='".$data[0]."' selected = 'selected'>".$data[1]."</option>";
    }
    else{
      $base->content .= " <option value='".$data[0]."'>".$data[1]."</option>";
    }
  }
}

else echo "error";

$base->content .="</select>
              </td>

           </tr>

           <tr>

              <td><label for='classroom' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>강의실</label></td>

              <td>
                <select name='classroom' id = classroom>";


$db->query = "SELECT * FROM CLASSROOM";

$db->DBQ();

if($db->result){
  while($data = $db->result->fetch_row()){

    if($classroom == $data[0]){
      $base->content .= " <option value='".$data[0]."' selected='selected'>".$data[0]."</option>";
    }
    else{
      $base->content .= " <option value='".$data[0]."'>".$data[0]."</option>";
    }
  }
}

else echo "error";


$base->content .="</select>
              </td>

           </tr>

           <tr>
            <td><label for='classroom' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>시작시간</label></td>
            <td><input type = 'time' id='stime'></input></td>
          </tr>
          <tr>
            <td><label for='classroom' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>종료시간</label></td>
            <td><input type = 'time' id='ftime'></input></td>

           </tr>

           <tr>
              <td><input type='submit' value='조회' id='submit-btn' style = 'width : 100%;'/></form></td>
              <script>function send(){
                var day = document.getElementById('day');
                var classroom = document.getElementById('classroom');
                var location = document.getElementById('location');
                var stime = document.getElementById('stime');
                var ftime = document.getElementById('ftime');
                var link = ''

                link = 'course_number=' + $Cnumber + '&day=' + day.options[day.selectedIndex].value + '&classroom=' + classroom.options[classroom.selectedIndex].value.replace(' ', '+')
                + '&location=' + location.options[location.selectedIndex].value + '&stime=' + stime.value
                + '&ftime=' + ftime.value;

                window.location.href = window.location.href.replace('schedulei.php', 'scheduler.php/?' + link);

              }</script>
              <td><input type='submit' value='예약하기' id='submit-btn' onclick = 'send()' style = 'width : 100%;'/></td>

           </tr>
          </table>
         </div>


";
/*link += '&stime=' + stime.options[stime.selectedIndex].value;
link += '&ftime=' + ftime.options[ftime.selectedIndex].value;*/

$base->LayoutMain();
/*
동적조회
$i = 0;
$db->query = "SELECT MAX(Lnumber) AS max_number FROM LOCATION";// -- for문을 돌릴 때 쓰는 값

$db->DBQ();
$MAX = $db->result->fetch_row();
$MAX = $MAX[0];

$buildings ='[';
for($i = 1 ; $i <= $MAX; $i++){
  $db->query = "SELECT Class_room FROM CLASSROOM WHERE Lnum = $i";
  $db->DBQ();
  if($db->result){
    $buildings .= '[';

    for($j = 0; $j < $db->result->num_rows; $j++){
      $data = $db->result->fetch_row();
      if($j != $db->result->num_rows - 1)
        $buildings .= $data[0] .', ';
      else
        $buildings .= $data[0];
    }
    if($i != $MAX)
      $buildings .= '],';
    else
      $buildings .= ']';
  }
}
$buildings .= ']';

echo $buildings;

for($i = 1 ; $i <= $MAX ; $i++){
  for($j = 0 ; $j < count($timetable_data[$i]); $j++){
    $Class_room = $timetable_data[$i][$j][0];
    $db->query = "SELECT Estime, Eftime, Eday, Cname FROM EXAM, COURSE WHERE Cnumber = Cnum AND Exam_room = '$Class_room'";
    $db->DBQ();

    if($db->result){
      $k = 0;
      while($data = $db->result->fetch_row()){
        $data = str_replace(';'.$data[2], '',implode(';', $data));

        echo $timetable_data[$i][$j][1][$day[$data[2]]][$k++] = $data;

      }
    }
  }
}
$total_data ='[';
for($i = 1; $i <= $MAX; $i++){
  $total_data .='[';
  for($j = 0; $j < count($timetable_data[$i]); $j++){
    $total_data .='[[],';
    for($k = 1; $k <= 7; $k++){
      $total_data .='[';
      for($p = 0; $p < count($timetable_data[$i][$j][1][$k]); $p++){
        $total_data .= $timetable_data[$i][$j][1][$k][$p];
        if($p != count($timetable_data[$i][$j][1][$k]) - 1)
          $total_data .= ', ';

      }
      if($k != 7)
        $total_data .= '],';
      else
        $total_data .= ']';
    }
    if($j != count($timetable_data[$i])-1)
      $total_data .= '],';
    else
      $total_data .= ']';
  }
  if($i != $MAX)
    $total_data .= '],';
  else
    $total_data .= ']';
}
$total_data .= ']';

echo $total_data;
*/
?>
