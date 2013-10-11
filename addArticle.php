<?php


$dbname = "ees"; 
$ip = getenv('IP'); 
$user = getenv('C9_USER'); 
$mysqli = new mysqli($ip, $user, "", $dbname, 3306); 
if ($mysqli->connect_errno) { 
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error; 
}

$title = $mysqli->real_escape_string($_POST['title']);
$authors = $mysqli->real_escape_string($_POST['authors']);
$year = $mysqli->real_escape_string($_POST['year']);
$journal = $mysqli->real_escape_string($_POST['journal']);
$volume = $mysqli->real_escape_string($_POST['volume']);
$pages = $mysqli->real_escape_string($_POST['pages']);
/*
$title = $_POST['title'];
$authors = $_POST['authors'];
$year = $_POST['year'];
$journal = $_POST['journal'];
$volume = $_POST['volume'];
$pages = $_POST['pages'];
*/
 
// need the switch statement because I had set the DB up to just accept the two letter code. 
// Would probably be simpler posting the two letter code so we can delete the switch.
switch($journal){
        case 'Journal of Environmental Monitoring': 
            $journal = 'EM';
        break;
        case 'Energy and Environmental Science': 
            $journal = 'EE';
        break;
        case 'Physical Chemistry Chemical Physics': 
            $journal = 'CP';
        break;
        case 'Nanoscale': 
            $journal = 'NR';
        break;
        default:
            $journal = 'none';
        break;
    };

$query = "INSERT INTO citation (title,authors,journal,year,volume,pages) 
            VALUES ('$title','$authors','$journal','$year','$volume','$pages')";
$result = $mysqli->query($query);
echo $mysqli->error;
/*
if ($result = $mysqli->query("INSERT INTO citation (title,authors,journal,year,volume,pages) 
            VALUES ('$title','$authors',$journal','$year','$volume','$pages')")) {
   echo 'The ID is: '.$mysqli->insert_id;
}else{
    echo "didn't work";
}*/

echo("Title: ".$title."<br/>");
echo("Authors: ".$authors."<br/>");
echo("Journal: ".$journal."<br/>");
echo("Year: ".$year."<br/>");
echo("Volume: ".$volume."<br/>");
echo("Pages: ".$pages."<br/>");
?>