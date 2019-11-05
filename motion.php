<?php

$motion = $_REQUEST['motion'];
if (!empty($motion)){
$host = "localhost"; // Usually localhost, it is the host for your MySQL DB
$dbusername = "cPanelMySQL_user"; //Varies and can be tricky/confusing. If you use cPanel then you add the Panel name or such and then underscore username of DB user. See field for example
$dbpassword = "users Password"; //Password of the MySQLdb user
$dbname = "cPanelMySQL_DBname"; //Name of the database you want to access/connect to
// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname); //Define a function to connect to the database so that $conn can be written instead of new mysqli ($host, $dbusername, $dbpassword, $dbname)

if (mysqli_connect_error()){//tests if connection to MySQLdb can be established, if not error is spat out
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
$sql = "INSERT INTO motion (motioner) values ('$motion')"; //define function to insert data into db
if ($conn->query($sql)){//tests if data motioner is inserted into BD
    echo "New record inserted sucessfully."; 
    $result = mysqli_query($conn,"SELECT * FROM motion");

    echo "<table border='1'> //echoes html code 
    <tr>
    <th>Motioner</th>
    </tr>";

$sqlz = "SELECT * FROM motion";
$resultz = mysqli_query($conn, $sqlz); 
echo "<br>";
echo "<table border='1'>";
while ($row = mysqli_fetch_assoc($resultz)) { 
    echo "<tr>";
    foreach ($row as $field => $value) { 
        echo "<td>" . $value . "</td>"; 
    }
    echo "</tr>";
}
echo "</table>";

}
$conn->close();
}

}
else{
echo "Motion should not be empty";
die();
}

?>