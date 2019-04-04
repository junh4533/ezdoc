<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == "patient"){
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
        <h4>Welcome back, 
            <?php 
                $email = $_SESSION['username'];
                $fn = "";
                $ln = "";
                $phone = "";
                echo $email;
            ?>
        </h4>
            <hr>
            <br>
            <table class="table table-hover" style="width:600px;">
                <thead>
                    <tr>
                        <th><h5>Office Hours</h5></th>
                    </tr>
                </thead>
                <tbody>
                    <td>Monday 10AM - 6PM</td>
                    <td>Tuesday-Friday 9AM - 5PM</td>
                    <td>Weekends Closed</td>
                </tbody>
            </table>

            <br>
            <div id='app_section'>
                <h3 style="color:white">Create an appointment</h3>
            </div>
     
            <form method="post">
                <div class="form-group">
                    <label>Appointment:</label>
                    <input type="datetime-local" class="form-control" name="appointment">
                </div>
                <button type="submit" class="btn btn-primary" name='submit_appointment'>Submit</button>
            </form>
          <br><br>
          <h3>Your Appointments</h3>
            <table class="table table-dark table-hover" id="appointment_table" style="width:600px;">
                <thead>
                    <tr>
                        <th>Timeslot</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

          
            <?php
                $search_query = "SELECT * FROM appointment WHERE email='$email'";
                $submit_result = mysqli_query($mysql, $search_query);

                while($appointment_row = mysqli_fetch_assoc($submit_result)){
                    $appointment = $appointment_row['appointment'];
                    $fn = $appointment_row['fn'];
                    $ln = $appointment_row['ln'];
                    $phone = $appointment_row['phone'];
                    ?>
                    <script> 
                        var table = document.getElementById("appointment_table");
                        var row = table.insertRow();
                        var time_cell = row.insertCell(0);
                        time_cell.innerHTML = "<?php echo $appointment ?>";              
                    </script>
            <?php
                }

                $appointment = $_POST['appointment'];
                if (isset($appointment)){ 
                    $check_email = "SELECT email from patient_credentials WHERE email = '$email'";
                    $search_query = "SELECT appointment FROM appointment WHERE email = '$email' AND appointment = '$appointment'";
                    $submit_result = mysqli_query($mysql, $search_query);
                    //if patient account exists
                    if (mysqli_num_rows(mysqli_query($mysql, $check_email)) > 0){ 
                        //if appointment doesnt already exist
                        if (mysqli_num_rows($submit_result) == 0){ 
                            $submit_query = "INSERT INTO appointment(fn,ln,phone,email,appointment) VALUES('$fn','$ln','$phone','$email','$appointment')";
                            $submit_result = mysqli_query($mysql, $submit_query);
                            
                            $dateTimeSplit = explode("T",$appointment);
                            $date = $dateTimeSplit[0];
                            $time = $dateTimeSplit[1];
                            $date_output = date('M d, Y',strtotime($date));
                            $time_output = " at ".date('h:i:s a',strtotime($time));

                            $message = "EZDoct Appointment scheduled for ".$date_output.$time_output;
                            $headers = "From: EZDoctPortal@gmail.com";
                            $email = 'bctcproject@gmail.com';
                            mail($email, "EZDoct Appointment", $message, $headers);
                        ?>
                            <div class="alert alert-success">
                                Appointment created!
                            </div>
                        <?php
                        }else{
                            ?>
                            <div class="alert alert-danger">
                                Appointment already exists!
                            </div>
                            <?php
                        }
                    }else{
                    ?>
                        <div class="alert alert-danger">
                            There are no registered patients with this email. Please create the patient account before making appointments.
                        </div>
                    <?php
                    }
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

