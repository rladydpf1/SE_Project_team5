<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = './menu_bar.css';

  if(isset($_POST['course_number'])){
    $Cnumber = $_POST['course_number'];
  }
  else {
    echo 'ERROR';
  }


  $db = new DBC;

  $db->DBI();
  $base->content = "<div class='menubar'><ul>";


  $db->query = "SELECT Lnumber, Lname FROM LOCATION"; //건물번호 가져오기

  $db->DBQ();

  $num = $db->result->num_rows;
  $data = $db->result->fetch_row();

  for ($i = 0; $i < $num ; $i++){

    $building_num[$data[0]] = $data[1];
    $base->content .= "<li><a href ='#'>$data[1]</a>";

    $db->query = "SELECT Class_room FROM CLASSROOM WHERE Lnum = $data[0]"; //건물번호 가져오기

    $db->DBQ();

    $num2 = $db->result->num_rows;
    $data = $db->result->fetch_row();

    $base->content .= "<ul>";
    for($j = 0 ; $j < $num2 ; $j++){
         $base->conntent .= "<li><a href='#'>".$data[".$j."]."</a></li>";
    }

    $base->content .= "</ul></li>";
  }

  //회원가입 페이지 양식 출력


  /*
             <li><a href='#'>Home</a></li>
             <li><a href='#' id='current'>Products</a>
            	<ul>
                 <li><a href='#'>Sliders</a></li>
                 <li><a href='#'>Galleries</a></li>
                 <li><a href='#'>Apps</a></li>
                 <li><a href='#'>Extensions</a></li>
                </ul>
             </li>
             <li><a href='#'>Company</a></li>
             <li><a href='#'>Address</a></li>"; */
  $base->content .= "</ul></div>";
  $base->LayoutMain();

?>
