<?php
    require_once 'functions/loader.php';
    
    //get my courses
    $stmt = $pdo->prepare('SELECT * FROM registred R JOIN courses C ON R.courseId = C.courseId WHERE R.userId = :userId');
    $stmt->bindParam(':userId', $_SESSION['userId']);
    $stmt->execute();

    require_once 'modules/header.php';

//generate my courses table 
?>
    <h2>My Courses</h2>
    <table>
    <tr>
    <th>Name</th>
    <th>Type</th>
    <th>Score</th>
    </tr>
<?php
    foreach($stmt as $row)
    {
?>
        <tr>
        <th><a href=<?php echo 'courseDetail.php?id='.$row['courseId']?>><?php echo $row['name']?></th>
        <th><?php echo $row['type']?></th>
        <th><?php echo $row['score']?></th>
        </tr>
<?php    
    }
?>

<?php
    require_once 'modules/footer.php';
?>