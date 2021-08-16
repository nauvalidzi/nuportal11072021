<?php
// Create connection
 //$con=mysqli_connect("198.38.82.92","earsip_admin","4dm1nsaja","earsip_kediri");
 $con=mysqli_connect("156.67.212.200","u5949760","4dmin2021","u5949760_backend");
 // $con=mysqli_connect("localhost","root","","nuportal");

// Check connection
 if (mysqli_connect_errno($con))
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
 ?>