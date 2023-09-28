<?php 

     include('config/db_connect.php');

	// if(isset($_GET['submit'])){
	// 	echo $_GET['email'] . '<br />';
	// 	echo $_GET['title'] . '<br />';
	// 	echo $_GET['ingredients'] . '<br />';
	// }


        // EMPTY ARRAY TO FILL WITH ERROR MESSAGES TO OUTPUT AS ONE!!!
    $errors = array('email' => '', 'title' => '', 'ingredients' => '');

    $email = '';
    $title = '';
    $ingredients = '';

	if(isset($_POST['submit'])){
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
                $errors['ingredients'] =  'Ingredients must be a comma seperated list, no numbers or special characters'. '<br/>';
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

            // create sql query

            $sql = "INSERT INTO pizzas (email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";

            // save to database and check

            if(mysqli_query($conn, $sql)){
                // succesfull
                header('Location: index.php');
            }else{
                // failed and error!
                echo 'query error: ' . mysqli_error($conn);
            }
        }

	} // END POST CHECK

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="add.php" method="POST">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Pizza Title</label>
            
			<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Ingredients (comma separated)</label>
            
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars( $ingredients); ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>