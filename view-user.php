<?php 
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}
if($_SESSION['isadmin']=="yes"){
	header("Location: dashboard.php");
}

include("dbconnect.php");

$order_number = $_GET['order_number'];

$query = "SELECT order_id.*, food_catalog.* FROM order_id, food_catalog WHERE order_id.order_id = '$order_number' AND order_id.food_choice = food_catalog.id";

$result = mysqli_query($conn, $query);


?> 

<!DOCTYPE HTML>
<html>
<head>
    <title>Λεπτομέρειες Παραγγελίας | Resto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
</head>
<body> 
<div class="uk-section-muted"> <!--Μπάρα πλοήγησης-->
    <nav class="uk-navbar-center uk-navbar-container uk-margin-auto">
        <div class="uk-navbar-left uk-margin-large-left">
            <a class="uk-navbar-toggle" uk-toggle="target: #offcanvas-usage">
                <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Μενού</span>
            </a>
        </div>


        <a class="uk-navbar-item uk-logo" href=dashboard.php>Resto Management</a>
        <div class="uk-navbar-center-right"><div>

        <a href="#offcanvas-usage" uk-toggle></a>

        <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div  class="uk-position-center">
                <a href="dashboard-user.php" class="uk-align-responsive uk-button uk-button-primary">ΑΡΧΙΚΗ</a> 
                <a href="orders-user.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="catalog-user.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a> 
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> 

<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
    <div> 
    	
        <ul class="uk-iconnav">
            <li><a href="orders-user.php" uk-icon="icon: arrow-left; ratio: 1.5" uk-toggle></a></li>
        </ul>

    </div>
        <?php
            if (mysqli_num_rows($result)){
                echo " <table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
                <caption>Λεπτομέρειες Παραγγελίας</caption>
                <thead>
                <tr>
                <th>ID</th>
                <th>Αριθμος Παραγγελιας</th>
                <th>Αριθμος καταλογου</th>
                <th>Τιτλος φαγητου</th>
                <th>Τιμη</th>            
                </tr>
                </thead>";
                
                while ($row = mysqli_fetch_array($result)){
                    $sum += $row['price'];
                    echo "<tr>
                    <td>{$row['id2']}</td>
                    <td>{$row['order_id']}</td>
                    <td>{$row['food_choice']}</td>
                    <td>{$row['food_title']}</td>
                    <td>{$row['price']}</td>
                    ";
                    
                }
                
                
                echo '</table>';
            } else {
                echo("Η παραγγελία είναι κενή! ");
            }
            
            
            ?>
        <div class="uk-child-width-1-1@s uk-grid-match uk-text-center" uk-grid>
                <div class="uk-card uk-card-primary uk-card-hover uk-card-body ">
                    <h3 class="uk-card-title">Τελική Τιμή</h3>
                    <h3><?php echo $sum ." €" ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
