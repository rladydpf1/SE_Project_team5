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

$base->content = "";

$base->content = "

   <form action='./schedulei.php' method='GET'>
     <div>
        <p> 시험 일정 선택 </p>
        <table style='width: 60%;background-color: #ffffff; margin-left: auto; margin-right: auto; border-radius: 5px; height: 500px; border-top: solid; border-bottom:solid;'>
           <tr>

              <td><label for='course_name' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>강의명</label></td>

              <td class='text' style='margin-top:10px;'>
                 ".$Cnumber."
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

              <td colspan='2'><input type='submit' value='예약하기' id='submit-btn'/></td>

           </tr>
          </table>
         </div>
   </form>

";

$base->LayoutMain();

?>
