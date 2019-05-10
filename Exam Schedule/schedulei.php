<?php

require_once '../layout.inc';

$base = new Layout;
$base->link = '../style.css';

if(isset($_POST['course_name'])){
  $Cname = $_POST['course_name'];
}
else {
  echo "ERROR";
}

//회원가입 페이지 양식 출력
$base->content = "

   <form action='./registo.php' method='post'>
     <div>
        <p> 시험 일정 선택 </p>
        <table style='width: 60%;background-color: #ffffff; margin-left: auto; margin-right: auto; border-radius: 5px; height: 500px; border-top: solid; border-bottom:solid;'>
           <tr>

              <td><label for='course_name' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>강의명</label></td>

              <td class='text' style='margin-top:10px;'>
                 ".$Cname."
              </td>

           </tr>

           <tr>

              <td><label for='location_name' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>건물번호</label></td>

              <td>
                <select name='location_name'>
                  <option value='it5'>IT 융복합관</option>
                  <option value='it4'>IT 4호관</option>
                  <option value='it2'>IT 2호관</option>
                  </select>
              </td>

           </tr>

           <tr>

              <td><label for='classroom' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>강의실</label></td>

              <td>
                <select name='classroom'>
                  <option value='it5'>IT 융복합관</option>
                  <option value='it4'>IT 4호관</option>
                  <option value='it2'>IT 2호관</option>
                  </select>
              </td>

           </tr>

           <tr>

              <td><label for='day' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>요일</label></td>

              <td>
                <select name='day'>
                  <option value='mon'>월</option>
                  <option value='tue'>화</option>
                  <option value='wed'>수</option>
                  </select>
              </td>

           </tr>
           <tr>

              <td><label for='time' style='font-family: 휴먼모음T; font-size: 20px; color: #000000; float: left;'>시간</label></td>

              <td><input type='text' size='16' name='time' class='text-field'  placeholder='시간' required/></td>

           </tr>


           <tr>

              <td colspan='2'><input type='submit' value='예약하기' id='submit-btn'/></td>

           </tr>
          </table>
         </div>
   </form>

";

$base->LayoutMain();

?>
