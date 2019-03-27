<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/index.css">
    <title>Index</title>
    
</head>

<body>
<!-- StockImage Page -->
  <?php 
    if(isset($_POST['submit_login'])){
      require_once('../assets/php/connection.php'); 
      session_start();
      $username = $_POST["username"];
      $password = $_POST["password"];
      $_SESSION['username'] = $_POST["username"];
      $_SESSION['password'] = $_POST["password"];

      //query the database for username and password
      $query_user = "SELECT username FROM credentials WHERE username = '$username' ";
      $query_password = "SELECT password FROM credentials WHERE password = '$password' ";
      $user_result = mysqli_query($mysql, $query_user);
      $password_result = mysqli_query($mysql, $query_password);

      $query_patient = "SELECT email FROM patient_credentials WHERE email = '$username' ";
      $patient_password = "SELECT password FROM patient_credentials WHERE password = '$password' ";
      $patient_result = mysqli_query($mysql, $query_patient);
      $patient_password_result = mysqli_query($mysql, $patient_password);

      $query_doctor = "SELECT email FROM doctor_credentials WHERE email = '$username' ";
      $doctor_password = "SELECT password FROM doctor_credentials WHERE password = '$password' ";
      $doctor_result = mysqli_query($mysql, $query_doctor);
      $doctor_password_result = mysqli_query($mysql, $doctor_password);

      //check if there is a matching result
      if (mysqli_num_rows($password_result)>0 && mysqli_num_rows($user_result)>0) {
        $_SESSION['login'] = "user";
        header("Location:user.php"); //redirect to user page   
      } elseif(mysqli_num_rows($patient_result)>0 && mysqli_num_rows($patient_password_result)>0){
        $_SESSION['login'] = "patient";
        header("Location:patient.php"); //redirect to user page   
      }
      elseif(mysqli_num_rows($doctor_result)>0 && mysqli_num_rows($doctor_password_result)>0){
        $_SESSION['login'] = "doctor";
        header("Location:doctor.php"); //redirect to user page   
      }
       else {
        ?>
        <div class="alert alert-danger" id="failed">
          Incorrect username or password. Please try again.
        </div>
        <?php
      }
    }
  ?> 
  <div class="ImgDiv">
  <img src="../Assets/Images/DoctorIndex.jpg" alt="Doctors">
  </div>    
  <h1 class="text-center">Welcome to EZDoct Patient Scheduling Portal</h1>
      
      <div class="row"> 
        <div class="col-3"></div>
    <div class="col-6">
      <form method="post">
        <div class="form-group">
           <label>PCP ID<br><input type="text" class="form-control" placeholder="Username" name="username" required></label> 
        </div>

        <div class="form-group">
           <label>Password<br><input type="password" class="form-control" placeholder="Password" name="password" required></label>
        </div>
        <div class="form-group">
        <button id="Submit_Button" type="submit" name="submit_login">Sign In</button>
        </div>
      </form>
      </div>
      <div class="col-3"></div>
      </div> 

</body>

</html>
