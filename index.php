<?php
    include ('config/db_connect.php');

    $sortBy = (isset($_GET['sortBy']) ? $_GET['sortBy'] : 'model');
    $setorder = (isset($_GET['setorder']) ? $_GET['setorder'] : 'up');
    
    //scriere query pentru toate modelele
    $sql = 'SELECT id, model, year, km, price, email, origin_country FROM models';

    //sistem sort by
    if($sortBy != ""){
        $sql .= ' ORDER BY ' . $sortBy;
        if($setorder == 'up'){
            $order = 'ASC';
            $sql .= ' ' .$order;
        }
        else if($setorder == 'down'){
            $order = 'DESC';
            $sql .= ' ' . $order;
        }
    }

    //make query and get result
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //transforma rezultatul intr-un array ce se poate citi
    $models = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //eliberam memoria din variabila
    mysqli_free_result($result);

    //inchidem conexiunea
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

    <?php include ('templates/header.php');?>

    <h4 class="center darkgrey">Car models</h4>
    <h6 class="center darkgrey">Order by:</h6>

    <div class="container center">
        <a class="btn" href="index.php?sortBy=model&setorder=up">Model ASC</a>
        <a class="btn" href="index.php?sortBy=model&setorder=down">Model DESC</a>
        <a class="btn" href="index.php?sortBy=year&setorder=up">Year ASC</a>
        <a class="btn" href="index.php?sortBy=year&setorder=down">Year DESC</a>
        <a class="btn" href="index.php?sortBy=price&setorder=up">Price ASC</a>
        <a class="btn" href="index.php?sortBy=price&setorder=down">Price DESC</a>
        <a class="btn" href="index.php?sortBy=km&setorder=up">Km ASC</a>
        <a class="btn" href="index.php?sortBy=km&setorder=down">Km DESC</a>
    </div>

   <div class="container">
    <div class="row">

    <?php foreach($models as $model): ?>

        <div class="col s6 md3">
            <div class="card z-depth-0 bckcolor">
                <img src="images/car2.png" class="car_img" alt="car_img">
                <div class="card-content center">
                    <h6><strong><?php echo htmlspecialchars($model['model']); ?></strong></h6>
                    <div class=""><?php echo htmlspecialchars(number_format($model['price'])); ?> €</div>
                </div>
                <a href="details.php?id=<?php echo $model['id'] ?>">
                    <div class="card-action center-align">
                        <h6 class="brand-text"><strong>MORE INFO</strong></h6>
                    </div>
                </a>
            </div>
        </div>

    <?php endforeach; ?>
    </div>
   </div>

    <?php include ('templates/footer.php');?>

</html>