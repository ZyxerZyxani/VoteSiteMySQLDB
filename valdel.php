//    Copyright (C) <2019>  <Loke Hagberg & Emilio Müller>
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <https://www.gnu.org/licenses/>.
//
//To contact us please email loke_hagberg@hotmail.com or emilio.muller@e.email
//or send paper mail to 
//
//Grimstagatan 81
//162 57 Vällingby
//Sweden 
<?php
$host = "localhost"; // Usually localhost, it is the host for your MySQL DB
$dbusername = "cPanelMySQL_user"; //Varies and can be tricky/confusing. If you use cPanel then you add the Panel name or such and then underscore username of DB user. See field for example
$dbpassword = "users Password"; //Password of the MySQLdb user
$dbname = "cPanelMySQL_DBname"; //Name of the database you want to access/connect to
// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

$delegat = $_REQUEST['del'];

$Username = $_REQUEST['Username'];
$Password = $_REQUEST['Password'];

$boll = false;
$result1 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Username = '$Username'");
$result2 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Password = '$Password' AND Username = '$Username'");

     if ((mysqli_num_rows($result1) !=0) && (mysqli_num_rows($result2) !=0)){

         $boll = true; 
     } 
     
if ($boll){

$result3 = mysqli_query($conn, "SELECT * FROM valdel WHERE user = '$Username'");
    if (mysqli_num_rows($result3) !=0){
    $sql1 = "DELETE FROM valdel WHERE user = '$Username'"; 
    if ($conn->query($sql1) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
}

 else{
 
$insert = "INSERT INTO valdel (user, degat) VALUES ('$Username','$delegat')";
if ($conn->query($insert)) {
    echo "Record inserted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
 
}
}

else {echo 'Something is wrong.';
die();}

?>