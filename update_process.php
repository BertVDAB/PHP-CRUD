<?php 

include('config/db_connect.php');

// check GET request id

if(isset($_GET['id'])){
    // get id and output details
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    // sql to get the pizza from the database where id matches the GET id

    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get result from query
    $result = mysqli_query($conn, $sql);

    // fetch result in ASS array format
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    //close database connection
    mysqli_close($conn);

    // print_r($pizza);
}

if(isset($_POST['update'])){
    // escape sql chars
    $id_to_update = mysqli_real_escape_string($conn, $_POST['id_to_update']);
    // sql to update pizza from database
    $sql = "UPDATE pizzas SET title = '$_POST[title]', email = '$_POST[email]', ingredients = '$_POST[ingredients]' WHERE id = $id_to_update";
    // save to database and check
    if(mysqli_query($conn, $sql)){
        // succesfull
        // header('Location: index.php');
    }else{
        // failed and error!
        echo 'query error: ' . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
    
<!-- start tag for head and body in header! -->

<?php include('templates/header.php'); ?>

<div class="container">

<h5 class="center">EDIT:</h5>
<form action="index.php" method="GET">
    <input type="hidden" name="id_to_update" value="<?php echo $pizza['id']; ?>">
    <input type="text" name="title" value="<?php echo $pizza['title']; ?>">
    <input type="text" name="email" value="<?php echo $pizza['email']; ?>">
    <input type="text" name="ingredients" value="<?php echo $pizza['ingredients']; ?>">
    <input type="submit" name="update" value="Update">

</form>
</div>

<?php include('templates/footer.php'); ?>
    <!-- end tag for body in footer! -->

</html>