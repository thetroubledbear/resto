<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}
if($_SESSION['isadmin']=="yes"){
	header("Location: dashboard.php");
}
include("dbconnect.php");
$query = "SELECT * FROM food_catalog";

$result = mysqli_query($conn, $query);


// Αποτελέσματα ανά δεκάδα 
if(isset($_POST['fiveresults'])){
	$query = "SELECT * FROM food_catalog LIMIT 5";	
	$result = mysqli_query($conn, $query);
}
// Αποτελέσματα ανά εικοσάδα
if(isset($_POST['tenresults'])){
	$query = "SELECT * FROM food_catalog LIMIT 10";	
	$result = mysqli_query($conn, $query);
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Κατάλογος | Food Catalog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
</head>
<body>
<div class="uk-section-muted">
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
                <a href="dashboard.php" class="uk-align-responsive uk-button uk-button-primary">ΑΡΧΙΚΗ</a> 
                <a href="orders-user.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="catalog-user.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a> 
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> <!--Μπάρα πλοήγησης-->

<!-- Πίνακας -->
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto">
        <div class="uk-margin">
    		<form action="search-foodcatalog.php" method="GET">
        	<div class="uk-align-right">
                <button class="uk-button uk-button-primary">ΑΝΑΖΗΤΗΣΗ</button>
            </div> 
        	<div class="uk-inline uk-align-right">
                <span class="uk-form-icon" uk-icon="icon: search"></span>
                <input class="uk-input" type="text" name="q" placeholder="Search"> 
            </div>
    		</form> <!-- η φόρμα είναι ανάποδη διότι δεν μου έκαναν σωστά align --> 
		</div>
        <div>	
        <form action="catalog.php" method="post">
			<span>Αποτελέσματα ανά...</span><br>
			<button class="uk-button uk-button-text" name="fiveresults">5</button>
			<span>|</span>
			<button class="uk-button uk-button-text" name="tenresults">10</button>
			<span>|</span>
			<button class="uk-button uk-button-text">ΕΜΦΑΝΙΣΗ ΟΛΩΝ</button>
		</form>
        </div>
		<?php 
        	if (mysqli_num_rows($result)){
                echo "<table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
                <caption>Κατάλογος</caption>
                <thead>
                    <tr>
                        <th>ΚΩΔΙΚΟΣ</th>
                        <th>ΤΙΤΛΟΣ</th>
                        <th>ΥΛΙΚΑ</th>
                        <th>ΤΙΜΗ</th>  
                    </tr>
                </thead>";
        
            while ($row = mysqli_fetch_array($result)){
                echo "<tr>
                        <td>{$row['id']}</td>    
                        <td>{$row['food_title']}</td>    
                        <td>{$row['ingredients']}</td>    
                        <td>{$row['price']}</td>";
                    }
                    echo "</table>";
            	
            } else {
           	 echo("Δεν εκτελέστηκε το query");
            }
           
            mysqli_close($conn);
        ?>		
        
           
    </div>
</div> 


<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>