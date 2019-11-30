<?php
    require_once 'functions/loader.php';

    require_once 'modules/header.php';

    if( isset($_POST['try']) )
    {
        $stmt = $pdo->prepare('INSERT INTO users (login, pass, name) VALUES(:login, :pass, :name)');
        $stmt->bindParam(':login', $_POST['login']);
        $stmt->bindParam(':pass', $_POST['pass']);
        $stmt->bindParam(':name', $_POST['name']);
        if($stmt->execute())
        {
            header('Location: home.php');
        }
        else
        {
            $fail = true;
        }
    }
?>

<h2>Login</h2>
<?php
    //if login failed
    if(isset($fail) && $fail === true)
    {
?>
        This login already exists.
<?php
    }
?>
<form method="post">
    <label>Login: <input type="text" name="login" required></label><br>
    <label>Password: <input type="password" name="pass" required></label><br>
    <label>Name: <input type="text" name="name" required></label><br>
    <input type="submit" name="try" value="register">
</form>

<?php
    require_once 'modules/footer.php';
?>