<?php
    session_start();
    // if(isset($_SESSION['login']) && $_SESSION['login'] == "doctor"){
        require_once('../assets/php/connection.php'); 
        $chart_search = "SELECT appointment, count(*) as number FROM appointment GROUP BY email";
        // $chart_search = "SELECT COUNT(email)  FROM appointment";

        $chart = mysqli_query($mysql, $chart_search);
?>
<!DOCTYPE html>  
 <html>  
      <head>  
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
            <script>
                google.charts.load('current',{'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart(){
                    var data = google.visualization.arrayToDataTable([  
                            ['Appointment', 'Count'],  
                            ['Appointment', '
                                <?php  
                                    while($row = mysqli_fetch_array($chart)) {
                                        $email = $row['number'];
                                        echo $email;
                                        // "['".$email."', '1'],";  
                                    }  
                                ?> ']
                        ]);  
                    var options = {  
                        title: 'Test Chart',  
                        //is3D:true,  
                        pieHole: 0.4  
                        };  
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                    chart.draw(data, options); 
                }
            </script>
        </head>    
        <body>  
           <div style="width:900px;">  
                <h3>Make Simple Pie Chart by Google Chart API with PHP Mysql</h3>  
                <div id="piechart" style="width: 900px; height: 500px;"></div>  
           </div>  
      </body>  
 </html>  