<?php
// 세션을 시작합니다.
// 로그인용
session_start();
// class를 이용한 객체 지향 방식
class Layout
{
   private $title="경북대학교 시험관리 시스템"; // 웹 페이지 제목
   public $link; // CSS 링크 태그
   public $style; // 스타일 적용
   public $content; // 메인 컨텐츠
   private $login; // 로그인이나 로그아웃을 출력
   private $mypage; //마이페이지용 변수

   // 레이아웃을 출력
   public function LayoutMain()
   {
      echo "<!DOCTYPE html>\n<html lang='ko'>";
      echo "<head>\n<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Do+Hyeon' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Poor+Story' rel='stylesheet'> <link href='https://fonts.googleapis.com/css?family=Sunflower:300' rel='stylesheet'>\n<meta charset='utf-8'/>";
      echo "<title>".$this->title."</title>";
      echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'>";
      echo $this->LayoutStyle(); // 스타일을 레이아웃에 추가.
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

   // 헤더 부분 추가
   public function LayoutHeader()
   {
      $this->LayoutLogin();
      $this->LayoutMypage();
      echo
      "<nav id='topbar'>
         <ul>
            <li>".$this->login."</li>
            <li>".$this->mypage."</li>
         </ul>
      </nav>
      <div id='logo'><a href = '/Course List/main_view.php'><img src='../logo.jpg' alt='경북대학교 시험관리 시스템' title='logo' style='width: 500px; margin-bottom: 20px;' /></a></div>";
         $this->LayoutMenu();
   }
   public function LayoutMenu() // <li> 을 이용해서 메뉴 부분을 호출
   {
     /*
      echo "<nav id='menubar'>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Outer'>아우터</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Top'>상의</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Pants'>바지</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Skirt'>스커트</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Shoes'>신발</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=Accessory'>악세사리</a></li>";
      echo "<li class='category-list'><a class='category-link' href='./cate.php?cate_id=etc'>잡화</a></li>";
      echo "</nav>";
      */
   }

   // 로그인을 출력할 지 로그아웃을 출력할 지 결정
   public  function LayoutLogin()
   {
      $this->login="<a href='/Login/logout.php'>로그아웃</a>";
   }

   //regist_type에 따라 마이페이지 출력
   public function LayoutMypage(){
      if($_SESSION['id']!="")
      {
        if(strcmp($_SESSION['regist_type'],'customer')==0){
          $this->mypage="<a href='./messageview.php'>메세지확인</a><a href='./message.php'>메세지전송</a><a href='./customer_ordered.php'>주문완료내역</a><a href='./customer.php'>피드백 진행 상품</a>";
        }
        else if(strcmp($_SESSION['regist_type'],'designer')==0){
          $this->mypage="<a href='./messageview.php'>메세지확인</a><a href='./message.php'>메세지전송</a><a href='./designer_list.php'>내 상품 목록</a><a href='./designer.php'>상품등록</a>";
        }
        else if(strcmp($_SESSION['regist_type'],'admin')==0){
          $this->mypage="<a href='./".$_SESSION['regist_type'].".php'>마이페이지</a>";
        }
        else {
          echo "Error!";
        }
      }
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
