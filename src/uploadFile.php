<?php
    require_once 'functions/loader.php';

    $target_dir = "../files/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = true;
    
    // Check if file already exists
    if (file_exists($target_file))
    {
        $uploadOk = false;
?>
    File already exists.
<?php
    }
    
    if($uploadOk)
    {
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
?>
            Successful upload.
<?php
            $tmp = $pdo->prepare('INSERT INTO files (termId, fileId) VALUES (:termId, :fileId)');
            $tmp->bindParam(':termId', $_SESSION['id']);
            $tmp->bindParam(':fileId', basename($_FILES["fileToUpload"]["name"]));
            $tmp->execute();
        }
        else
        {
?>
            Error while uploading.
<?php
        }
    }
?>

<form action="termDetail.php" method="get">
    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
    <input type="submit" value="Back">
</form>