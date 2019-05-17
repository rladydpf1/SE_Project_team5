
<?php

require_once '../layout.inc';

$base = new Layout;
$base->link = '../style.css';

$id = $_SESSION['id'];

$base->content = "<form action='send.php' method='post'>
<fieldset style='width: 400px; margin-left: auto; margin-right: auto; border: none;'>
<p> 쪽지 </p>
<table style='margin-bottom: -15px;'>
  <tr>
    <td style='text-align:left;'><label for='CustomerID' id='msg-table-text'> 받는 사람 </td>
    <td><input type='text' id='Receiver' name='Receiver'
    maxlength='13' size='30'  value=''/></td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='Title' id='msg-table-text'>제목</label></td>
    <td><input type='text' id='Title' name='Title'maxlength='40' size='30'/></td>
  </tr>
  <tr>
    <td style='text-align:left;'><label for='body' id='msg-table-text'>내용</label></td>
  </tr>
</table>

<p style='text-align:left;'><textarea name='body' rows='10' cols='80' type='text'></textarea></p>
  <p><input type='submit' value='전송' id='submit-btn'/></p>
</fieldset>
</form>";

$base->LayoutMain();
?>
