<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = './style.css';

  $id = $_SESSION['id'];
  $regist_type = $_SESSION['regist_type'];
  $id = '0000';
  $regist_type = 1;

  $db = new DBC;

  $db->DBI();

  //학생이 수강중인 수업번호 가져오기
  if($regist_type == 2){

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

    $db->query = "SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
    FROM	COURSE, EXAM, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM
    WHERE	Snumber = '".$id."' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Cnum AND Exam_room = Class_room;";

    $db->DBQ();

    $num = $db->result->num_rows;

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();

      $base->content .= "<tr style='text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$data[2]."</td>
                          <td>".$data[3]."</td>
                          <td>".$data[4]."</td>
                          <td>".$data[5]."</td>
                          <td>".$data[6]."</td>
                        </tr>";
    }

    $base->content .= "</table>";

  }

  //교수가 수업중인 목록 출력
  else if($regist_type == 1){

    $db->query = "SELECT	Cname, Course_room, Cstime, Cftime, Cday
    FROM	COURSE, PROFESSOR, LOCATION, CLASSROOM, CLASSHOUR
    WHERE	Pnumber = '".$id."' AND Pnumber = Pnum AND Cnumber = Conum AND Course_room = Class_room;";

    $db->DBQ();

    $num = $db->result->num_rows;

    $base->content .= "<h1>수업 목록</h1><br>";
    $base->content .= "<table>";
    $base->content .= "<tr style=' padding: 10px;' id=course_title>
                        <th>Cname</th>
                        <th>Pnum</th>
                        <th>Course_room</th>
                        <th>Cstime</th>
                        <th>Cftime</th>
                        <th>Cday</th>
                        <th>시험시간 설정</th>
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
                          <td>
                            <form action = '../Exam Schedule/schedulei.php' method = 'post'>
                              <input type = hidden id = 'course_name' name = 'course_name'  value = '".$data[0]."'></input>
                              <input type = submit id = 'submit' value = ''></input>
                            </form>
                          </td>
                        </tr>";

    }

    $base->content .= "</table>";

    //시험 시간표 출력
    $base->content .= "<h1>시험 시간</h1><br><div class = 'test_timetable'>";

    $db->query = "SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
    FROM	COURSE, EXAM, PROFESSOR, LOCATION, CLASSROOM
    WHERE	Pnumber = '".$id."' AND Pnumber = Pnum AND Cnumber = Cnum AND Exam_room = Class_room;";


    $db->DBQ();

    $num = $db->result->num_rows;

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();

      $base->content .= "<tr style='text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$data[2]."</td>
                          <td>".$data[3]."</td>
                          <td>".$data[4]."</td>
                          <td>".$data[5]."</td>
                          <td>".$data[6]."</td>
                        </tr>";
    }

    $base->content .= "</table>";
  }

  /*
  else{
    for($i = 0 ; $i < 1000000; $i ++)
      echo "김지민";
  }
  */

  $base->LayoutMain();
  $db->DBO();
?>
