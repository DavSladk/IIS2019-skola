<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>IIS - skola</title>
			<link rel="stylesheet" type="text/css" href="styles/style.css">
		</head>

	<body>

<?php
    if(isset($_SESSION['ISSET']))
    {
        echo "user: ".$_SESSION['name'];
    }
?>
    <form action="home.php" method="post">
            <input type="submit" value="Overwiev" />
    </form>
<?php
	//if logged user, generate menu
    if(isset($_SESSION['ISSET']))
    {
?>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout" />
        </form>

<?php
    }  
    else //if unlogged user generate login and register buttons
    { 
?>
        <form action="login.php" method="post">
            <input type="submit" value="Login" />
        </form>
        <form action="register.php" method="post">
            <input type="submit" value="Register" />
        </form>
<?php
    }
?>