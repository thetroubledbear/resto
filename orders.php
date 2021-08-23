<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}

require("dbconnect.php");
//selides
$offset = 0;
$page_result = 15; 
	
if($_GET['pageno'])
{
 $page_value = $_GET['pageno'];
 if($page_value > 1)
 {	
  $offset = ($page_value - 1) * $page_result;
 }
}


$query = "SELECT id, order_date, firstname, lastname, phone, address FROM orders ORDER BY id DESC LIMIT $offset, $page_result";


$result = mysqli_query($conn, $query);

//επεξεργασία παραγγελίας 
if(isset($_POST['editorder'])){
	$changed = $_POST['changed']; 
	$selectoption = $_POST['dbfields'];
	$id = $_POST['changedidchoice'];
	
	switch ($selectoption){
		case "1":
			$editquery = "UPDATE orders SET order_date = '$changed' WHERE id='$id'";
			break;
		case "2":
			$editquery = "UPDATE orders SET firstname = '$changed' WHERE id='$id'";
			break;
		case "3":
			$editquery = "UPDATE orders SET lastname = '$changed' WHERE id='$id'";
			break;
		case "4";
			$editquery = "UPDATE orders SET phone = '$changed' WHERE id='$id'";
			break;
		case "5":
			$editquery = "UPDATE orders SET address = '$changed' WHERE id='$id'";
			break;
	}
		
	$edit = true;
	$editresult = mysqli_query($conn, $editquery); 
	
}
//διαγραφή
if(isset($_POST['delete'])){
	$idchoice = $_POST['idchoice']; 
	$delquery = "DELETE FROM orders WHERE id = '$idchoice'";
	$delresult = mysqli_query($conn, $delquery);
	$deletion = true;
	
}
// Αποτελέσματα ανά πεντάδα 
if(isset($_POST['fiveresults'])){
	$query = "SELECT * FROM orders ORDER BY id DESC LIMIT 5";	
	$result = mysqli_query($conn, $query);
}
// Αποτελέσματα ανά εικοσάδα
if(isset($_POST['tenresults'])){
	$query = "SELECT * FROM orders ORDER BY id DESC LIMIT 10";	
	$result = mysqli_query($conn, $query);
}
if ($_SESSION['isadmin'] == "yes") {	
?> 
<!DOCTYPE HTML>
<html>
<head>
    <title>Παραγγελίες | Administrator Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
    <style>
		.uk-text-large{
			font-size: 18px;
		}
    </style>
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

<!-- ΠΙΝΑΚΑΣ -->
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
    	<div> 
			<ul class="uk-iconnav">
			    <li><a href="add-order.php" uk-icon="icon: plus; ratio: 1.3" ></a></li>
			    <li><a href="#modal-center2" uk-icon="icon: file-edit; ratio: 1.3" uk-toggle></a></li>
			    <li><a href="#modal3" uk-icon="icon: trash; ratio: 1.3" uk-toggle></a></li>
		
			</ul>
		</div>
		<div class="uk-margin">
    		<form action="search-orders.php" method="GET">
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
			<form action="orders.php" method="post">
			<span>Αποτελέσματα ανά...</span><br>
			<button class="uk-button uk-button-text" name="fiveresults">5</button>
			<span>|</span>
			<button class="uk-button uk-button-text" name="tenresults">10</button>
			<span>|</span>
			<button class="uk-button uk-button-text">ΕΜΦΑΝΙΣΗ ΟΛΩΝ</button>
			</form>
		</div>
    	<!-- Διαλογος αφαιρεσης παραγγελιας -->
    	<div id="modal3" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">
        			<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επιλογή Αριθμού Παραγγελίας </label>
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
		<!-- Διαλογος τροποποιησης παραγγελιας --> 
		<div id="modal-center2" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">
        		<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επιλογή Αριθμού Παραγγελίας </label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="changedidchoice" type="number">
				        </div>
				    </div>
        			<div class="uk-margin">
        				<label class="uk-form-label" for="form-stacked-select">ΕΠΙΛΕΞΤΕ ΠΕΔΙΟ ΔΙΟΡΘΩΣΗΣ</label>
    					<div class="uk-form-controls">
        				 <select class="uk-select" name="dbfields">
            				 <option value = "1">ΗΜΕΡΟΜΗΝΙΑ ΠΑΡΑΓΓΕΛΙΑΣ</option>
            			     <option value = "2">ΟΝΟΜΑ</option>
            			     <option value = "3">ΕΠΙΘΕΤΟ</option>
            			     <option value = "4">ΤΗΛΕΦΩΝΟ</option>
							 <option value = "5">ΔΙΕΥΘΥΝΣΗ</option>
            			 </select>
        				</div>
    				</div>
    				<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Αλλαγη πεδιου</label>
				        <div class="uk-form-controls">
				            <input class="uk-input" id="form-stacked-text" type="text" name="changed">
				        </div>
				    </div>
				    <div class="uk-align-right">
                        <button class="uk-button uk-button-primary" name="editorder">ΑΛΛΑΓΗ ΠΑΡΑΓΓΕΛΙΑΣ</button>
                    </div> 
				
				</form>
    		</div>
		</div>
    	
		<?php 	// Θα μπορούσα να χρησιμοποιήσω το affected_rows αλλά επειδή με κάθε αλλαγή έβγαζε όλα τα μηνύματα, θεώρησα οτι θα ήταν καλύτερο να το υλοποιήσω με αυτόν τον τρόπο
			if ($add == true){
			 	echo "Η παραγγελία έχει προστεθεί επιτυχώς";	
			} else if($deletion == true){
			 	echo "Η παραγγελία έχει διαγραφεί επιτυχώς";		
			} else if ($edit == true){
			 	echo "Η παραγγελία έχει τροποποιηθεί  επιτυχώς";
			}
		?>
				
				
		<?php 
        	if (mysqli_num_rows($result)){
				echo " <table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
				<caption>ΠΑΡΑΓΓΕΛΙΕΣ</caption>
				<thead>
					<tr>
						<th>Αριθμός Παραγγελιας</th>
						<th>Ημερομηνία Παραγγελίας</th>
						<th>Όνομα</th>
						<th>Επίθετο</th>
						<th>Τηλέφωνο</th>
						<th>Διεύθυνση</th>
						<th>Λεπτομέριες</th>
						
					</tr>
				</thead>";
        
          	while ($row = mysqli_fetch_array($result)){

				  
				echo "<tr>
					<td>{$row['id']}</td>
					<td>{$row['order_date']}</td>
					<td>{$row['firstname']}</td>
					<td>{$row['lastname']}</td>
					<td>{$row['phone']}</td>
					<td>{$row['address']}</td>
					<td><a href='view.php?order_number={$row['id']}' uk-icon='icon: chevron-double-right; ratio: 1.3' ></td></tr>";
					
				}
				echo '</table>';
				} else {
					echo("Δεν υπάρχουν εγγραφές");
			}
		
			
			
				$pagecount = 55; 
				$num = $pagecount / $page_result ;
				echo "<ul class='uk-pagination uk-flex-right uk-margin-medium-top uk-text-large' uk-margin>";
				if($_GET['pageno'] > 1)
					{	
					echo "<li><a href = 'orders.php?pageno = ".($_GET['pageno'] - 1)." '> <span uk-pagination-previous></span></a></li>";
					}
					for($i = 1 ; $i <= $num ; $i++)
					{
					echo "<li><a href = 'orders.php?pageno={$i}'>{$i}</a></li>";
					}
					if(!$num = 1)
					{
					echo "<li><a href = 'orders.php?pageno = ".($_GET['pageno'] + 1)." '><span uk-pagination-next></span></a></li>";
					}
				echo "</ul>";

		
				
				
           mysqli_close($conn);
        ?>		
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