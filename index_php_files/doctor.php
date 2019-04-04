<?php
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == "doctor"){
        require_once('../assets/php/connection.php'); 
        $chart_search = "SELECT appointment, count(*) as number FROM appointment GROUP BY WEEKDAY(appointment)";
        $chart_search = "SELECT appointment, 
            count(case when WEEKDAY(appointment)=0 THEN appointment END) as MON, 
            count(case when WEEKDAY(appointment)=1 THEN appointment END) as TUE, 
            count(case when WEEKDAY(appointment)=2 THEN appointment END) as WED, 
            count(case when WEEKDAY(appointment)=3 THEN appointment END) as THU, 
            count(case when WEEKDAY(appointment)=4 THEN appointment END) as FRI, 
            count(case when WEEKDAY(appointment)=5 THEN appointment END) as SAT,
            count(case when WEEKDAY(appointment)=6 THEN appointment END) as SUN
        FROM appointment 
        WHERE appointment BETWEEN (SELECT date(curdate() - interval weekday(curdate()) day)) AND (select adddate(now(), INTERVAL 6-weekday(now()) DAY))
        GROUP BY WEEKDAY(appointment)";
        $chart = mysqli_query($mysql, $chart_search);
        // $weekday = "WEEKDAY($chart_search)";
        // $weekday_query = mysqli_query($mysql, $weekday );
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
            <script>
                google.charts.load('current',{'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart(){
                    var data = google.visualization.arrayToDataTable([  
                            ['Weekday', 'Appointment'],  
                            <?php  
                            while($row = mysqli_fetch_array($chart))  
                            {  
                                echo "['Monday',".$row["MON"]."],";
                                echo "['Tuesday',".$row["TUE"]."],";
                                echo "['Wednesday',".$row["WED"]."],";
                                echo "['Thursday',".$row["THU"]."],";
                                echo "['Friday',".$row["FRI"]."],";
                                echo "['Saturday',".$row["SAT"]."],";
                                echo "['Sunday',".$row["SUN"]."],";
                            }  
                            ?>  
                        ]);  
                    var options = {  
                        title: 'Weekly Appointments',  
                        //is3D:true,  
                        pieHole: 0.4  
                        };  
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                    chart.draw(data, options); 
                }
            </script>
        </head>    
        <body>  
        <div id='navbar'>
            <h1 style="color:white">Doctor Portal</h1>
        </div>
           <div style="width:900px;">  
                <div id="piechart" style="width: 900px; height: 500px;"></div>
    </html>
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

