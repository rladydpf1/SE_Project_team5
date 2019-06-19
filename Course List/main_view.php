<?php

  require_once '../layout.inc';
  require_once '../Database/db.php';

  $base = new Layout;
  $base->link = '../style.css';

  $base->style = ' th, td{ border-right:1px solid #808080; } h1 {text-align : center;}';

  $id = $_SESSION['id'];
  $regist_type = $_SESSION['regist_type'];
  $timetable;
  $day = ["MON" => 2, 'THU' => 3, 'WEN' => 4, 'TUR' => 5, 'FRI' => 6, 'SAT' => 7, 'SUN' => 1];
  $building_num = [];

  $db = new DBC;

  $db->DBI();

  $db->query = "SELECT Lnumber, Lname FROM LOCATION"; //건물번호 가져오기

  $db->DBQ();

  $num = $db->result->num_rows;
  $data = $db->result->fetch_row();

  for ($i = 0; $i < $num ; $i++){

    $building_num[$data[0]] = $data[1];

  }

  //학생이 수강중인 수업번호 가져오기
  if($regist_type == 2){

    $db->query = "SELECT Cname, Pnum, Course_room, Cstime, Cftime, Cday FROM	COURSE, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM, CLASSHOUR WHERE	Snum = '".$id."' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Conum AND Course_room = Class_room";

    $db->DBQ();

    $num = $db->result->num_rows;

    //수업 목록 출력
    $base->content .= "<h1>수업 목록</h1>";
    $base->content .= "<table id = 'maintable'>";
    $base->content .= "<tr style=' border : 1px solid #808080; padding: 10px;' id=course_title>
                        <th>강의</th>
                        <th>교수</th>
                        <th>강의실</th>
                        <th>시작 시간</th>
                        <th>종료 시간</th>
                        <th>요일</th>
                      </tr>";

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();

      $data[2] = explode(' ', $data[2]);

      $base->content .= "<tr style=' border : 1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$building_num[$data[2][0]]."
                           ".$data[2][1]."</td>
                          <td>".$data[3]."</td>
                          <td>".$data[4]."</td>
                          <td>".$data[5]."</td>
                        </tr>";

    }

    $base->content .= "</table>";

    //시험 시간표 출력 부분
    $base->content .= "<h1>시험 시간</h1>";

    $db->query = "SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
    FROM	COURSE, EXAM, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM
    WHERE	Snumber = '".$id."' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Cnum AND Exam_room = Class_room;";

    $db->DBQ();

    $num = $db->result->num_rows;

    $base->content .= "<table id = 'maintable'>";
    $base->content .= "<tr style=' border : 1px solid #808080; padding: 10px;' id=course_title>
                        <th>강의번호</th>
                        <th>강의명</th>
                        <th>건물번호</th>
                        <th>강의실</th>
                        <th>시작 시간</th>
                        <th>종료 시간</th>
                        <th>요일</th>
                      </tr>";

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();
      //텍스트 시험 과목들
      $base->content .= "<tr style=' border:1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$data[2]."</td>
                          <td>".explode(" ", $data[3])[1]."</td>
                          <td>".$data[4]."</td>
                          <td>".$data[5]."</td>
                          <td>".$data[6]."</td>
                        </tr>";

        $Stime = explode(':', $data[4]);
        $Etime = explode(':', $data[5]);

        $Stime[0] = intval($Stime[0]);
        $Stime[1] = intval($Stime[1]);
        $Etime[0] = intval($Etime[0]);
        $Etime[1] = intval($Etime[1]);

        //시작시간을 8시로해서 5분단위로 쪼갠 index
        $j = intval(($Stime[0] * 60 + $Stime[1] - 480)/5);
        $timetable[$j][$day[$data[6]]] = (string)$data[1] ."<br>".(string)$data[2] ."<br>". (string)$data[3] ."<br>" . ":" . + (string)(intval(($Etime[0] * 60 + $Etime[1] - 480)/5) - $j);

    }

    $base->content .= "</table><br>";

    $base->content .= "<table id = 'maintable' width='100%' cellpadding='5' cellspacing='2' align='center' style='table-layout:fixed; word-break:break-all;'>
                        <tr>
                          <td width = '6%''></td>
                          <td>일</td>
                          <td>월</td>
                          <td>화</td>
                          <td>수</td>
                          <td>목</td>
                          <td>금</td>
                          <td>토</td>
                        </tr>";


    //그림 시험 과목출력
    for($i = 0 ; $i < 180 ; $i ++){


      if($i % 12 == 0){
        $base->content .= "<tr style = ' border-top : 1px solid #444444;'>";
        $time = (int)$i*5 / 60 + 8;

        $base->content .= "<td rowspan = '12' style = 'vertical-align: top; border : 1px solid #444444'>$time</td>";
      }
      else{
        $base->content .= "<tr>";
      }

      for($j = 1 ; $j < 8 ; $j ++){
        if( $timetable[$i][$j] == 1 );//테이블을 만들지 않음

        elseif ($timetable[$i][$j]){//셀 병합 길이 데이터가 존재할때

          //랜덤색상 만들기
          srand((float)microtime() * 1000000);
          $mixnum1 = '51';
          $mixnum2 = 'C1';

          switch(rand(0,3)){
            case 0:
              $mixnum1 = '4D';
              $mixnum2 = '8A';
              break;
            case 1:
              $mixnum1 = '72';
              $mixnum2 = 'C3';
              break;
            case 2:
              $mixnum1 = '6C';
              $mixnum2 = 'C1';
              break;

          }

          $mix = [dechex(rand(hexdec($mixnum1), hexdec($mixnum2))), $mixnum1, $mixnum2];

          shuffle($mix);

          $color = '#'.$mix[0] . $mix[1] . $mix[2];

          $code = explode(':', $timetable[$i][$j]);
          for($k = 0; $k < $code[1] ; $k ++) // 이 자리부터 시간표만큼 테이블을 만들지 않음
            $timetable[$i + $k][$j] = 1;
          $base->content .= "<td style = 'background : $color;' rowspan = '$code[1]'> $code[0] </td>";
        }

        else
          $base->content .= "<td></td>";

      }
      $base->content .=  "</tr>";

    }

    $base->content .= "</table>";

  }

  //교수가 수업중인 목록 출력
  else if($regist_type == 1){

    $db->query = "SELECT	Cname, Course_room, Cstime, Cftime, Cday, Cnumber
    FROM	COURSE, PROFESSOR, LOCATION, CLASSROOM, CLASSHOUR
    WHERE	Pnumber = '".$id."' AND Pnumber = Pnum AND Cnumber = Conum AND Course_room = Class_room;";

    $db->DBQ();

    $num = $db->result->num_rows;

    $base->content .= "<h1>수업 목록</h1>";
    $base->content .= "<table id = 'maintable'>";
    $base->content .= "<tr style=' border : 1px solid #808080; padding: 10px;' id=course_title>
                        <th>강의</th>
                        <th>강의실</th>
                        <th>시작 시간</th>
                        <th>종료 시간</th>
                        <th>요일</th>
                        <th>시험시간 설정</th>
                      </tr>";

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();

      $base->content .= "<tr style=' border:1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$data[2]."</td>
                          <td>".$data[3]."</td>
                          <td>".$data[4]."</td>
                          <td>
                            <form action = '../Exam Schedule/schedulei.php' method = 'post'>
                              <input type = hidden id = 'course_number' name = 'course_number'  value = '".$data[5]."'></input>
                              <input type = submit id = 'submit' value = ''></input>
                            </form>
                          </td>
                        </tr>";

    }

    $base->content .= "</table>";

    //시험 시간표 출력
    $base->content .= "<h1>시험 시간</h1><div class = 'test_timetable'>";

    $db->query = "SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
    FROM	COURSE, EXAM, PROFESSOR, LOCATION, CLASSROOM
    WHERE	Pnumber = '".$id."' AND Pnumber = Pnum AND Cnumber = Cnum AND Exam_room = Class_room;";


    $db->DBQ();

    $num = $db->result->num_rows;

    $base->content .= "<table id = 'maintable'>";

    $base->content .= "<tr style=' border : 1px solid #808080; padding: 10px;' id=course_title>
                        <th>강의번호</th>
                        <th>강의명</th>
                        <th>건물번호</th>
                        <th>강의실</th>
                        <th>시작 시간</th>
                        <th>종료 시간</th>
                        <th>요일</th>
                      </tr>";

    for($i = 0 ; $i < $num ; $i ++){

      $data = $db->result->fetch_row();
      //텍스트 시험 과목들
      $base->content .= "<tr style=' border:1px solid #808080; text-align: center; padding: 10px; ' id=course_text>
                          <td>".$data[0]."</td>
                          <td>".$data[1]."</td>
                          <td>".$data[2]."</td>
                          <td>".explode(" ", $data[3])[1]."</td>
                          <td>".$data[4]."</td>
                          <td>".$data[5]."</td>
                          <td>".$data[6]."</td>
                        </tr>";

        $Stime = explode(':', $data[4]);
        $Etime = explode(':', $data[5]);

        $Stime[0] = intval($Stime[0]);
        $Stime[1] = intval($Stime[1]);
        $Etime[0] = intval($Etime[0]);
        $Etime[1] = intval($Etime[1]);

        //시작시간을 8시로해서 5분단위로 쪼갠 index
        $j = intval(($Stime[0] * 60 + $Stime[1] - 480)/5);
        $timetable[$j][$day[$data[6]]] = (string)$data[1] ."<br>".(string)$data[2] ."<br>". (string)$data[3] ."<br>" . ":" . + (string)(intval(($Etime[0] * 60 + $Etime[1] - 480)/5) - $j);

    }

    $base->content .= "</table><br>";

    $base->content .= "<table id = 'maintable' width='100%' cellpadding='5' cellspacing='2' align='center' style='table-layout:fixed; word-break:break-all;'>
                        <tr>
                          <td width = '6%''></td>
                          <td>일</td>
                          <td>월</td>
                          <td>화</td>
                          <td>수</td>
                          <td>목</td>
                          <td>금</td>
                          <td>토</td>
                        </tr>";


    //그림 시험 과목출력
    for($i = 0 ; $i < 180 ; $i ++){


      if($i % 12 == 0){
        $base->content .= "<tr style = ' border-top : 1px solid #444444;'>";
        $time = (int)$i*5 / 60 + 8;

        $base->content .= "<td rowspan = '12' style = 'vertical-align: top; border : 1px solid #444444'>$time</td>";
      }
      else{
        $base->content .= "<tr>";
      }

      for($j = 1 ; $j < 8 ; $j ++){
        if( $timetable[$i][$j] == 1 );//테이블을 만들지 않음

        elseif ($timetable[$i][$j]){//셀 병합 길이 데이터가 존재할때

          //랜덤색상 만들기
          srand((float)microtime() * 1000000);
          $mixnum1 = '51';
          $mixnum2 = 'C1';

          switch(rand(0,3)){
            case 0:
              $mixnum1 = '4D';
              $mixnum2 = '8A';
              break;
            case 1:
              $mixnum1 = '72';
              $mixnum2 = 'C3';
              break;
            case 2:
              $mixnum1 = '6C';
              $mixnum2 = 'C1';
              break;

          }

          $mix = [dechex(rand(hexdec($mixnum1), hexdec($mixnum2))), $mixnum1, $mixnum2];

          shuffle($mix);

          $color = '#'.$mix[0] . $mix[1] . $mix[2];

          $code = explode(':', $timetable[$i][$j]);
          for($k = 0; $k < $code[1] ; $k ++) // 이 자리부터 시간표만큼 테이블을 만들지 않음
            $timetable[$i + $k][$j] = 1;
          $base->content .= "<td style = 'background : $color;' rowspan = '$code[1]'> $code[0] </td>";
        }

        else
          $base->content .= "<td></td>";

      }
      $base->content .=  "</tr>";

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
