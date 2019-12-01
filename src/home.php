<?php
    require_once 'functions/loader.php';
    
    $queryResult = false;
    if( isset($_GET['filter']) && isset($_GET['search']) )
    {
        //get search results
        $queryResult = $pdo->prepare('SELECT * FROM courses WHERE name LIKE :filter OR type LIKE :filter OR tags LIKE :filter');
        $filter = $_GET['filter'];
        $filter = "%$filter%";
        $queryResult->bindParam(':filter', $filter);
        $queryResult->execute();
    }
    else
    {
        //get all courses
        $queryResult = $pdo->query('SELECT * FROM courses'); //approved
    }

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
    <form method="get">
        Search: <input type="search" name="filter"/><input type="submit" name="search" value="Search"><br>
    </form>
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