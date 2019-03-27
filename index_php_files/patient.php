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
                
                if(isset($_POST['submit_appointment'])){ 

                    // the message
                    $msg = "Test";

                    // use wordwrap() if lines are longer than 70 characters
                    // $msg = wordwrap($msg,70);

                    // send emails
                    mail("bctcproject@gmail.com","Appointment",$msg);
                    
                    $appointment = $_POST['appointment'];

                    $submit_query = "INSERT INTO appointment(fn,ln,phone,email,appointment) VALUES('$fn','$ln','$phone','$email','$appointment')";
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

