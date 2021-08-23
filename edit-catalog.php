<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}

include("dbconnect.php");

$foodid = $_GET['foodid'];

$query = "SELECT * FROM food_catalog where id = '$foodid'";
$result = mysqli_query($conn, $query);

if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_row($result)) {
		$ft = $row[1];
		$in = $row[2];
		$pr = $row[3];
	}
}

if(isset($_POST['submit'])){
	$foodt = $_POST['food_title'];
	$ingr = $_POST['ing'];
	$pric = $_POST['price'];
	$intpr = (int) $pric;

	$updq = "UPDATE food_catalog SET food_title = '$foodt', ingredients = '$ingr', price = '$intpr' WHERE id='$foodid'";
	$editresult = mysqli_query($conn, $updq);
	header('location: catalog.php');

}
if ($_SESSION['isadmin'] == "yes") {	
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Κατάλογος - επεξεργασία | Administrator Dashboard</title>
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
                <a href="dashboard.php" class="uk-align-responsive uk-button uk-button-primary">ΑΡΧΙΚΗ</a> 
                <a href="orders.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="catalog.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a>
				<a href="user-management.php" class="uk-align-responsive uk-button uk-button-primary">ΔΙΑΧΕΙΡΗΣΗ ΧΡΗΣΤΩΝ</a> 
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> 
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
	<div class = "uk-margin-medium-bottom"> 
    	
		<ul class="uk-iconnav">
			<li><a href="catalog.php" uk-icon="icon: arrow-left; ratio: 1.5" uk-toggle></a></li>
		</ul>

	</div>
    	<div> 
            <form action="" method="POST" class="uk-form-horizontal uk-margin-large">
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Αριθμός στον κατάλογο</label>
				        <div class="uk-form-controls">
				            <input class="uk-input" type="text" placeholder="disabled" value = "<?php echo $foodid ?>" disabled>
							
				        </div>
				    </div>
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Τίτλος</label>
				        <div class="uk-form-controls">
				            <input class="uk-input" name="food_title" type="text" value = "<?php echo $ft; ?>">
				        </div>
				    </div>
				
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Υλικά</label>
				        <div class="uk-form-controls">
							<textarea class="uk-textarea" rows="5" name= "ing"><?php echo $in; ?></textarea>
				      
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Τιμή</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="price" type="number" value = "<?php echo $pr; ?>">
				        </div>
					</div>
				    <div class="uk-align-right">
                        <button class="uk-button uk-button-primary" name="submit">ΕΠΕΞΕΡΓΑΣΙΑ ΠΑΡΑΓΓΕΛΙΑΣ</button>
                    </div> 
					
			</form>
        </div>
    </div>
</div>

<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
<?php

} else {
	header("location: dashboard-user.php");
}

?>