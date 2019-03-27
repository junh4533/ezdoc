<?php
    // session_start();
    // if(isset($_SESSION['login']) && $_SESSION['login'] == "patient"){
        require_once('../assets/php/connection.php'); 
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <title>User</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
            
            <link rel="stylesheet" href="../Assets/CSS/user.css" type="text/css">
        </head>
        <body>
        <div id='navbar'>
        <h1 style="color:white">Patient Portal</h1>
        </div>
        <!-- <h4>Welcome back,
        
          For verification purposes, kindly re-enter the fields below and select a date and time to visit our office</h4>
          <br> -->
          <div class="sidenav">
          <h5>Hour Of Operations</h4>
                <ul>
                <li>Mon:<br> 10AM - 6PM</li>
                <li>Tue to Fri:<br> 9AM - 5PM</li>
                <li>Weekends Close</li>
                </ul>  
          </div>
            <form method="post">
                <div class="form-group">
                First name:<br>
                <input type="text" name="$fn">
                </div>
                Last name:<br>
                <input type="text" name="ln" >
                </div>
                Phone number:<br>
                <input type="text" name="phone" >
                </div>
                Email:<br>
                <input type="text" name="email">
                </div>
                Appointment: <br>
                <input type="datetime-local" name="appointment">
                <br><br>
                <input type="submit" value="Submit" name='submit_appointment'>
            </form>
            <br><br> 
            <br><br>
            <h2>Your Appointments</h2>
            <br>
            <?php
                
                if(isset($_POST['submit_appointment'])){ 
                    $fn = $_POST['fn'];
                    $ln = $_POST['fn'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $appointment = $_POST['appointment'];

                    $submit_query = "INSERT INTO appointment(fn,ln,phone,email,appointment) VALUES('$fn','$ln','$phone','$email','$appointment')";
                    $submit_result = mysqli_query($mysql, $submit_query);
                }

                $email = $_SESSION['username'];
                $search_query = "SELECT * FROM appointment WHERE email='$email'";
                $submit_result = mysqli_query($mysql, $search_query);

                while($appointment_row = mysqli_fetch_assoc($submit_result)){
                    $fn = $appointment_row['fn'];
                    $ln = $appointment_row['ln'];
                    $phone = $appointment_row['phone'];
                    $email = $appointment_row['email'];
                    $appointment = $appointment_row['appointment'];
                
                    echo " First name: " . $fn;
                    echo " Last name: " . $ln;
                    echo " Phone: " . $phone;
                    echo " Email: " . $email;
                    echo " Appointment: " . $appointment;
                    echo "<br>";
                }
                
            ?>

        </body>

        </html>
<?php
    // }else{
    //     session_destroy(); //clears all login information
    //     header("Location:index.php");
    // }
?>

