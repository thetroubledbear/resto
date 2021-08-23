<?php
session_start();
if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}
if($_SESSION['isadmin']=="yes"){
	header("Location: dashboard.php");
}
include("dbconnect.php");
//σελιδοποίηση
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


$query = "SELECT id, order_date, firstname, lastname, phone, address FROM orders ORDER BY id DESC LIMIT $offset, $page_result ";


$result = mysqli_query($conn, $query);

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

?> 
<!DOCTYPE HTML>
<html>
<head>
    <title>Παραγγελίες | Orders</title>
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
                <a href="dashboard-user.php" class="uk-align-responsive uk-button uk-button-primary">ΑΡΧΙΚΗ</a> 
                <a href="orders-user.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="catalog-user.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a> 
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> 

<!-- ΠΙΝΑΚΑΣ -->
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
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
					<td><a href='view-user.php?order_number={$row['id']}' uk-icon='icon: chevron-double-right; ratio: 1.3' ></td></tr>";
					
				}
				echo '</table>';
				} else {
					echo("Δεν εκτελέστηκε το query");
			}
		
			
			
				$pagecount = 60; // Total number of rows
				$num = $pagecount / $page_result ;
				echo "<ul class='uk-pagination uk-flex-right uk-margin-medium-top uk-text-large' uk-margin>";
				if($_GET['pageno'] > 1)
					{	
					echo "<li><a href = 'orders-user.php?pageno = ".($_GET['pageno'] - 1)." '> <span uk-pagination-previous></span></a></li>";
					}
					for($i = 1 ; $i <= $num ; $i++)
					{
					echo "<li><a href = 'orders-user.php?pageno={$i}'>{$i}</a></li>";
					}
					if(!$num = 1)
					{
					echo "<li><a href = 'orders-user.php?pageno = ".($_GET['pageno'] + 1)." '><span uk-pagination-next></span></a></li>";
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