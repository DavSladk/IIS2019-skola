<?php
    require_once 'functions/loader.php';
    
    //get all courses
    $queryResult = $pdo->query('SELECT * FROM courses'); //approved

    require_once 'modules/header.php';

//generate courses table 
?>
    <h2>All Courses</h2>
    <table>
    <tr>
    <th>Name</th>
    <th>Type</th>
    <th>Price</th>
    </tr>
<?php
    foreach($queryResult as $row)
    {
?>
        <tr>
        <th><a href=<?php echo 'courseDetail.php?id='.$row['courseId']?>><?php echo $row['name']?></th>
        <th><?php echo $row['type']?></th>
        <th><?php echo $row['price']?> Bitcoin</th>
        </tr>
<?php    
    }
?>

<?php
    require_once 'modules/footer.php';
?>