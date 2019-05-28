<?php

require_once '../Database/db.php';
$base = new Layout;
$base->link = './timetable.css';

$db = new DBC;
$db->DBI();
$id = $_SESSION['id'];
$Cnumber = $_POST['course_number'];
$location = $_POST['location'];
$class_room = $_POST['class_room'];
$day = $_POST['day'];
$stime = $_POST['stime'];
$ftime = $_POST['ftime'];

$db->query = "CREATE OR REPLACE VIEW NOT_EXIST_EXAM AS 
    SELECT Cnumber AS VCnumber 
    FROM COURSE 
    WHERE Cnumber NOT IN ( SELECT DISTINCT Cnum FROM EXAM )";
$db->DBQ();
$db->query = "CREATE OR REPLACE VIEW COURSE_VIEW AS 
    SELECT VCnumber, Pnum 
    FROM NOT_EXIST_EXAM, COURSE, CLASSHOUR 
    WHERE VCnumber = Cnumber AND Cnumber = Conum AND Course_room = '".$class_room."' AND Cday = '".$day."'";
$db->DBQ();
$db->query = "SELECT DISTINCT VCnumber, Pnum
    FROM COURSE_VIEW JOIN CLASSHOUR ON Vcnumber = Conum
    WHERE TIME('".$stime."') BETWEEN Cstime AND Cftime OR TIME('".$ftime."') BETWEEN Cstime AND Cftime;";
$db->DBQ();
$num = $db->result->num_rows;
$data = $db->result->fetch_row();
if ($num == 1) { // 강의가 중복되었는지 확인하는 부분
    if ($data[1] != $id) { // 자기 자신의 수업일 경우엔 그대로 진행
        $base->content .= "<form method = post name = form action = '../Message/message.php'>
            <input type = hidden id = 'sender' name = 'sender' value = '".$id."' </input>
            <input type = hidden id = 'receiver' name = 'receiver' value = '".$data[1]."' </input>
            <input type = hidden id = 'course_number' name = 'course_number' value = '".$data[0]."' </input>
            <script> 
                if (confirm('겹치는 일정이 있습니다. 메시지를 보내시겠습니까?') == true){
                    document.form.submit();
                }
                else {
                    location.replace('schedulei.php');
                }
            </script>
            </form>";
    }
}
else if ($num > 1) { // 시험 일정이 2개 이상 겹쳤을 경우에는 메시지를 보내지 않는다.
    echo "<script>alert('겹치는 일정이 2개 이상입니다.');</script>";
    echo "<script>location.replace('schedulei.php');</script>";
}

$db->query = "CREATE OR REPLACE VIEW EXAM_VIEW AS
    SELECT Enumber AS VEnumber, Pnum
    FROM EXAM, COURSE
    WHERE Cnum = Cnumber AND Exam_room = '".$class_room."' AND Eday = '".$day."'";
$db->DBQ();
$db->query = "SELECT DISTINCT VEnumber, Pnum
    FROM EXAM JOIN EXAM_VIEW ON Enumber = VEnumber
    WHERE TIME('".$stime."') BETWEEN Estime AND Eftime OR TIME('".$ftime."') BETWEEN Estime AND Eftime";
$db->DBQ();
$num = $db->result->num_rows;
$data = $db->result->fetch_row();
if ($num == 1) { // 시험 일정이 중복되었는지 확인하는 부분
    $base->content .= "<form method = post name = form action = '../Message/message.php'>
            <input type = hidden id = 'sender' name = 'sender' value = '".$id."' </input>
            <input type = hidden id = 'receiver' name = 'receiver' value = '".$data[1]."' </input>
            <input type = hidden id = 'course_number' name = 'course_number' value = '".$data[0]."' </input>
            <script> 
                if (confirm('겹치는 일정이 있습니다. 메시지를 보내시겠습니까?') == true){
                    document.form.submit();
                }
                else {
                    location.replace('schedulei.php');
                }
            </script>
            </form>";
    }
}
else if ($num > 1) { // 시험 일정이 2개 이상 겹쳤을 경우에는 메시지를 보내지 않는다.
    echo "<script>alert('겹치는 일정이 2개 이상입니다.');</script>";
    echo "<script>location.replace('schedulei.php');</script>";
}
else { // 시험 일정 등록,
    $db->query = "SELECT MAX(Enumber) FROM EXAM ";
    $db->DBQ();
    $data = $db->result->fetch_row();
    $db->query = "INSERT INTO EXAM VALUES (".$data[0]." + 1, ".$Cnumber.", '".$class_room."', '".$stime."', '".$ftime."', '".$day."')";
    $db->DBQ();
    echo "<script>alert('시험 일정이 등록되었습니다.');</script>";
    echo "<script>location.replace('../Course List/main_view.php');</script>";
}

$db->DBO();
?>
