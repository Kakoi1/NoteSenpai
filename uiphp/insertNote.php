<?php 
    // session_start();
                   
              function inserting($title,$descrip){  
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        if(empty($title)||empty($descrip)){
                            echo '<script>alert("bogo");window.history.back();</script>';
                        }else{   
                    try {
                        $conn = connectDB();

                        $sql = "INSERT INTO notes (n_title, n_description, n_date, star, archive) VALUES (:title, :descrip,CURDATE(),0,0)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                        $stmt->bindParam(':descrip', $descrip, PDO::PARAM_STR);
                        $stmt->execute();

                        header("Location: ".$_SERVER['dashboard.php']);
                        echo "<script>window.history.back();</script>";
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    } finally {
                        // Always close the connection
                        if ($conn) {
                            $conn = null;
                        }
                    }
                        }
                    }
                }

                function insertingUser( $email ,$usern, $hashedPassword, $token,  $status){  
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        // if(empty($title)||empty($descrip)){
                        //     echo '<script>alert("bogo");window.history.back();</script>';
                        // }else{   
                    try {
                        $conn = connectDB();

                                
                        $sql = "INSERT INTO `accounts`(`email`, `name`, `password`, `reset_token`, `status`) VALUES (:email, :usern, :pass, :token, :stat)";

                        $stm = $conn->prepare($sql);
                        $stm->bindParam(':email', $email);
                        $stm->bindParam(':usern', $usern);
                        $stm->bindParam(':pass', $hashedPassword);
                        $stm->bindParam(':token', $token);
                        $stm->bindParam(':stat', $status);

                        $stm->execute();

                        if ($stm->rowCount() > 0) {

                            echo "<script>alert('Verification sent to your eamil');
                            document.location.href = 'mailer.php';
                            </script>";
                            $_SESSION['email'] = $email;
                            senEmail($token, $email);
            
                           
            
                        }


                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    } finally {
                        // Always close the connection
                        if ($conn) {
                            $conn = null;
                        }
                    }
                        }
                    }
                // }
                    ?>

<?php 

                   
              function updating($n_title,$n_description,$n_id,$star,$arc,$notDate){  
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        if(empty($n_id)){
                            // echo '<script>alert("update bogo");window.history.back();</script>';
                        }else if(empty($n_title)||empty($n_description)){
                            echo '<script>alert("yawa bogo");window.history.back();</script>';
                        }else{   
                    try {
                        $conn = connectDB();

                        $sql = "UPDATE notes SET n_title= :ntit ,n_description= :ndesc ,n_date= :dates, star = :str, archive = :arc WHERE n_id = :nid";
                        $stm = $conn->prepare($sql);
                        $stm->bindParam(':nid', $n_id);
                        $stm->bindParam(':arc', $arc);
                        $stm->bindParam(':dates', $notDate);
                        $stm->bindParam(':str', $star);
                        $stm->bindParam(':ntit', $n_title);
                        $stm->bindParam(':ndesc', $n_description);
        
                        $stm->execute();

                        
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    } finally {
                        // Always close the connection
                        if ($conn) {
                            $conn = null;
                        }
                    }
                        }
                    }
                }
                    ?>


                    <?php 
                      function deleting($n_id){  
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
                            if(empty($n_id)){
                                echo '<script>alert("bogo")</script>';
                            }else{   
                        try {
                            $conn = connectDB();
    
                            $sql = "DELETE FROM `notes` WHERE `n_id` = :dId";
                            $stam = $conn->prepare($sql);
                            $stam->bindParam(':dId', $n_id);
                            $stam->execute();
            
                            header("Location: ".$_SERVER['dashboard.php']);
                            echo "<script>window.history.back();</script>";
                            
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } finally {
                            // Always close the connection
                            if ($conn) {
                                $conn = null;
                            }
                        }
                            }
                        }
                    }
                    
                    
                    ?>
                    <?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require '..//phpmailer/src/Exception.php';
require '..//phpmailer/src/PHPMailer.php';
require '..//phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
function senEmail($code, $resEmail){
// if (isset($_POST["send"])) {
  // $code = rand(999999, 111111);
  $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'lopezrolandshane@gmail.com';   //SMTP write your email
    $mail->Password   = 'gssjmdazxyyqioqq';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom( 'lopezrolandshane@gmail.com','Roland'); // Sender Email and name
    $mail->addAddress("$resEmail");     //Add a recipient email  
    $mail->addReplyTo('lopezrolandshane@gmail.com','Roland'); // reply to sender email

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = 'VERIFICATION CODE';   // email subject headings
    $mail->Body    =  "THIS IS THE CODE $code"; //email message

    // Success sent message alert
    $mail->send();
    // echo
    // " 
    // <script> 
    //  alert('Message was sent successfully!');
    //  document.location.href = 'index.php';
    // </script>
    // ";
  // }
}

?>

<?php 
function requestCode($tokens,$userEmail,$actions){

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = connectDB();

        $spl = "UPDATE `accounts` SET `reset_token`= :toks WHERE email = :imil";
        $stm = $conn->prepare($spl);
        $stm->bindParam(':toks', $tokens);
        $stm->bindParam(':imil', $userEmail);
        $stm->execute();

        if ($stm->rowCount() > 0) {

        senEmail($tokens, $userEmail);
        if($actions == "forgotPass"){
        echo "<script>alert('Verification Code is Sent To your Email');
                document.location.href = 'mailer.php';
            </script>";
        }else if($actions == "userEdit"){
            echo "<script>alert('Verification Code is Sent To your Email');
            document.location.href = 'mailer.php';
            </script>";
        }
        else{
            echo "<script>alert('Account " . $actions. " is not yet Verified a Verification code is sent to your Email');
            document.location.href = 'mailer.php';
        </script>";
            }

    }
       

}
}
?>