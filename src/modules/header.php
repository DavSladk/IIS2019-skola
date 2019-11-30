<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>IIS - skola</title>
			<link rel="stylesheet" type="text/css" href="styles/style.css">
		</head>

	<body>

<?php
    //named of logged user
    if(isset($_SESSION['ISSET']))
    {
        echo "user: ".$_SESSION['name'];
    }
    //button to go back to overview
?>
    <form action="home.php" method="post">
            <input type="submit" value="Overwiev" />
    </form>
<?php
	//if logged user, generate menu
    if(isset($_SESSION['ISSET']))
    {
        //if student, generate my sourses button
        if(isStudent())
        {
?> 
            <form action="myCourses.php" method="post">
                <input type="submit" value="My Courses" />
            </form>
<?php            
        }
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