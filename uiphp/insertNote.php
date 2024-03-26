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