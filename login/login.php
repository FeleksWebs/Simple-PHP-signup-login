<?php

if(isset($_POST['login-submit'])){
    //Get info from POST
    require "../database/dbcon.php";
    $emailLogin =$_POST['LoginMail'];
    $PassLogin =$_POST['LoginPass'];
    if(empty($emailLogin) || empty($PassLogin)){
        header("Location: ../index.php?Error=emptyfield");
        exit();
    }else{
        $sql ="SELECT * FROM users WHERE UserID=? OR USerEmail=?;";
        $stmt = mysqli_stmt_init($conn);

        //If SQL not working
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?Error=SQLFindError");
            exit();
        }else{
            // Bind and check parameters
            mysqli_stmt_bind_param($stmt,"ss",$emailLogin,$emailLogin);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //check SQL fetch
            if($row = mysqli_fetch_assoc($result)){
                $passCheck = password_verify($PassLogin,$row['UserPwd']);
                if($passCheck==false){
                    header("Location: ../index.php?Error=WrongPass");
                    exit();
                }else if($passCheck==true){
                    //Successful Connection
                    session_start();
                    $_SESSION['UsersId'] = $row['UserID'];
                    $_SESSION['UserName'] = $row['UserName'];
                    header("Location: ../ProfilePage/profile.php");
                    exit();
                }else{
                    header("Location: ../index.php?Error=SQLInputError");
                    exit();
                }

            }else{
                header("Location: ../index.php?Error=NoUser");
                exit();
            }
        }
    }

}else{
    header("Location: ../index.php?Error=PostNotWorking");
    exit();
}