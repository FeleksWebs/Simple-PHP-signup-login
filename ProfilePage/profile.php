<?php 
    require "../database/dbcon.php";
?>

<!DOCTYPE html>
<html>
  <body>

<?php 
    session_start();
echo "<p> Welcome ";
echo  $_SESSION['UserName'];
echo "</p>";
?>

<form action="../login/logout.php" method="POST">
  <button> LogOut </button>
</form>

  </body>
</html>