<?php 
session_start(); 

if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}


include("dbconnect.php");

$q = $_GET['q'];
$query = "SELECT * FROM users WHERE username LIKE '%".$q."%' OR is_admin LIKE '%".$q."%' OR id LIKE '%".$q."%'";
$result = mysqli_query($conn, $query);

?> 
<!DOCTYPE HTML>
<html>
<head>
    <title>Αναζήτηση | Χρήστες</title>
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
			    <li><a href="user-management.php" uk-icon="icon: arrow-left; ratio: 1.5" uk-toggle></a></li>
			</ul>
	
		</div>
				
		<?php 
        	if (mysqli_num_rows($result) > 0){
        	echo " <table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
            <caption>ΠΑΡΑΓΓΕΛΙΕΣ</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ΟΝΟΜΑ ΧΡΗΣΤΗ</th>
                    <th>ΚΩΔΙΚΟΣ ΧΡΗΣΤΗ</th>
                    <th>ΔΙΑΧΕΙΡΗΣΤΗΣ</th>  
                        
                </tr>
            </thead>";
        
	          while ($row = mysqli_fetch_row($result)){
	    		echo '<tr>';
					foreach ($row as $field) {
	        			echo"<td>$field</td>";
				
					}
	    		echo '</tr>';
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