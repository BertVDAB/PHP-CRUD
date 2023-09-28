<?php

include('config/db_connect.php');

// DELETE CHECK

if(isset($_POST['delete'])){
    // escape sql chars
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    // sql to delete pizza from database
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
    // save to database and check
    if(mysqli_query($conn, $sql)){
        // succesfull
        header('Location: index.php');
    }else{
        // failed and error!
        echo 'query error: ' . mysqli_error($conn);
    }
}

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

?>

<!DOCTYPE html>
<?php include 'templates/header.php'; ?>
<?php if($pizza) : ?>

<h2 class="center">Details:</h2>

<div class="container center">
    <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
    <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
    <!-- <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p> -->
    <p><?php echo date($pizza['created_at']); ?></p>
    <h5>Ingredients</h5>
    <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

    <!-- FORM TO DELETE -->
    <form action="details.php?id=<?php echo $pizza['id']; ?>" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
        <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
    </form>
    <!-- END DELETE  -->

    <!-- FORM TO DELETE -->
    
        <button class="btn brand z-depth-0"><a href="update.php?id=<?php echo $pizza['id']; ?>">Edit</a></button>
    
    <!-- END DELETE  -->
</div>
<?php else: ?>
<h2>Pizza not found!</h2>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>

</html>