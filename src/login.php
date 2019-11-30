<?php
    require_once 'functions/loader.php';

    require_once 'modules/header.php';

    if( isset($_POST['try']) )
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE login=:login AND pass=:pass');
        $stmt->bindParam(':login', $_POST['login']);
        $stmt->bindParam(':pass', $_POST['pass']);
        $stmt->execute();
        $data = $stmt->fetch();

        if($data)
        {
            $_SESSION['userId'] = $data['userId'];
            $_SESSION['login'] = $data['login'];
            $_SESSION['pass'] = $data['pass'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['ISSET'] = true;
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
        Wrong login/password
<?php
    }
?>
<form method="post">
    <label>Login: <input type="text" name="login" required></label><br>
    <label>Password: <input type="password" name="pass" required></label><br>
    <input type="submit" name="try" value="login">
</form>

<?php
    require_once 'modules/footer.php';
?>