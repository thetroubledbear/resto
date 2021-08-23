<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}

include("dbconnect.php");

//$query = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";	
//$result = mysqli_query($conn, $query);
	$ret = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'orders' ");
	$row = mysqli_fetch_array($ret);
	$auto_increment = $row['Auto_increment'];
//while ($get_last_row = mysqli_fetch_array($result)){
	//	$last_id = $get_last_row['id'];
	//}

//αντλώ την ημερομηνία
$date = date('Y-m-d');

//προσθήκη 
if(isset($_POST['submit'])){
	$date = $_POST['date'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$order_number = $_POST['order_num']; 
	$select_ord_num_items = $_POST['food_quantity'];
	$int_order_number = (int) $auto_increment;
	$food_null = $_POST['food'];
	$food_null2 = $_POST['food2'];
	$food_null3 = $_POST['food3'];
	$food_null4 = $_POST['food4'];
	$int_food_null = (int) $food_null;
	$int_food_null2 = (int) $food_null2;
	$int_food_null3 = (int) $food_null3;
	$int_food_null4 = (int) $food_null4;
	
	$insert = "INSERT INTO orders (order_date, firstname, lastname, phone, address, order_number) VALUES('$date','$fname', '$lname','$phone', '$address', '$int_order_number') ";
	
	if (mysqli_query($conn, $insert) === true) {    

		switch($select_ord_num_items){
			case "1": 
				$insert2 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null')";
				$inresult = mysqli_multi_query($conn, $insert2); 
				break;
			case "2":
				$insert2 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null')";
				$insert3 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null2')";
				$inresult = mysqli_multi_query($conn, $insert2); 
				$inresult2 = mysqli_multi_query($conn, $insert3); 
				break;
			case "3":
				$insert2 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null')";
				$insert3 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null2')";
				$insert4 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null3')";
				$inresult = mysqli_multi_query($conn, $insert2); 
				$inresult2 = mysqli_multi_query($conn, $insert3); 
				$inresult3 = mysqli_multi_query($conn, $insert4); 
				break;
			case "4":
				$insert2 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null')";
				$insert3 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null2')";
				$insert4 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null3')";
				$insert5 = "INSERT INTO order_id (order_id, food_choice) VALUES('$int_order_number', '$int_food_null4')";
				$inresult = mysqli_multi_query($conn, $insert2); 
				$inresult2 = mysqli_multi_query($conn, $insert3); 
				$inresult3 = mysqli_multi_query($conn, $insert4); 
				$inresult4 = mysqli_multi_query($conn, $insert5);
				break;
		}
	  } else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	  }
	$add = true;
}
if ($_SESSION['isadmin'] == "yes") {
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Προσθήκη παραγγελίας | Administrator Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
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
			<li><a href="orders.php" uk-icon="icon: arrow-left; ratio: 1.5" uk-toggle></a></li>
		</ul>

	</div>
    	<div> 
		<?php if ($add == true){
			 	echo "Η παραγγελία έχει προστεθεί επιτυχώς";	
			} 
		?>
            <form action="" method="POST" class="uk-form-horizontal uk-margin-large">
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Ημερομηνία</label>
				        <div class="uk-form-controls">
				            <input class="uk-input" name="date" type="date" value = "<?php echo $date; ?>">
				        </div>
				    </div>
				
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Όνομα</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="fname" type="text">
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επίθετο</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="lname" type="text">
				        </div>
				    </div>
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Διεύθυνση</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="address" type="text">
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Τηλέφωνο</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="phone" type="text">
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Αριθμός παραγγελίας "συμπληρώνεται αυτόματα"</label>
				        <div class="uk-form-controls">
				            <input class="uk-input" name="order_num" type="text" placeholder="disabled" value = "<?php echo $auto_increment;//echo $last_id + 1; ?>" disabled>
							
				        </div>
				    </div>
					<div class="uk-margin">
        				<label class="uk-form-label" for="form-stacked-select">Επιλέξτε αριθμό μεμονομένων προιόντων</label>
    					<div class="uk-form-controls">
        				 <select class="uk-select" name="food_quantity">
            				 <option value = "1">1</option>
            			     <option value = "2">2</option>
            			     <option value = "3">3</option>
            			     <option value = "4">4</option>
            			 </select>
        				</div>
    				</div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επιλογές φαγητού</label>
				        <div class="uk-form-controls">
				             <input class="uk-input uk-margin-small-bottom" name="food" type="number">
							 <input class="uk-input uk-margin-small-bottom" name="food2" type="number">
							 <input class="uk-input uk-margin-small-bottom" name="food3" type="number">
							 <input class="uk-input uk-margin-small-bottom" name="food4" type="number">
				        </div>
				    </div>
				    <div class="uk-align-right">
                        <button class="uk-button uk-button-primary" name="submit">ΠΡΟΣΘΗΚΗ ΠΑΡΑΓΓΕΛΙΑΣ</button>
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