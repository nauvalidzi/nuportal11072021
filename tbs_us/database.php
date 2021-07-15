<?php
// Create connection
 //$con=mysqli_connect("198.38.82.92","earsip_admin","4dm1nsaja","earsip_kediri");
 $con=mysqli_connect("ls-b9e992bc52faba574fd15397e7880de17f555d47.cpe3c4hmmuxu.us-east-2.rds.amazonaws.com","root","Jombang74","nuportal_juli21");

// Check connection
 if (mysqli_connect_errno($con))
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
 ?>