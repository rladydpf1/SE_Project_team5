<?php
// class를 이용한 객체 지향 방식

session_start();

class Layout
{
   private $title="경북대학교 시험관리 시스템"; // 웹 페이지 제목
   public $link; // CSS 링크 태그
   public $style; // 스타일 적용
   public $content; // 메인 컨텐츠
   public $script; //스크립트
   private $login; // 로그인이나 로그아웃을 출력
   private $message; //마이페이지용 변수


   // 레이아웃을 출력
   public function LayoutMain()
   {
      echo "<!DOCTYPE html>\n<html lang='ko'>";
      echo "<head>\n<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Do+Hyeon' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Poor+Story' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Sunflower:300' rel='stylesheet'>\n<meta charset='utf-8'/>";
      echo "<title>".$this->title."</title>";
      echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'>";
      echo $this->LayoutStyle(); // 스타일을 레이아웃에 추가.
      echo $this->LayoutScript();
      echo "</head>\n<body>\n <fieldset style='width: 73.8%; margin-left: auto; margin-right: auto; border-style: none;'><div id='container'>";
      echo   $this->LayoutHeader(); // 헤더 부분을 레이아웃에 추가
      echo   $this->LayoutContent(); // 컨텐츠 부분을 레이아웃에 추가
      echo   $this->LayoutFooter(); //하단 부분을 레이아웃에 추가
      echo "</div></fieldset></body>\n</html>";
   }
   // 스타일을 추가
   public function LayoutStyle()
   {
      echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/> ";
      echo "<style>".$this->style."</style>";
   }

   public function LayoutScript()
   {
      echo "<script>".$this->script."</script>";
   }

   // 헤더 부분 추가
   public function LayoutHeader()
   {
      $this->LayoutLogin();
      $this->LayoutMessage();
      echo
      "<nav id='topbar'>
         <ul>
            <li>".$this->login."</li>
            <li>".$this->message."</li>
         </ul>
      </nav>
      <div id='logo'><a href = '/Course List/main_view.php'><img src='../logo.jpg' alt='경북대학교 시험관리 시스템' title='logo' style='width: 500px; margin-bottom: 20px;' /></a></div>";
   }
   // 로그인을 출력할 지 로그아웃을 출력할 지 결정
   public  function LayoutLogin()
   {
      $this->login="<a href='/Login/logout.php'>로그아웃</a>";
   }

   //regist_type에 따라 마이페이지 출력
   public function LayoutMessage(){
      if($_SESSION['regist_type']==1)
        $this->message="<a href='/Message/messageview.php'>메세지확인</a>";
   }

   // 내용을 추가
   public function LayoutContent()
   {
      echo "<section><article>".$this->content."</article>";
   }

   //하단바 추가
    public function LayoutFooter()
    {
       //echo "<br/><hr style = 'border:1px solid black;'/><div class='footer-image'><img src='/images/foot_info.jpg' alt='ilsa1002입니다' title='ilsa1002' style='margin-bottom: 20px;' /></div>";
    }
}
?>
