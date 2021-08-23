<?php 
session_start();

if (!isset($_SESSION['usr'], $_SESSION['pass'])){
    header("Location: index.php");
}

if($_SESSION['isadmin']=="yes"){
	header("Location: dashboard.php");
}
?>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
      <style>
    .uk-container-xlarge {
         max-width: 2000px;
    }
    </style>
</head>
<body>
<div class="uk-section-muted">
    <nav class="uk-navbar-center uk-navbar-container uk-margin-auto">
        <div class="uk-navbar-left uk-margin-large-left">
            <a class="uk-navbar-toggle" uk-toggle="target: #offcanvas-usage">
                <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Μενού</span>
            </a>
        </div>


        <a class="uk-navbar-item uk-logo" href=dashboard-user.php>Resto Management</a>
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

<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge">
    <?php echo "<div class= 'uk-margin-medium-bottom'> <h4> Καλώς Ορίσατε [Χρήστης χωρίς δικαιώματα] </h4> ".$_SESSION['usr'];
            echo "</div>";
             
        ?>
        <div class ="uk-child-width-1-2@s uk-grid-match" uk-grid>
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
	                    <a href="orders-user.php" class="uk-button uk-button-text">Εισοδος</a>
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
	                    <a href="catalog-user.php" class="uk-button uk-button-text">Εισοδος</a>
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
</div> <!--Κάρτες πλοήγησης χρήστη -->


<!-- UIKIT scripts-->    
<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
