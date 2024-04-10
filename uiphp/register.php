<?php 
include_once ('..//connection/dbConnect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="logreg-box">
        <div class="form-box login">
            <form action="" method="post">
                <h2>Sign In</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="username" required>
                    <label >Username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required>
                    <label >Password</label>
                </div>

                <div class="remember-forgot">
                    <label ><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">Sign In</button>

                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Sign up</a></p>
                </div>


            </form>


        </div>
      
        <div class="form-box register">
            <form action="" method ="post">
                <h2>Sign Up</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="text" required name="email">
                    <label >Email</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-user-plus'></i></span>
                    <input type="username" required name="usern">
                    <label >Username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="pass">
                    <label >Password</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="repassword" required name="repass">
                    <label >Retype Password</label>
                </div>
                

                <!-- <div class="remember-forgot">
                    <label ><input type="checkbox">I agree to terms & conditions </label>
                    
                </div> -->

                <!-- <button type="submit" class="btn" name="signup">Sign Up</button> -->
                <input type="submit" class="btn" name="signup" value = 'SIGN UP'>

</body>
</html>

<?php 
if ($_SERVER['REQUEST_METHOD']=='POST') {
    
    if(isset($_POST['signup'])){

        $email = $_POST['email'];
        $usern = $_POST['usern'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];
        $token = rand(999999, 111111);
        $status = 'unverified';

        try {
                
            $conn = connectDB();

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "INSERT INTO `accounts`( `name`, `email`, `password`, `reset_token`, `status`) VALUES (':usern',':email',':pass',':token',':stat')";

           $stm = $conn->prepare($sql);
           $stm->bindParam(':email', $email);
           $stm->bindParam(':usern', $usern);
           $stm->bindParam(':pass', $pass);
           $stm->bindParam(':token', $token);
           $stm->bindParam(':stat', $status);

           $stm->execute();
           
            echo "<script>alert('yawa')</script>";

        } catch  (PDOException $e) {
            echo "Error: " . $e->getMessage();                 
        }

    }

}


?>

