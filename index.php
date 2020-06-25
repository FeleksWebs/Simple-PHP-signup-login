<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <div>
      <form action="signUp/signUpSettings.php" method="POST">
        <input type="text" name="UserId" placeholder="Username" />
        <input type="text" name="email" placeholder="E-mail" />
        <input type="password" name="Pwd" placeholder="Password" />
        <input
          type="password"
          name="Pwd-repeat"
          placeholder="Repeat Password"
        />
        <button type="submit" name="signup-submit">Sign up</button>
      </form>



      <form action="login/login.php" method="POST">
      <input type="text" name="LoginMail" placeholder="Email">
      <input type="password" name="LoginPass" placeholder="Password">
      <button type="submit" name="login-submit">Login</button>
      </form>
    </div>
  </body>
</html>
