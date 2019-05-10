<?php

//세션 값 모두 해제
unset($_SESSION['id']);

unset($_SESSION['permit']);

unset($_SESSION['regist_type']);

//세션 삭제
session_destroy();


//alert을 띄우고 메인화면으로 돌아감
echo "<script>alert('로그아웃 되었습니다.');location.replace('/')</script>";

?>
