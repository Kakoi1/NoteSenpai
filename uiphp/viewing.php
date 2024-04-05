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
        <div class="container">
            <div class="innerCont">
            <?php
    

    try {
        $conn = connectDB();
        
        if ($conn && isset($_POST['notId'])) {
            $notId = $_POST['notId'];
            $sql = "SELECT `n_id`, `n_title`, `n_description`, `n_date` FROM `notes` WHERE  `n_id` = :nid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nid', $notId);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                // User data found, render the edit form
    ?>
                <form action="" method="post">

                    <input type="hidden" name="nid" value="<?php echo $userData['n_id']; ?>">

                    <label for="ntitle">Name:</label>
                    <input type="text" name="ntitle" id="ntitle" value="<?php echo $userData['n_title']; ?>">

                    <label for="desc">Note Description:</label>
                    <textarea name="desc" id="desc" cols="30" rows="10" value =""><?php echo $userData['n_description']; ?></textarea>

                    <h4 id="dates">Date Posted: <?php echo $userData['n_date']; ?></h4>

    
                    <div class="button-container">
                        <button type="submit" class="update-button" name = "save">Save</button>
                    </div>
                </form>
    <?php
            } else {
                echo "<p>User not found.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        if ($conn) {
            $conn = null;
        }
    }
    ?>
            </div>
        </div>
</body>
</html>
<?php 
 include_once ('insertNote.php');
 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['save'])){

            $n_id = $_POST['nid'];
            $n_title = $_POST['ntitle'];
            $n_description = $_POST['desc'];

            try {
                $conn = connectDB();
                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                updating($n_title,$n_description,$n_id);

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();                 
            }

        }

    }

?>