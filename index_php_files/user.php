<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == "user"){
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
            
            <!-- <link rel="stylesheet" href="../Assets/CSS/index.css" type="text/css"> -->
        </head>

        <body>
    <div class="row">
        <div class="col-6">
            <h1>Administrative Portal</h1>
            <h2>Patient Information and Appointment Submission</h2>
            <form method="post">
                First name:<br>
                <input type="text" name="fn">
                <br>
                Last name:<br>
                <input type="text" name="ln" >
                <br>
                Phone number:<br>
                <input type="text" name="phone" >
                <br>
                Email:<br>
                <input type="text" name="email">
                <br>
                Appointment: <br>
                <input type="date" name="appointment">
                <br><br>
                <input type="submit" value="Submit" name='submit_appointment'>
            </form> 
        </div>

        <div class="col-6">
            <h2>Create Patient Account</h2>
            <form method="post">
                Email:<br>
                <input type="text" name="email">
                <br><br>
                Password:<br>
                <input type="text" name="password">
                <input type="submit" value="Submit" name='add_patient'>
                <br>
            </form> 
        </div> 
    </div>
    <br>
    <div class="bottomPage">
    <h2>List Appointments</h2>  
            <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Date</th>
                        <th scope="col">From (Time)</th>
                        <th scope="col">To (Time)</th>
                        <th scope="col">Treatment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                    </table>

    </div>

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

                if(isset($_POST['search_appointment'])){ 
                    $email = $_POST['email'];

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
                }

                if(isset($_POST['add_patient'])){ 
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $submit_query = "INSERT INTO patient_credentials(email,password) VALUES('$email','$password')";
                    $submit_result = mysqli_query($mysql, $submit_query);
                }
            ?>
        
        </body>

        </html>
<?php
    }else{
        session_destroy(); //clears all login information
        header("Location:index.php");
    }
?>

