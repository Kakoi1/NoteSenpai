

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="..//css/style.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="background"></div>
    <div class="container">
    <div class="content">
    <div class="logregbox">
    <div class="form-box login">
            <form action="" method="post">
                <h2>Verification</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bx-message-rounded-dots'></i></span>
                    <input type="text" required name='code'>
                    <label >Verification Code</label>
                </div>


                <div class="remember-forgot">
                    <a href="logout.php">Log in Form</a>
                </div>

                <button type="submit" class="btn" name="sent">Submit</button>

                <!-- <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Sign up</a></p>
                </div> -->


            </form>
                </div>
        </div>
    </div>
     
    </div>
</body>
</html>
<?php include_once('..//connection/dbConnect.php');
// include_once('insertNote.php');
  session_start();
?>
<?php 

// session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
  if (isset($_POST['sent'])) {

    $userEmail = $_SESSION['email'];

    $codes = $_POST['code'];
    $forgot =  $_SESSION['forgot'];
    $usr = $_SESSION['use'];
    $mil = $_SESSION['imil'];
    $pas = $_SESSION['pass'];
    $action = $_SESSION['useredit'];

    try {
      $conn = connectDB();

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT * FROM `accounts` WHERE  email = :mail AND `reset_token` = :code";
      $stmt = $conn->prepare($sql);  
      $stmt->bindParam(':mail', $userEmail);
       $stmt->bindParam(':code', $codes);
       $stmt->execute();
       
       if ($stmt->rowCount() > 0) {

        $sqli = "UPDATE `accounts` SET `reset_token`= 0,`status`='verified' WHERE `reset_token` = :cods ";

        $stmt = $conn->prepare($sqli);
        $stmt->bindParam(':cods', $codes);
      
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($forgot == "forgotPass"){

            echo "<script>alert('Code Verified');
            document.location.href = 'passwordForm.php';
            </script>";
            $_SESSION['forgot'] = "";
            
        }elseif($action == "userEdit"){

            $sqli = "UPDATE `accounts` SET `name`= :user,`password`= :pass,`reset_token`= 0 WHERE `email` = :mail";
            $stm = $conn->prepare($sqli);  
            $stm->bindParam(':mail', $mil);
            $stm->bindParam(':user', $usr);
            $stm->bindParam(':pass', $pas);
           
            $stm->execute();
            if ($stm->rowCount() > 0) {
                echo "<script>alert('Edit Success');
                    document.location.href = 'logout.php';
                    </script>";
            }

        } else{

        echo "<script>alert('Verification Complete');
        document.location.href = 'logout.php';
        </script>";
        }
       }else{
        echo "<script>alert('Wrong Verification code');window.history.back();</script>";
       }
       
    } catch  (PDOException $e) {
      echo "Error: " . $e->getMessage();                 
    }
    }
} 
?>