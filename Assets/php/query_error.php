
<?php
    //checks if query ran successfully
    if (mysqli_affected_rows($mysql) != 1){ 
        echo "<script type='text/javascript'>alert('Error: patient/appointment already exists.');</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('Success');</script>";
    }
?>