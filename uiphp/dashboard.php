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
<link rel="stylesheet" href="..//css/dashboard.css">
<body>
    <div class="container">

        <div class="inner">
            <div class="navbar">
                <h1>Note App</h1>
                <div class="imag">
                    <div class="pic"><img src="..//icons/user.jpg" alt=""></div>
                    <div class="nams">Name here</div>
                </div>
                    <div class="navButon" >
                        <div id="addNote"><p>Add Notes</p></div>                        
                    </div>
            </div>

            <div class="boardPag">
            <div class="board">

    <?php
        $limito = 3; 
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $starto = ($page - 1) * $limito;
        // $limito = 2; 
        // $starto = 0;
    
        try {
            $conn = connectDB();

            if ($conn) {
                $sql = "SELECT * FROM `notes` LIMIT :starto, :limito";
                $stmt = $conn->prepare($sql);                
                $stmt->bindParam(':starto', $starto, PDO::PARAM_INT);
                $stmt->bindParam(':limito', $limito, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
                foreach ($result as $row) {

                    echo "<div class = 'noteCont' onclick=\"populateNote(" . $row["n_id"] . ", '" . $row["n_title"] . "', '" . $row["n_description"] . "', '" . $row["n_date"] . "')\">

                            <h2> Note #{$row['n_id']}</h2>
                            <h1>{$row['n_title']}</h1>
                            <h3>{$row['n_date']}</h3>
                            <div class = 'actions'>     

                                <button id = 'views' onclick='openNote()'>view</button>

                                <form action='viewing.php' method ='post'>
                               <button id = 'edit' onclick=''>edit</button>
                               <input type='hidden' name='notId' value = ' {$row['n_id']}'>
                               </form>

                              
                               <button id = 'del' name = 'del' onclick=\"idTodele(" . $row["n_id"] . ", '" . $row["n_title"] . "')\">delete</button>
                               

                            </div>
                        </div>";

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

            <div class="overlay1" id="overNote">
                <div class="noteForm">
                    <div class="noteCont1">
                    <form action="" method="post">
                        <label for="title">Note Title:</label>
                        <br>
                        <input type="text" name="title" id="title">
                        <br>
                        <label for="descrip">Note Description</label>
                        <br>
                        <textarea name="descrip" id="descrip" cols="100" rows="4" ></textarea>
                                                
                        <div class="submitBut">


                        <input id="add" name="add" class="add" type="submit" value="add">
                        <input id="cancel" name="cancel" class="cancel" type="button" value="cancel"> 

                        </div>

                    </form>
                    </div>

                

                </div>
            </div>

            <div class="overlay" id="viewNote">
                <div class="viewForm">

                <h3 id = "nid"></h3>
                  <h2  id = "ntitle"></h2>
                  <textarea name="ndesc" id="ndesc" cols="30" rows="10"></textarea>
                    <h4  id = "ndate"></h4>
                  <button id="sira" onclick="closeNote()">close</button>

                </div>
            </div>

            <?php 

            $conn = connectDB();
                $sqli = 'SELECT * FROM `notes`';
                $stmt = $conn->prepare($sqli);
                $stmt->execute();
                $num_rows = 0;


                while ($stmt->fetch(PDO::FETCH_ASSOC)) {
                    $num_rows++;
                }

                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                $totalPage = ceil($num_rows/$limito);

                echo "<div class = 'paginat'>";
                if ($page > 1) {
                    echo "<a href='?page=1'>First</a> ";
                    echo "<a href='?page=".($page - 1)."'>Previous</a> ";
                }
                
                for ($i = 1; $i <= $totalPage; $i++) {
              
                    echo "<a class = 'withNum' href='?page=$i' id='page_$i'>$i</a> ";
                }
                
                if ($page < $totalPage) {
                    echo "<a href='?page=".($page + 1)."'>Next</a> ";
                    echo "<a href='?page=$totalPage'>Last</a> ";
                }
                echo "</div>";
            
            ?>
            </div>

            <div class="overlayNote" id ='overlayNote'>
            <div class = 'confirmBox' id = 'confirmBox'>
                <div class = 'confirmCont'>
                <h3 id ="nameDel"></h3>
                <div class = 'delBut'>
                    <form action='' method ='post'>
                        <button id = 'del' name = 'del'>delete</button>
                        <input type='hidden' id = 'noteId' name='noteId'>
                    </form>
                    
                    <button id="cance" name="cance" onclick="cancelDel()">cancel</button>
                </div>
            </div>
            </div>
            </div>

        </div>

    </div>

<script src="..//script/jsCode.js"></script>

<script>

    var currentPage = <?php echo $page; ?>;
    

    var selectedPageLink = document.getElementById('page_' + currentPage);

    selectedPageLink.style.color = 'white';
    selectedPageLink.style.backgroundColor = 'violet';
    selectedPageLink.style.fontWeight = 'bold';

</script>
     
</body>
</html>
<!-- INSERT HERE -->
    <?php 
                   
        include_once ('insertNote.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(isset($_POST['add'])){

                 $title = $_POST['title'];
                $descrip = $_POST['descrip'];

            try {
                $conn = connectDB();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                inserting($title,$descrip);

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();                 
            }

            }  
        }                    
    ?>
    <!-- DELETE HEARE -->
    <?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include_once ('insertNote.php');

        if(isset($_POST['del'])){

            $delId = $_POST['noteId'];

            try {
                
                $conn = connectDB();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                deleting($delId);  
            

            } catch  (PDOException $e) {
                echo "Error: " . $e->getMessage();                 
            }
            


        }

    }
    
    ?>
