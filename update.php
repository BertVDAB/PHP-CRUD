<?php 

include('config/db_connect.php');

    // EMPTY ARRAY TO FILL WITH ERROR MESSAGES TO OUTPUT AS ONE!!!
    $errors = array('email' => '', 'title' => '', 'ingredients' => '');

    $email = '';
    $title = '';
    $ingredients = '';

	if(isset($_POST['update'])){
		// echo htmlspecialchars($_POST['email']);
		// echo htmlspecialchars($_POST['title']);
		// echo htmlspecialchars($_POST['ingredients']);

        // check email, title, ingredients
        // use regex!!!!!

        //EMAIL

        if(empty($_POST['email'])){
            $errors['email'] = 'Email is required'. '<br/>';
            
        } else{
            // echo htmlspecialchars($_POST['email']). '<br/>';
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] =  'Email must be a valid email address'. '<br/>';
            }
        }

        //TITLE

        if(empty($_POST['title'])){
            $errors['title'] = 'Title is required'. '<br/>';
            
        } else{
            // echo htmlspecialchars($_POST['title']). '<br/>';
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] =  'Title must be letters and spaces only'. '<br/>';
            }
        }

        // INGREDIENTS

        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'Ingredients is required'. '<br/>';
            
        } else{
            // echo htmlspecialchars($_POST['ingredients']);
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] =  'Ingredients must be a comma seperated list'. '<br/>';
            }
        }

        if(array_filter($errors)){
            // echo 'errors';
        } else{
            // echo 'SUCCESS';
            // header('Location: index.php');

            // double check for SQL injection (real escape string)
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
        }

    }// check GET request id

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

    

    // print_r($pizza);
}

if(isset($_POST['update'])){
    // escape sql chars
    echo "update knop working";
    $id_to_update = mysqli_real_escape_string($conn, $_POST['id_to_update']);

    // sql to update pizza from database
    $sql = "UPDATE pizzas SET title = '$_POST[title]', email = '$_POST[email]', ingredients = '$_POST[ingredients]' WHERE id = $id_to_update";

    // save to database and check
    if(mysqli_query($conn, $sql)){
        // succesfull
        header('Location: index.php');
    }else{
        // failed and error!
        echo 'query error: ' . mysqli_error($conn);
    }

    //close database connection
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
    
<!-- start tag for head and body in header! -->

<?php include('templates/header.php'); ?>

<div class="container">

<!-- <form action="update.php?id=<?php echo $pizza['id']; ?>" method="POST">
    
    <input type="text" name="title" value="<?php echo $pizza['title']; ?>">
    <input type="text" name="email" value="<?php echo $pizza['email']; ?>">
    <input type="text" name="ingredients" value="<?php echo $pizza['ingredients']; ?>">
    <input type="submit" name="update" value="Update">

</form> -->
</div>

<section class="container grey-text">
		<h4 class="center">Update:</h4>
        <?php if($pizza) : ?>
		<form class="white" action="update.php" method="POST">

        <input type="hidden" name="id_to_update" value="<?php echo $pizza['id']; ?>">
			
			<label>Pizza Title</label> 
			<input type="text" name="title" value="<?php echo htmlspecialchars($pizza['title']); ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>

            <label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($pizza['email']); ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>

			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars( $pizza['ingredients']); ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="update" value="Update" class="btn brand z-depth-0">
			</div>
		</form>
        <?php else: ?>
            <h1 class="center">Pizza not found!</h1>
        <?php endif; ?>
	</section>

<?php include('templates/footer.php'); ?>
    <!-- end tag for body in footer! -->

</html>