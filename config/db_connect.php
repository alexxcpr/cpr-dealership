<?php 
//conectare la baza de date
$conn = mysqli_connect('localhost', 'alex', 'Parola123', 'dealership');

//verificare conexiune
if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
}

?>