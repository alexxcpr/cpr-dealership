<?php
include ('config/db_connect.php');

$email=$model=$year=$km=$ocountry=$price='';
$errors = array('email'=>'', 'model'=>'', 'year'=>'', 'km'=>'', 'ocountry'=>'', 'price'=>'');

 if(isset($_POST['submit'])){

    //Verificare email
    if(empty($_POST['email'])){
        $errors['email'] = 'The Email is required <br>';
    } else {
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'EMAIL ERROR:The Email must be a valid email address!<br>';
        }
    }

    //verificare model
    if(empty($_POST['model'])){
        $errors['model'] = 'The model of the car is required <br>';
    } else {
        $model = $_POST['model'];
        if (!preg_match('/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/', $model)) {
            $errors['model'] = 'model CAR ERROR:There must be letters, numbers and spaces only!!<br>';
        }
    }
    // ^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$ - verificare regex pentru a avea doar litere, cifre si spatii in campul introdus

    //verificare year
    if(empty($_POST['year'])){
        $errors['year'] = 'The fabrication year is required <br>';
    } else {
        $year = $_POST['year'];
        if (!preg_match('/^\d{4}$/', $year)){
            $errors['year'] = 'YEAR ERROR:There must be 4 digits<br>';
        }
    }
    // ^\d{4}$ - verificare regex pentru 4 cifre

    //verificare km
    if(empty($_POST['km'])){
        $errors['km'] = 'The kilometers of the car is required <br>';
    } else {
        $km = $_POST['km'];
        if(!preg_match('/^[0-9]*$/',$km)){
            $errors['km'] = "KM ERROR: Km can't contain any letter or special character(just numbers).<br>";
        }
    }

    //verificare ocountry
    if(empty($_POST['ocountry'])){
        $errors['ocountry'] = 'The origin country of the car is required <br>';
    } else {
        $ocountry = $_POST['ocountry'];
        if(!preg_match('/^[a-zA-Z\s]+$/',$ocountry)){
            $errors['ocountry'] = "ORIGIN COUNTRY ERROR:Origin Country should only contains letters and spaces.<br>";
        }
    }

    //verificare price
    if(empty($_POST['price'])){
        $errors['price'] = 'The price is required <br>';
    } else {
        $price = $_POST['price'];
        if(!preg_match('/^[0-9]*$/',$price)){
            $errors['price'] = "PRICE ERROR: Price must be numeric value without decimal point.<br>";
        }
    }

    if(array_filter($errors)){
        //erori in form
    } else {
        //verificam datele sa nu aiba limbaj sql premeditat in el(sql injection)
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);
        $km = mysqli_real_escape_string($conn, $_POST['km']);
        $ocountry = mysqli_real_escape_string($conn, $_POST['ocountry']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);

        //cream sql de injectare in baza de date
        $sql = "INSERT INTO models(model,year,km,price,email,origin_country) VALUES('$model', '$year', '$km', '$price', '$email', '$ocountry')";

        //salvam in baza de date si verificam
        if(mysqli_query($conn, $sql)){
            //succes
            header('Location: index.php');
        } else {
            //error
            echo 'QUERRY ERROR: ' .  mysqli_error($conn);
        }
        
    }
 }  // Sfarsitul verificarii pentru metoda POST
?>

<!DOCTYPE html>
<html lang="en">

    <?php include ('templates/header.php');?>

    <!--Formularul de introducere a datelor in baza de date a modelelor de masini-->
    <section class="container grey-text">
        <h4 class="center">Add a car</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text"><?php echo $errors['email'];?></div>
            <label>Car Model:</label>
            <input type="text" name="model" value="<?php echo htmlspecialchars($model) ?>">
            <div class="red-text"><?php echo $errors['model'];?></div>
            <label>Car Year:</label>
            <input type="text" name="year" value="<?php echo htmlspecialchars($year) ?>">
            <div class="red-text"><?php echo $errors['year'];?></div>
            <label>Car KM's:</label>
            <input type="text" name="km" value="<?php echo htmlspecialchars($km) ?>">
            <div class="red-text"><?php echo $errors['km'];?></div>
            <label>Car's Origin Country:</label>
            <input type="text" name="ocountry" value="<?php echo htmlspecialchars($ocountry) ?>">
            <div class="red-text"><?php echo $errors['ocountry'];?></div>
            <label>Price:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($price) ?>">
            <div class="red-text"><?php echo $errors['price'];?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include ('templates/footer.php');?>

</html>

