<?php
// Create connection
 //$con=mysqli_connect("198.38.82.92","earsip_admin","4dm1nsaja","earsip_kediri");
 // $con=mysqli_connect("ls-faa4a2656edc82c3f2ac28f451e2d48ca317d20a.cpe3c4hmmuxu.us-east-2.rds.amazonaws.com","dbmasteruser","Jombang74","nuportal");
 $con=mysqli_connect("localhost","root","","nuportal");

// Check connection
 if (mysqli_connect_errno($con))
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
 ?>