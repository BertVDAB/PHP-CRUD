<?php 
   include('config/db_connect.php');

    // querys for all pizzas

    $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

    // execute query and store result

    $result = MySQLi_query($conn, $sql);

    // results to ASSOCIATED array

    $pizzas = MySQLi_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    // close connection to database

    mysqli_close($conn);


    // print as readable

    // print_r($pizzas)


    //make new array from pizza ingredients
    // print_r(explode(', ', $pizzas[0]['ingredients']));

    // ipv {} in different php tags => : to open, endforeach; to close

?>

<!DOCTYPE html>
<html>
	<!-- start tag for body in header! -->
	<?php include('templates/header.php'); ?>

    <h4 class="center grey-text">Pizzas</h4>
    <div class="container">
        <div class="row">
            <?php foreach($pizzas as $pizza): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']) ?></h6>
                            <ul>
                                <?php foreach(explode(', ', $pizza['ingredients']) as $ingredient) : ?>
                                    <li><?php echo htmlspecialchars($ingredient) ?></li>
                                    <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?id=<?php echo $pizza['id'] ?>">More Info</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if(count($pizzas) == 0) : ?>
                    <h5>No pizzas found</h5>
                <?php endif ?>
        </div>
    </div>

	<?php include('templates/footer.php'); ?>
    <!-- end tag for body in footer! -->

</html>