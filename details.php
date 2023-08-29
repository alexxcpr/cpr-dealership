<?php 

include('config/db_connect.php');

if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql= "DELETE FROM models WHERE id = $id_to_delete";

    if(mysqli_query($conn,$sql)){
        //succes
        header('Location: index.php');
    } else {
        //error
        echo 'QUERY ERROR ' . mysqli_error($conn);
    }
}


//verificarea parametrului de la GET request
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,$_GET['id']);

    //make sql
    $sql="SELECT * FROM models WHERE id = $id";

    //get query results
    $result = mysqli_query($conn, $sql);

    //fetch results in array
    $model = mysqli_fetch_assoc($result);

    //free the memory
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include ('templates/header.php');?>

<div class="container center darkgrey">
    <?php if($model): ?>
        <h4><?php echo htmlspecialchars($model['model']); ?></h4><br>
        <p>Price: <?php echo htmlspecialchars(number_format($model['price'])); ?>€</p>
        <p>Year of fabrication: <?php echo htmlspecialchars($model['year']); ?></p>
        <p>Kilometers: <?php echo htmlspecialchars(number_format($model['km'])); ?>km</p>
        <p>Origin country: <?php echo htmlspecialchars($model['origin_country']); ?></p>
        <p>Contact: <?php echo htmlspecialchars($model['email']); ?></p>

        <!--DELETE FORM-->
        <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $model['id'] ?>">
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>
        
    <?php else: ?>
        <h5 class="red-text">ERROR:THE CAR YOU ARE LOOKING FOR DOES NOT EXISTS</h5>

    <?php endif; ?>
</div>

<?php include ('templates/footer.php');?>

</html>

