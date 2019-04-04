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
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            
            <link rel="stylesheet" href="../assets/CSS/user.css" type="text/css">
        </head>

        <body>
        <div id='navbar'>
            <h1 style="color:white">Administrative Portal</h1>
        </div>
     
    <div class="row">
        <div class="col-6">
        <br>
            <h2>Create Patient Account</h2>
<form method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary" value="Submit" name='add_patient'>Submit</button>
  </form>
        </div> 

        <div class="col-6">
        
            <h2 >Create an Appointment</h2>

            <form method="post">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" class="form-control" name="fn" required>
                </div>
                <div class="form-group">
                    <label>Last name:</label>
                    <input type="text" class="form-control"  name="ln" required>
                </div>
                <div class="form-group">
                    <label>Phone number:</label>
                    <input type="text" class="form-control"  name="phone" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Appointment:</label>
                    <input type="datetime-local" class="form-control" name="appointment" required>
                </div>
                <button type="submit" class="btn btn-primary" name='submit_appointment'>Submit</button>
            </form>
            <br>
        </div>

      
    </div>
    <br>

    <div class="bottomPage">
    <div id="appointment_section">
        <h2 style="color:white">Today's Appointments</h2>  
    </div>
    
        <table class="table table-dark table-hover" id="appointment_table">
            <thead>
                <tr>
                    <th>Timeslot</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

            <?php
                $search_query = "SELECT * FROM appointment WHERE appointment > CURRENT_TIMESTAMP ORDER BY appointment ASC";
                $submit_result = mysqli_query($mysql, $search_query);

                while($appointment_row = mysqli_fetch_assoc($submit_result)){
                    $appointment = $appointment_row['appointment'];
                    $fn = $appointment_row['fn'];
                    $ln = $appointment_row['ln'];
                    $phone = $appointment_row['phone'];
                    $email = $appointment_row['email'];
            ?>
                    <script> 
                        var table = document.getElementById("appointment_table");
                        var row = table.insertRow();

                        var time_cell = row.insertCell(0);
                        var fn_cell = row.insertCell(1);
                        var ln_cell = row.insertCell(2);
                        var phone_cell = row.insertCell(3);
                        var email_cell = row.insertCell(4);

                        time_cell.innerHTML = "<?php echo $appointment ?>";
                        fn_cell.innerHTML = "<?php echo $fn ?>";
                        ln_cell.innerHTML = "<?php echo $ln ?>";
                        phone_cell.innerHTML = "<?php echo $phone ?>";
                        email_cell.innerHTML = "<?php echo $email ?>";                      
                    </script>
            <?php         
                }

                if(isset($_POST['submit_appointment'])){ 
                    $fn = $_POST['fn'];
                    $ln = $_POST['fn'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $appointment = $_POST['appointment'];

                    $submit_query = "INSERT INTO appointment(fn,ln,phone,email,appointment) VALUES('$fn','$ln','$phone','$email','$appointment')";
                    $submit_result = mysqli_query($mysql, $submit_query);
                    
                    require_once('../assets/php/query_error.php');
                }

                if(isset($_POST['add_patient'])){ 
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $submit_query = "INSERT INTO patient_credentials(email,password) VALUES('$email','$password')";
                    $submit_result = mysqli_query($mysql, $submit_query);

                    require_once('../assets/php/query_error.php');
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

