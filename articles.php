<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php 
        include('header.php'); 
        include('navigator.php'); 
        ?> 
</head>
<body>
<div class='main-content'>
<h2>Article Database</h2>
<?php
// list of manuscripts in database

//connect to database
$dbname = "ees"; 
$ip = getenv('IP'); 
$user = getenv('C9_USER');
$mysqli = new mysqli($ip, $user, "", $dbname, 3306); 
if ($mysqli->connect_errno) { 
echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error; 
}

$query = "SELECT * FROM citation";
$result = $mysqli->query($query) or die("dead");

?>

<table>
    <tr>
        <th>Title</th>
        <th>Authors</th>
        <th>Journal</th>
        <th>Year</th>
        <th>Volume</th>
        <th>Pages</th>
    </tr>
<?php

while($row = $result->fetch_array())
{
    $journal = $row['journal'];
    switch($journal){
        case 'EM': 
            $journal = 'Journal of Environmental Monitoring';
        break;
        case 'EE': 
            $journal = 'Energy and Environmental Science';
        break;
        case 'CP': 
            $journal = 'Physical Chemistry Chemical Physics';
        break;
        case 'NR': 
            $journal = 'Nanoscale';
        break;
        default:
            $journal = 'none';
        break;
    };
    echo "
    <tr>
        <td>".$row['title']."</td>
        <td>".$row['authors']."</td>
        <td>".$journal."</td>
        <td>".$row['year']."</td>
        <td>".$row['volume']."</td>
        <td>".$row['pages']."</td>
    </tr>";    
}


?>

</table>
<div class='submitDiv'>
    <input type="submit" value="Go Back From Whence You Came!" onclick="history.back(-1)" />
</div>
</div>
</body>
</html>