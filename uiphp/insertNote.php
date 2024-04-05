<?php 

                   
              function inserting($title,$descrip){  
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        if(empty($title)||empty($descrip)){
                            echo '<script>alert("bogo")</script>';
                        }else{   
                    try {
                        $conn = connectDB();

                        $sql = "INSERT INTO notes (n_title, n_description, n_date) VALUES (:title, :descrip, CURDATE())";
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
                    ?>

<?php 

                   
              function updating($n_title,$n_description,$n_id){  
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        if(empty($n_title)||empty($n_description)){
                            echo '<script>alert("bogo")</script>';
                        }else{   
                    try {
                        $conn = connectDB();

                        $sql = "UPDATE notes SET n_title= :ntit ,n_description= :ndesc ,n_date= CURDATE() WHERE n_id = :nid";
                        $stm = $conn->prepare($sql);
                        $stm->bindParam(':nid', $n_id);
                        $stm->bindParam(':ntit', $n_title);
                        $stm->bindParam(':ndesc', $n_description);
        
                        $stm->execute();

                        header("Location: dashboard.php");
                        
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