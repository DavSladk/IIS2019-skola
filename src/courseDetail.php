<?php
    require_once 'functions/loader.php';
    
    //get course
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE courseId=:id'); //approved
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $data = $stmt->fetch();

    require_once 'modules/header.php';

    //if we got some data
    if($data)
    {
?>

        <h3>Name</h3>
        <?php echo $data['name']?>
        <h3>Description</h3>
        <?php echo $data['description']?>
        <h3>Type</h3>
        <?php echo $data['type']?>
        <h3>Tags</h3>
        <?php echo $data['tags']?>
        <h3>Price</h3>
        <?php echo $data['price']?> Bitcoin
<?php
        //if logged user, offer registration or unregistration
        if(isset($_SESSION['ISSET']) && isStudent())
        {
            $stmt = $pdo->prepare('SELECT * FROM registred WHERE courseId=:courseId AND userId=:userId');
            $stmt->bindParam(':courseId', $_GET['id']);
            $stmt->bindParam(':userId', $_SESSION['userId']);
            $stmt->execute();
            $data = $stmt->fetch();

            if($data)
            {
?>
                <form action="registerCourse.php" method="post">
                    <input type="submit" name="unregister" value="Unregister" />
                </form>
 
<?php
            }
            else
            {
?>
                <form action="registerCourse.php" method="post">
                    <input type="submit" name="register" value="Register" />
                </form>             
<?php
            }
        }
?>

<?php
    }
    else
    {
        echo 'NO COURSE WITH ID '.$_GET['id'];
    }
?>

<?php
    require_once 'modules/footer.php';
?>