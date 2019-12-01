<?php
    require_once 'functions/loader.php';

    //checking if logged user
    if(!isset($_GET['id']))
    {
?>
        <h1>Unauthorized access!</h1>
<?php
        exit();
    }
    
    //get course
    $courseDetail = $pdo->prepare('SELECT C.name courseName, U.name userName, description, type, tags, price FROM courses C JOIN users U ON C.guarantor = U.userId WHERE courseId=:id'); //approved
    $courseDetail->bindParam(':id', $_GET['id']);
    $courseDetail->execute();
    $courseDetailData = $courseDetail->fetch();

    //if course with id do not exists
    if(! $courseDetailData)
    {
?>
        <h1>No course with ID <?php echo $_GET['id'] ?>!</h1>
<?php
        exit();
    }

    $isRegistred = false;
    $isGuarantor = false;
    if(isset($_SESSION['ISSET']))
    {
        if(isStudent())
        {
            //is this user registred for this course?
            $tmp = $pdo->prepare('SELECT * FROM registred R JOIN courses C ON R.courseId = C.courseId WHERE R.userId = :userId AND R.courseId = :courseId');
            $tmp->bindParam(':userId', $_SESSION['userId']);
            $tmp->bindParam(':courseId', $_GET['id']);
            $tmp->execute();
            $isRegistred = $tmp->fetch();
        }
        
        if(isGuarantor())
        {
            //is this user guarantor for this course?
            $tmp = $pdo->prepare('SELECT * FROM courses C WHERE C.guarantor = :userId AND C.courseId = :courseId');
            $tmp->bindParam(':userId', $_SESSION['userId']);
            $tmp->bindParam(':courseId', $_GET['id']);
            $tmp->execute();
            $isGuarantor = $tmpGuar->fetch();
        }
    }
        
    //get terms for this course
    $terms = $pdo->prepare('SELECT * FROM terms WHERE courseId = :courseId');
    $terms->bindParam(':courseId', $_GET['id']);
    $terms->execute();

    //get approved students
    $approvedStudents = false;
    if(isLector())
    {
        $approvedStudents = $pdo->prepare('SELECT * FROM users U JOIN registred R ON U.userId = R.userId WHERE R.courseId = :courseId AND R.approved = 1');
        $approvedStudents->bindParam(':courseId', $_GET['id']);
        $approvedStudents->execute();
    }

    //get unapproved students
    $unapprovedStudents = false;
    if(isGuarantor())
    {
        $unapprovedStudents = $pdo->prepare('SELECT * FROM users U JOIN registred R ON U.userId = R.userId WHERE R.courseId = :courseId AND R.approved = 0');
        $unapprovedStudents->bindParam(':courseId', $_GET['id']);
        $unapprovedStudents->execute();
    }
        
    require_once 'modules/header.php';

    //if student registration is not approved
    if($isRegistred)
    {
        if( $isRegistred['approved'] === '0' )
        {
?>
            <h2>Your registration is yet to be approved!</h2>
<?php
        }
    }    
?>
    <!-- Detail block -->
    <h3>Name</h3>
        <?php echo $courseDetailData['courseName']?>
    <h3>Guarant</h3>
        <?php echo $courseDetailData['userName']?>
    <h3>Type</h3>
        <?php echo $courseDetailData['type']?>
    <h3>Tags</h3>
        <?php echo $courseDetailData['tags']?>
    <h3>Price</h3>
        <?php echo $courseDetailData['price']?> Bitcoin
    <h3>Description</h3>
        <?php echo $courseDetailData['description']?>
<?php
    //if logged user, offer registration or unregistration
    if(isset($_SESSION['ISSET']) && isStudent())
    {
        if($isRegistred !== false)
        {
?>
            <!-- Unregister form -->
            <form action="registerCourse.php" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                <input type="submit" name="unregister" value="Unregister" />
            </form> 
<?php
        }
        else
        {
?>
            <!-- Register form -->
            <form action="registerCourse.php" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                <input type="submit" name="register" value="Register" />
            </form>             
<?php
        }
    }
?>

    <!-- Term list block -->
    <h2>Term list</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Max Score</th>
            <th>Datetime</th>
        </tr>
<?php
        foreach($terms as $row)
        {
?>
            <tr>
                <th><a href=<?php echo 'termDetail.php?id='.$row['termId']?>><?php echo $row['name']?></th>
                <th><?php echo $row['type']?></th>
                <th><?php echo $row['score']?></th>
                <th><?php echo $row['datetime']?></th>
            </tr>
<?php    
        }
?>
    </table>

<!-- TO DO add term-->

    <!-- Approved Student list -->
    <h2>Approved students list</h2>
    <table>
        <tr>
            <th>Login</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
<?php
        // $_SESSION['id'] = $_GET['id'];
        foreach($approvedStudents as $row)
        {
?>
            <tr>
            <th><?php echo $row['login']?></th>
            <th><?php echo $row['name']?></th>
            <form method='post' action="changeScore.php">
                <th>
                    <input type="number" min="0" max="100" name="score" value="<?php echo $row['score']?>"/>
                    <input type="hidden" name="registredId" value="<?php echo $row['registredId']?>" />
                    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
                </th>
                <th>
                    <input type="submit" name="change" value="Change">
                </th>
            </form>
            </tr>
<?php    
        }
?>
    </table>
<?php
    require_once 'modules/footer.php';
?>