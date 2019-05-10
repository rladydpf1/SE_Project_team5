<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = './style.css';

  //$id = $_SESSION['id'];
  $id = "2017112000";

  $db = new DBC;

  $db->DBI();

  //학생이 수강중인 수업번호 가져오기
  $db->query = "SELECT Cname, Pnum, Course_room, Cstime, Cftime, Cday FROM	COURSE, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM, CLASSHOUR WHERE	Snumber = '".$id."' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Conum AND Course_room = Class_room";

  $db->DBQ();

  $num = $db->result->num_rows;

  $base->content .= "<h1>수강 목록</h1><br><div class = 'course_style'>";
  $base->content .= " 강의명 번호 강의실 강의시간 ~ 강의 날짜 <br>";
  for($i = 0 ; $i < $num ; $i ++){

    $data = $db->result->fetch_row();

    $base->content .= "  '".$data[0]."' '".$data[1]."' '".$data[2]."' '".$data[3]."' '".$data[4]."' '".$data[5]."' <br>";

  }

  $base->content .= "</div>";

  $base->LayoutMain();

?>
