<?php
require_once '../layout.inc';
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

// 해당 시험일정과 겹치는 다른 시험일정이 없는지 확인한다.
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

if ($num >= 1) { // 시험일정이 겹쳤을 경우에는 요청 메시지를 보내지 않는다.
    echo "<script>alert('겹치는 시험일정이 있습니다. 다른 일정을 선택해 주십시오.');</script>";
    echo "<script>location.replace('schedulei.php');</script>";
}

// 학생의 다른 시험일정이 겹칠 경우 경고 메시지를 보낸다.
$db->query = "CREATE OR REPLACE VIEW TAKE_VIEW AS
    SELECT Snum AS VSnum
    FROM TAKE_CLASS
    WHERE Cno = ".$Cnumber."";
$db->DBQ();
$db->query = "CREATE OR REPLACE VIEW EXAM_VIEW AS
SELECT DISTINCT Enumber AS VEnumber
FROM TAKE_CLASS, TAKE_VIEW, EXAM
WHERE Snum = VSnum AND NOT Cno = ".$Cnumber." AND Cno = Cnum AND Eday = '".$day."'";
$db->DBQ();
$db->query = "SELECT DISTINCT Enumber
FROM EXAM_VIEW JOIN EXAM ON VEnumber = Enumber
WHERE TIME('".$stime."') BETWEEN Estime AND Eftime OR TIME('".$ftime."') BETWEEN Estime AND Eftime";
$db->DBQ();
$num = $db->result->num_rows;
$data = $db->result->fetch_row();
if ($num >= 1) { // 해당 수업을 듣는 학생의 다른 시험 일정이 1개 이상 존재하는 경우
    echo "<script> if (confirm('경고 : 해당 수업을 듣는 학생의 시험일정과 겹칩니다. 계속 진행하시겠습니까?') == true){
        alert('계속 진행합니다.');
    }
    else {
        alert('시험일정을 취소합니다.');
        location.replace('schedulei.php');
    }
    </script>";
}

// 해당 시험일정과 겹치는 수업이 없는지 확인한다.
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
if ($num == 1) { // 수업이 중복되었는지 확인하는 부분
    if ($data[1] != $id) { // 자기 자신의 수업일 경우엔 그대로 진행한다.
        $base->content .= "<form method = post name = form action = '../Message/message.php'>
            <input type = hidden id = 'sender' name = 'sender' value = '".$id."'> </input>
            <input type = hidden id = 'receiver' name = 'receiver' value = '".$data[1]."'> </input>
            <input type = hidden id = 'course_number' name = 'course_number' value = '".$data[0]."'> </input>
            <input type = hidden id = 'location' name = 'location' value = '".$location."'> </input>
            <input type = hidden id = 'class_room' name = 'class_room' value = '".$class_room."'> </input>
            <input type = hidden id = 'day' name = 'day' value = '".$day."'> </input>
            <input type = hidden id = 'stime' name = 'stime' value = '".$stime."'> </input>
            <input type = hidden id = 'ftime' name = 'ftime' value = '".$ftime."'> </input>
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
else if ($num > 1) { // 수업 시간이 2개 이상 겹쳤을 경우에는 메시지를 보내지 않는다.
    echo "<script>alert('겹치는 수업 일정이 2개 이상입니다.');</script>";
    echo "<script>location.replace('schedulei.php');</script>";
}

else { // 여기까지 겹치는 경우가 없을 경우 해당 시험일정을 등록한다.
    $db->query = "SELECT MAX(Enumber) FROM EXAM ";
    $db->DBQ();
    $num = $db->result->num_rows;
    $data = $db->result->fetch_row();
    if ($num >= 1) {
        $db->query = "INSERT INTO EXAM VALUES (".$data[0]." + 1, ".$Cnumber.", '".$class_room."', '".$stime."', '".$ftime."', '".$day."')";
    }
    else { // 숫자가 없을 경우
        $db->query = "INSERT INTO EXAM VALUES (1, ".$Cnumber.", '".$class_room."', '".$stime."', '".$ftime."', '".$day."')";
    }
    $db->DBQ();
    echo "<script>alert('시험 일정이 등록되었습니다.');</script>";
    echo "<script>location.replace('C:\xampp\SE_Project_team5\Course List\main_view.php');</script>";
}

  $base->LayoutMain();
  $db->DBO();

?>
