<?php
session_start();

if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}

//εάν είναι admin να δείξει την σελίδα διαφορετικά να κάνει redirect
if ($_SESSION['isadmin'] == "yes") {	

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Administrator Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/> <!-- UiKit-->
    <style>
    .uk-container-xlarge {
         max-width: 2000px;
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
                <a href="catalog.php" class="uk-align-responsive uk-button uk-button-primary">ΚΑΤΑΛΟΓΟΣ</a> 
                <a href="orders.php" class="uk-align-responsive uk-button uk-button-primary">ΠΑΡΑΓΓΕΛΙΕΣ</a>
                <a href="user-management.php" class="uk-align-responsive uk-button uk-button-primary">ΔΙΑΧΕΙΡΗΣΗ ΧΡΗΣΤΩΝ</a>
                <a href="logout.php" class="uk-align-responsive uk-button uk-button-primary">ΑΠΟΣΥΝΔΕΣΗ</a> 
            </div>
        </div>
        </div>
    </nav>
</div> 

<div class="uk-section uk-section-default"> <!--Κάρτες πλοήγησης χρήστη -->
    <div class="uk-container uk-container-xlarge">
        <?php echo "<div class= 'uk-margin-medium-bottom'> <h4> Καλώς Ορίσατε </h4> ".$_SESSION['usr'];
            echo "</div>";
             
        ?>
        <div class ="uk-child-width-1-3@s uk-grid-match" uk-grid>
	        <div>
	            <div class="uk-card uk-card-default uk-card-hover uk-card-body">
	                <div class="uk-flex-last@s uk-card-media-right uk-cover-container">
	                    <img src="assets/img/orders.jpg" alt="" uk-cover>
	                    <canvas width="300" height="300"></canvas>
	                </div>
	                <div class="uk-card-badge uk-label" name="orderCounter">2</div>
	                <h3 class="uk-card-title">Παραγγελίες</h3>
	                <p>Τρέχουσες παραγγελίες</p>
	
	                <div class="uk-card-footer">
	                    <a href="orders.php" class="uk-button uk-button-text">Εισοδος</a>
	                </div>
	
	            </div>
	        </div>
	        <div>
	            <div class="uk-card uk-card-default uk-card-hover uk-card-body">
	                <div class="uk-flex-last@s uk-card-media-right uk-cover-container">
	                    <img src="assets/img/menu.jpg" alt="" uk-cover>
	                    <canvas width="300" height="300"></canvas>
	                </div>
	                <h3 class="uk-card-title">Κατάλογος Φαγητών</h3>
	                <p>Αναζητήστε, προσθέστε και διαγράψτε τον κατάλογο φαγητών</p>
	                <div class="uk-card-footer">
	                    <a href="catalog.php" class="uk-button uk-button-text">Εισοδος</a>
	                </div>
	            </div>
	        </div>  
	        <div>
	            <div class="uk-card uk-card-default uk-card-hover uk-card-body">
	            	<div class="uk-flex-last@s uk-card-media-right uk-cover-container">
	                    <img src="assets/img/users.jpg" alt="" uk-cover>
	                    <canvas width="300" height="300"></canvas>
	                </div>
	                <h3 class="uk-card-title">Χρήστες</h3>
	                <p>Διαχείριση χρηστών -μόνο για διαχειριστές-</p>
	                <div class="uk-card-footer">
	                    <a href="user-management.php" class="uk-button uk-button-text">Εισοδος</a>
	                </div>
	                <span class="uk-align-right" uk-icon="icon: lock"></span>
	            </div>
	        </div>
	    </div>
    </div>
</div> 

<!-- UIKIT scripts-->    
<!-- <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit-icons.min.js"></script> -->
<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
<?php

} else {
	header("location: dashboard-user.php");
}

?>