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
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname); //Define a function to connect to the database so that $conn can be written instead of new mysqli ($host, $dbusername, $dbpassword, $dbname)

$Username = $_REQUEST['Username']; //Gives the variable $Username the same value as what was inserted in the HTML field Username. See it as $_REQUEST asks for whatever variable comes inside ['']
$Password = $_REQUEST['Password']; //Same as above except it is password instead of username

$boll = false; //Set a boolean to the value false
$result1 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Username = '$Username'"); //Check if the username exists in DB, saves it in variable $result1
$result2 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Password = '$Password' AND Username = '$Username'"); //Checks if username and password exists on same line in DB (otherwise any password can be used on any user), saves in $result2

     if ((mysqli_num_rows($result1) !=0) && (mysqli_num_rows($result2) !=0)){ //checks if $result1 and $result2 are not empty. If either is empty then either username or password is incorrect

         $boll = true; //If $result1 and $result2 are not empty change boolean ($boll) to true
     } 
if ($boll){ //checks if $boll is true (if you test a boolean in if, it returns the booleans value, so if boolean is set to true the if becomes true)

if (mysqli_connect_error()){ //tests if connection to MySQLdb can be established, if not error is spat out
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
    
    $result3 = mysqli_query($conn, "SELECT * FROM Delegater WHERE Delegat = '$Username'"); //Define function to check if user is in MySQLdb list of delegates
    
    if (mysqli_num_rows($result3) !=0){ //Tests if user is in list of delegates
    $sql1 = "DELETE FROM Delegater WHERE Delegat = '$Username'"; //Defines funciton to delete the user from the list of delegates
    if ($conn->query($sql1) === TRUE) {//Tests if it can connect to MySQLdb and delete the user from list of delegates
    echo "Record deleted successfully"; //Note: All echoes in php is sending whatever is in the echo to the HTML, and the HTML interprets it as if it was HTML
} else {
    echo "Error deleting record: " . $conn->error;//Gives error if it couldn't connect or delete user from db (most likely connection error since we tested earlier if the user is in db)
}
    }
    
    else{//if user is not in list of delegates this is done
$sql2 = "INSERT INTO Delegater (Delegat) VALUES ('$Username')"; //Define function to add
if ($conn->query($sql2) === TRUE) {//Tries to add user to list of delegates and checks if successfully done
    echo "Record inserted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
    }





$sqlz = "SELECT * FROM Delegater";
$resultz = mysqli_query($conn, $sqlz); 
echo "<br>";
echo "<form action='valdel.php' method='post'>"; //sends html code (making a HTML form that runs valdel.php when submit button is pressed) 
echo" <input type='text' name='Username' placeholder='Username'>
 <input type='text' name='Password' placeholder='Password'>
 <select name='del'>";
while ($row = mysqli_fetch_assoc($resultz)) { 
    foreach ($row as $field => $value) { //Loop, checks database for delegates and puts them in drop down list so you can pick one
    echo "<option value='" . $value . "'>" . $value . "</option>";
    }
}
echo "<input type='submit' name='submit' value='Choose delegate.' />";
echo "</select></form>";



$conn->close();
}
}

else {echo 'Something is wrong.';
die();}
?>
