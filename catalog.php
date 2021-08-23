<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}

include("dbconnect.php");
$query = "SELECT * FROM food_catalog";

$result = mysqli_query($conn, $query);

//προσθήκη φαγητού
if(isset($_POST['submit'])){
    $foodtitle = $_POST['foodtitle'];
    $ing = $_POST['ingredients'];
    $price = $_POST['price'];

    $insert = "INSERT INTO food_catalog (food_title, ingredients, price) VALUES('$foodtitle', '$ing', '$price')";

    $result = mysqli_query($conn, $insert); 
    $add = true;
    header("location: catalog.php");
}

//διαγραφή 
if(isset($_POST['delete'])){
	$idchoice = $_POST['idchoice']; 
	$delquery = "DELETE FROM food_catalog WHERE id = '$idchoice'";
	$delresult = mysqli_query($conn, $delquery);
	$deletion = true;
	header("location: catalog.php");
}

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
if ($_SESSION['isadmin'] == "yes") {
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
                <a href="orders.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="catalog.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a> 
                <a href="user-management.php" class="uk-align-responsive uk-button uk-button-primary">ΔΙΑΧΕΙΡΗΣΗ ΧΡΗΣΤΩΝ</a>
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> <!--Μπάρα πλοήγησης-->

<!-- Πίνακας -->
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto">
    	<div> 
			<ul class="uk-iconnav">
			    <li><a href="#modal-center1" uk-icon="icon: plus; ratio: 1.3" uk-toggle></a></li>
                <li><a href="#modal2" uk-icon="icon: trash; ratio: 1.3" uk-toggle></a></li>
			</ul>
		</div>
        <!-- Διαλογος προσθεσης φαγητού --> 
        <div id="modal-center1" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		
        		<form action="catalog.php" method="POST" class="uk-form-horizontal uk-margin-large">
				
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Τίτλος φαγητού</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="foodtitle" type="text">
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Υλικά</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="ingredients" type="text">
				        </div>
				    </div>
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Τιμή</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="price" type="number">
				        </div>
                        <button class="uk-button uk-button-primary uk-align-right uk-margin-medium-top" name="submit">ΠΡΟΣΘΗΚΗ</button>
                    </div> 
				
				</form>
    		</div>
		</div>
        <!-- Διαλογος αφαιρεσης φαγητού -->
    	<div id="modal2" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">
        			<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επιλογή Kωδικού Φαγητού</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="idchoice" type="number">
				        </div>
				    </div>
				    <div class="uk-align-right">
                        <button class="uk-button uk-button-primary" name="delete">ΔΙΑΓΡΑΦΗ</button>
                    </div> 
                </form>   
        	</div>	
    	</div>
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
			if ($add == true){
			 	echo "Προστέθηκε στον κατάλογο το φαγητό";	
			} else if($deletion == true){
			 	echo "Η παραγγελία έχει διαγραφεί επιτυχώς";
            }
		?>
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
                        <th>ΕΠΕΞΕΡΓΑΣΙΑ</th>  
                    </tr>
                </thead>";
        
            while ($row = mysqli_fetch_array($result)){
                echo "<tr>
                        <td>{$row['id']}</td>    
                        <td>{$row['food_title']}</td>    
                        <td>{$row['ingredients']}</td>    
                        <td>{$row['price']}</td>   
                        <td><a href='edit-catalog.php?foodid={$row['id']}' uk-icon='icon: file-edit; ratio:1.3;' uk-toggle></td></tr>";
                    }
                    echo "</table>";
            	
            } else {
           	 echo("Δεν εκτελέστηκε το query");
            }
           
            mysqli_close($conn);
        ?>		
        
           
    </div>
</div> 


<!-- UIKIT scripts-->    
<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
<?php

} else {
	header("location: dashboard-user.php");
}

?>