<?php
session_start();

include("dbconnect.php");
//Βλέπω αν έχει συνδεθεί ήδη ο χρήστης
if(isset($_SESSION['usr'], $_SESSION['pass'])){
	header("Location: dashboard.php");
}
// εαν πατηθεί το κουμπί είσοδος 
if (isset($_POST['submit'])) {
	$usrname = $_POST['username'];
	$pass = $_POST['userpass'];
    
	$query = "SELECT * FROM users WHERE username = '$usrname'";
	$result = mysqli_query($conn, $query);
	
    
	if( mysqli_num_rows($result) > 0) {
	
		$row = mysqli_fetch_array($result);
        $dbhashed = $row['password'];
        if(password_verify($pass, $dbhashed)){
            $_SESSION['usr'] = $row['username'];
            $_SESSION['pass'] = $row['password'];
            //εαν η στήλη admin είναι yes ... 
            if($row['is_admin'] == "yes"){
                $_SESSION['isadmin'] = $row['is_admin'];
                header("Location: dashboard.php");
            } else {
                header("location: dashboard-user.php");
            }
        } else { 
            echo "<div class='uk-alert-danger' uk-alert>
            <a class='uk-alert-close' uk-close></a>
            <p>Λάθος στοιχεία προσπαθήστε ξανά.</p>
            </div>";
        }
    
    }
	
	mysqli_close($conn);	
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Resto AE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/uikit.css"/>
    <style>
        .uk-border-rounded {
            border-radius: 10px;
        }   
        
    </style>
    </head>
<body>
    	<div uk-alert>
    		<a class="uk-alert-close" uk-close></a>
    		<h3>Στοιχεία Σύνδεσης</h3>
    		<p>Για να συνδεθείτε ως admin username = admin και password = 1234</p>
		</div>
    <div class="uk-section uk-section-default">
        <div class="uk-container uk-container-small">
            <div class="uk-position-center">
                <div class="uk-card uk-card-default uk-card-hover uk-card-body uk-border-rounded">  
                    <h3>Resto AE Management System</h3>
                    <form action="" method="post" class="uk-animation-fade uk-margin-medium-top">
                            <div class="uk-inline uk-align-left">
                                <span class="uk-form-icon" uk-icon="icon: user"></span>
                                <input class="uk-input" type="text" name="username" placeholder="Όνομα Χρήστη"> 
                            </div>
                            <div class="uk-inline uk-align-right">
                                <span class="uk-form-icon" uk-icon="icon: unlock"></span>
                                <input class="uk-input" type="password" name="userpass" placeholder="Κωδικός Χρήστη">
                            </div>
                            <div class="uk-align-bottom">
                                <div class="uk-align-right">
                                    <button class="uk-button uk-button-primary" name="submit">Εισοδος</button>
                                </div> 
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



<!-- UIKIT scripts--> 
<script src="assets/js/uikit.js"></script>
<script src="assets/js/uikit-icons.min.js"></script>
</body>
</html>
