<?php 
session_start(); 

if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}


include("dbconnect.php");

$q = $_GET['q'];
$query = "SELECT * FROM orders WHERE firstname LIKE '%".$q."%' OR lastname LIKE '%".$q."%' OR id LIKE '%".$q."%' OR address LIKE '%".$q."%'";
$result = mysqli_query($conn, $query);

?> 
<!DOCTYPE HTML>
<html>
<head>
    <title>Αναζήτηση | Παραγγελίες</title>
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
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>

        </div>
        </div>
    </nav>
</div> <!--Μπάρα πλοήγησης-->

<!-- ΠΙΝΑΚΑΣ -->
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
    	<div> 
    	
			<ul class="uk-iconnav">
			    <li><a href="orders.php" uk-icon="icon: arrow-left; ratio: 1.5" uk-toggle></a></li>
			</ul>
	
		</div>
				
		<?php 
        	if (mysqli_num_rows($result) > 0){
        	echo " <table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
            <caption>ΠΑΡΑΓΓΕΛΙΕΣ</caption>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Ημερομηνία Παραγγελίας</th>
                    <th>Όνομα</th>
                    <th>Επίθετο</th>
                    <th>Τηλέφωνο</th>
                    <th>Διεύθυνση</th>
                    <th>Λεπτομέρειες</th>
                
                    
                </tr>
            </thead>";
        
            while ($row = mysqli_fetch_array($result)){
				echo "<tr>
					<td>{$row['id']}</td>
					<td>{$row['order_date']}</td>
					<td>{$row['firstname']}</td>
					<td>{$row['lastname']}</td>
					<td>{$row['phone']}</td>
					<td>{$row['address']}</td>";
					
				if($_SESSION['isadmin'] == 'yes'){
					echo "<td><a href='view.php?order_number={$row['id']}' uk-icon='icon: chevron-double-right; ratio: 1.3' ></td></tr>";
				} else {
					echo "<td><a href='view-user.php?order_number={$row['id']}' uk-icon='icon: chevron-double-right; ratio: 1.3' ></td></tr>";
				}
					
				}
				echo '</table>';
				
           } else {
           	 echo("Δεν εντοπίστηκε εγγραφή! Δοκιμάστε ξανά!");
           }
           
           mysqli_close($conn);
        ?>		
        
           
    </div>
</div> 


<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>