<?php 

if(isset($_POST['signup-submit'])){
    require "../database/dbcon.php";
    // Get POST requests
    $Username=$_POST['UserId'];
    $Email=$_POST['email'];
    $Password=$_POST['Pwd'];
    $RePassword=$_POST['Pwd-repeat'];



    // ERROR checking
    if(empty($Username) || empty($Email) || empty($Password) || empty($RePassword) ){
        header("Location: ../index.php?error=emptyfields&UserId=".$Username."&email=".$Email);
        exit();
    }
    elseif(!filter_var($Email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$Username)){
        header("Location: ../index.php?error=InvalidEmail");
        exit();
    }
    elseif(!filter_var($Email,FILTER_VALIDATE_EMAIL)){
        header("Location: ../index.php?error=InvalidEmail&UserId=".$Username);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$Username)){
        header("Location: ../index.php?error=InvalidUserID&email=".$Email);
        exit();
    }
    elseif($Password !== $RePassword){
        header("Location: ../index.php?error=PasswordCheck&UserId=".$Username."&email=".$Email);
        exit();
    }
    // ***************************************
    
    else{
        //SQL connection checks
        $sql = "SELECT UserID FROM users WHERE UserID=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=SQL_Find_User_ERROR");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$Username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if($resultCheck > 0){
                header("Location: ../index.php?error=UserTaken&email=".$Email);
            }else{
                $sql = "INSERT INTO users (UserName,UserEmail, UserPwd) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../index.php?error=SQLErrorInsert");
                    exit();
                }else{
                    $hashedPwd = password_hash($Password,PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt,"sss",$Username,$Email,$hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../ProfilePage/profile.php");
                    exit();
                }
            }
        }
    }
    //close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}else{
    header("Location: ../index.php");
    exit();
}
