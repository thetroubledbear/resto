<?php
//ξεκινάω session
session_start();

if (!isset($_SESSION['usr'], $_SESSION['pass'], $_SESSION['isadmin'])){
    header("Location: index.php");
}
include("dbconnect.php");
$query = "SELECT * FROM users";

$result = mysqli_query($conn, $query);

//προσθήκη χρήστη
if(isset($_POST['submit'])){
    $username = $_POST['user'];
    $password = $_POST['password'];
	$hashed = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = $_POST['isadmin'];

    $insert = "INSERT INTO users (username, password, is_admin) VALUES('$username', '$hashed', '$is_admin')";

    $result = mysqli_query($conn, $insert); 
    $add = true;
	header("location: user-management.php");
}
//διαγραφή 
if(isset($_POST['delete'])){
	$idchoice = $_POST['idchoice']; 
	$delquery = "DELETE FROM users WHERE id = '$idchoice'";
	$delresult = mysqli_query($conn, $delquery);
	$deletion = true;
	header("location: user-management.php");
	
}
//επεξεργασία χρήστη 
if(isset($_POST['edit'])){
	$changed = $_POST['changed']; 
	$hashed = password_hash($changed, PASSWORD_DEFAULT);
	$selectoption = $_POST['dbfields'];
	$id = $_POST['changedidchoice'];
	
	switch ($selectoption){
		case "1":
			$editquery = "UPDATE users SET username = '$changed' WHERE id='$id'";
			break;
		case "2":
			$editquery = "UPDATE users SET password = '$hashed' WHERE id='$id'";
			break;
		case "3":
			$editquery = "UPDATE users SET is_admin = '$changed' WHERE id='$id'";
			break;
	}

	$edit = true;
	$editresult = mysqli_query($conn, $editquery); 
	header("location: user-management.php");
}
// Αποτελέσματα ανά πεντάδα 
if(isset($_POST['fiveresults'])){
	$query = "SELECT * FROM users ORDER BY id LIMIT 5";	
	$result = mysqli_query($conn, $query);
}
// Αποτελέσματα ανά εικοσάδα
if(isset($_POST['tenresults'])){
	$query = "SELECT * FROM users ORDER BY id LIMIT 10";	
	$result = mysqli_query($conn, $query);
}

if ($_SESSION['isadmin'] == "yes") {
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Διαχείρηση Χρηστών | Administrator Dashboard</title>
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
       <?php 
            if ($add == true){
			 	echo "Προστέθηκε επιτυχώς ο χρήστης";	
			} else if($deletion == true){
			 	echo "Διαγράφηκε επιτυχώς ο χρήστης";
            } else if($edit == true){
                echo "Τροποποιήθηκε επιτυχώς ο χρήστης";
            }
            ?>	
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-xlarge uk-margin-auto-right">
    	<div> 
			<ul class="uk-iconnav">
			    <li><a href="#modal-center1" uk-icon="icon: plus; ratio: 1.3;" uk-toggle></a></li>
			    <li><a href="#modal-center2" uk-icon="icon: file-edit; ratio: 1.3;" uk-toggle></a></li>
			    <li><a href="#modal3" uk-icon="icon: trash; ratio: 1.3;" uk-toggle></a></li>
			</ul>
		</div>
        <div class="uk-margin">
    		<form action="search-users.php" method="GET">
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
			<form action="user-management.php" method="post">
			<span>Αποτελέσματα ανά...</span><br>
			<button class="uk-button uk-button-text" name="fiveresults">5</button>
			<span>|</span>
			<button class="uk-button uk-button-text" name="tenresults">10</button>
			<span>|</span>
			<button class="uk-button uk-button-text">ΕΜΦΑΝΙΣΗ ΟΛΩΝ</button>
			</form>
		</div>
        <!-- Διαλογος προσθεσης χρήστη --> 
        <div id="modal-center1" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">			
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Όνομα χρήστη</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="user" type="text">
				        </div>
				    </div>
					<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Κωδικός Πρόσβασης</label>
				        <div class="uk-form-controls">
				             <input class="uk-input" name="password" type="text">
				        </div>
				    </div>
				    <div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Είναι διαχειριστής;</label>
				        <div class="uk-form-controls">
                        <select class="uk-select" name="isadmin">
            				<option value = "yes">ΝΑΙ</option>
            			    <option value = "no">ΟΧΙ</option>
            			</select>
				        </div>
                        <button class="uk-button uk-button-primary uk-align-right uk-margin-medium-top" name="submit">ΠΡΟΣΘΗΚΗ</button>
                    </div>
				</form>
			</div>
		</div> 
        <!-- Διαλογος τροποποίησης χρήστη --> 
        <div id="modal-center2" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">
					<div class="uk-margin">
							<label class="uk-form-label" for="form-stacked-text">Επιλογή ID χρήστη</label>
							<div class="uk-form-controls">
								<input class="uk-input" name="changedidchoice" type="number">
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-stacked-select">Επιλέξτε πεδίο διόρθωσης</label>
							<div class="uk-form-controls">
							<select class="uk-select" name="dbfields">
								<option value = "1">Όνομα χρήστη</option>
								<option value = "2">Κωδικός</option>
								<option value = "3">Είναι διαχειριστής;</option>
							</select>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-stacked-text">Αλλαγη πεδιου "Για αλλαγή διαχειριστή πρέπει να γράψετε 'yes' ή 'no'"</label>
						
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="changed">
							</div>
						</div>
						<button class="uk-button uk-button-primary uk-align-right uk-margin-medium-top" name="edit">ΑΛΛΑΓΗ</button>
							
					</div>
				</form>
    		</div>
		</div>
		<!-- Διαλογος αφαιρεσης χρήστη -->
        <div id="modal3" class="uk-flex-top" uk-modal>
    		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        		<button class="uk-modal-close-default" type="button" uk-close></button>
        		<form action="" method="POST" class="uk-form-horizontal uk-margin-large">
        			<div class="uk-margin">
				        <label class="uk-form-label" for="form-stacked-text">Επιλογή Kωδικού Χρήστη</label>
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
				</form>
    		</div>
		</div>
<div class="uk-section uk-section-default">
	<div class="uk-container uk-container-xlarge uk-margin-auto">
<?php 
        	if (mysqli_num_rows($result)){
                echo "<table class='uk-table uk-table-hover uk-table-responsive uk-table-divider'>
                <caption>Κατάλογος</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ΟΝΟΜΑ ΧΡΗΣΤΗ</th>
                        <th>ΚΩΔΙΚΟΣ ΧΡΗΣΤΗ</th>
                        <th>ΔΙΑΧΕΙΡΙΣΤΗΣ</th>  
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
                echo("Δεν εκτελέστηκε το query");
            }
            
         
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