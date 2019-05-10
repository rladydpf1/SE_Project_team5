<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = './style.css';

  //$id = $_SESSION['id'];
  $id = "2017000000";

  $db = new DBC;

  $db->DBI();

  //학생이 수강중인 수업번호 가져오기
  $db->query = "SELECT Cname, Pnum, Course_room, Cstime, Cftime, Cday FROM	COURSE, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM, CLASSHOUR WHERE	Snum = '".$id."' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Conum AND Course_room = Class_room";

  $db->DBQ();

  $num = $db->result->num_rows;

  //수업 목록 출력
  $base->content .= "<h1>수강 목록</h1><br>";
  $base->content .= "<table>";
  $base->content .= "<tr style=' padding: 10px;' id=course_title>
                      <th>Cname</th>
                      <th>Pnum</th>
                      <th>Course_room</th>
                      <th>Cstime</th>
                      <th>Cftime</th>
                      <th>Cday</th>
                    </tr>";

  for($i = 0 ; $i < $num ; $i ++){

    $data = $db->result->fetch_row();

    $base->content .= "<tr style='text-align: center; padding: 10px; ' id=course_text>
                        <td>".$data[0]."</td>
                        <td>".$data[1]."</td>
                        <td>".$data[2]."</td>
                        <td>".$data[3]."</td>
                        <td>".$data[4]."</td>
                        <td>".$data[5]."</td>
                      </tr>";

  }

  $base->content .= "</table>";

  //시험 시간표 출력
  $base->content .= "<h1>시험 시간</h1><br><div class = 'test_timetable'>";

  $base->LayoutMain();

?>
