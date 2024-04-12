<?php 
include_once ('..//connection/dbConnect.php');
session_start();
include_once('insertNote.php');
$message = "";
?>

<?php 
    $conn = connectDB();
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['sav'])){

            $token = rand(999999, 111111);
            $imil = $_POST['imil'];
            $pass = $_POST['passw'];
            $repass = $_POST['repass'];
            $use = $_POST['username'];
            $salt = "codeflix";
            $hashedPassword = sha1($pass.$salt);

            if($pass !== $repass){
                echo '<script>alert("Password Dont Match");window.history.back();</script>';
            }
            else if (strlen($pass) < 8||strlen($repass) < 8) {
                echo '<script>alert("Password must have at least 8 characters.");window.history.back();</script>';
            }
            else{
                $_SESSION['use']=$use;
                $_SESSION['imil']=$imil;
                $_SESSION['pass']=$hashedPassword;
                $_SESSION['useredit']="userEdit";

                // $spl = "UPDATE `accounts` SET `reset_token`= :toks WHERE email = :imil";
                // $stmt = $conn->prepare($spl);
                // $stmt->bindParam(':toks', $token);
                // $stmt->bindParam(':imil', $imil);
                // $stmt->execute();
                $actions = "userEdit";

                requestCode($token,$imil,$actions);

            //     if ($stmt->rowCount() > 0) {
            //         senEmail($token, $imil);
            //         echo "<script>alert('Edit Success');
            //         document.location.href = 'mailer.php';
            //         </script>";

            // }
        }
        }
    }  

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..//css/dashboard.css">
</head>
<body>
        <div class="container">
            <div class="innerView">
                <div class = 'viewConts'>
            <?php
    
    
    try {
        $conn = connectDB();
        $emails = $_SESSION['email'];

        if ($emails != false) {
            
            $sql = "SELECT `id`, `name`, `email`, `password` FROM `accounts` WHERE `email` = :imil";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':imil', $emails);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                // User data found, render the edit form
    ?>
                <form action="" method="post">

                    <input type="hidden" value="<?php echo $userData['email']?>" name = "imil" required>
                    <input type="hidden" value="<?php echo $userData['id']?>" name = "id" required> 
                    <input type="text" value="<?php echo $userData['name']?>" name = "username" required>
                    <input type="password" name = "passw" required>
                    <input type="password" name = "repass" required>

                    <br>
                    <div class="button-container">
                        <button type="submit" class="update-button" name = "sav">Save</button>
                        <button class="cancel-button" name = "back">Cancel</button>
                    </div>
                </form>

                </div>
    <?php
            } else {
                echo "<p>User not found.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();

    }
    ?>
            </div>
        </div>
</body>
</html>

