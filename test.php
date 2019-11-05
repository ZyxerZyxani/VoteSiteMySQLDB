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
$frslagid = $_REQUEST['frslagid']; //Same as above except it is frslagid instead of password
$rst = $_REQUEST['rst']; //Same as above except it is rst instead of frslagid

if (!empty($Username)){ //Checks if username is not empty (variable we requested on line 10)
if (!empty($Password)){ //Checks if password is not empty (variable we requested on line 11)
    
$boll = false; //declares boolean and sets it to false
$result1 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Username = '$Username'"); //Define function to check if username is in DB
$result2 = mysqli_query($conn, "SELECT * FROM Inlogg WHERE Password = '$Password' AND Username = '$Username'"); //Define function to check if password is correct (actually just checks the password on the same line as username matches, if match then true)

     if ((mysqli_num_rows($result1) !=0) && (mysqli_num_rows($result2) !=0)){ //checks if $result1 and $result2 got through before without error (if error then one of them will be empty, so technically I am checking if they are not empty. && means that both statements have to be true)

         $boll = true; //If the if statement is true, change boolean to true
     } 
if ($boll){ //In short checks if boolean boll is true, if you just type in a variable of the type boolean into an if check, then it checks if boolean is true. 

if (!empty($frslagid)){ //! means not, so !empty means not empty: Checks if frslagid is not empty
if (!empty($rst)){//Checks if frslagid is not empty

if (mysqli_connect_error()){
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
    
$result42 = mysqli_query($conn, "SELECT * FROM rstat WHERE user = '$Username' AND frslagid = '$frslagid'"); //Checks database that saves the votes, what the vote was and on what. 

if(mysqli_num_rows($result42) ==0){ //Checks if previous function wasn't assigned a value. If not then person hasn't voted. This line in combination with previous checks if the user has already voted.

$szzz = "INSERT INTO rstat (user, frslagid) values ('$Username','$frslagid')"; //If no value was assigned, then define function to add the user to the dbTable of people that already voted
if ($conn->query($szzz)){ //Tries to add the user to the dbTable of users that have voted
    echo "Vote counted.";}
    
$sql = "INSERT INTO data (frslagid, rst) values ('$frslagid','$rst')"; //define function to insert vote into dbTable of votes
if ($conn->query($sql)){//Tries to add vote and proposalID to the dbTable of votes
    echo "New record is inserted sucessfully.";
    
    $result = mysqli_query($conn,"SELECT * FROM data");//Add function to go through data table (table containing votes and proposalIDs)

    echo "<table border='1'>//Echoes HTML code in order to create a table
    <tr>
    <th>FörslagID</th>
    <th>Röst</th>
    </tr>";

    while($row = mysqli_fetch_array($result))//loop to echo back all votes and corresponding proposalID in a table
    {
    echo "<tr>";
    echo "<td>" . $row['frslagid'] . "</td>";
    echo "<td>" . $row['rst'] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
    
}

else{
    echo "Error: ". $sql ." ". $conn->error;
}

}

else{ //If user is in the table the user has already voted and is denied voting a second time (that we check on row 39, this is where that if ends and the else begins)
    echo "You have already cast your vote on this frslagid!";
}

$count = mysqli_query($conn, "SELECT COUNT(*) FROM Inlogg");//Counts amount of users

$fnum = mysqli_query($conn, "SELECT frslagid FROM data WHERE frslagid = '$frslagid'"); 

$vcount = mysqli_query($conn, "SELECT * FROM data WHERE frslagid = '$frslagid'");

if ($fnum >= $count){//Checks if amount of users is less than 
    echo "votes for this frslagid is done! $frslagid and the result is:"; 
    $qtyzz= 0;
    while ($numzz = mysqli_fetch_assoc ($vcount)) {
    $qtyzz += $numzz['rst'];
    }
echo $qtyzz;
    
}
else{
    echo "more votes needed!";
}

$conn->close();
}
}
else{
echo "Röst should not be empty";
die();
}
}
else{
echo "FörslagID should not be empty";
die();
}}
else{ echo "Username or Password is incorrect.";
die();}}
else {echo 'Password is empty.';
die();}}
else {echo "Username is empty.";
die();}
?>
