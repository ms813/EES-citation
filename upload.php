<?php 

// Configuration
      //$max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = './files/'; // The place the files will be uploaded to (currently a 'files' directory).
 
   $filename = $_FILES['file']['name']; // Get the name of the file (including file extension).
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
 
//the file type is checked by dropzone.js so dont need to check here
 
   // Now check the filesize, if it is too large then DIE and inform the user.
  // if(filesize($_FILES['file']['tmp_name']) > $max_filesize)
   //   die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   $fileData = file_get_contents($_FILES['file']['tmp_name']);
   $array = explode("<p>",$fileData);
   
   /* ian's effort */
    $fileData = file_get_contents('files/WoK2013EESPapers.html');
    $fileData = str_replace("<br>",";",$fileData);
    $newprop = strip_tags($fileData,"<td>");
    $newprop = str_replace('td valign="top"','td',$newprop);
    $newarray = explode("<td>",$newprop);
   
    $counter = 0;
    $hit = 0;
   
    while($counter < count($newarray)){
        
        // authors - incomplete
        if(trim(str_replace("</td>","",$newarray[$counter])) == "AF")
            $finalArray[$hit]['AF'] = trim(str_replace("</td>","",$newarray[$counter+1]));
                
        // title
        if(trim(str_replace("</td>","",$newarray[$counter])) == "TI")
            $finalArray[$hit]['TI'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // journal
        if(trim(str_replace("</td>","",$newarray[$counter])) == "SO")
            $finalArray[$hit]['SO'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // abstract
        if(trim(str_replace("</td>","",$newarray[$counter])) == "AB")
            $finalArray[$hit]['AB'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // publication year
        if(trim(str_replace("</td>","",$newarray[$counter])) == "PY")
            $finalArray[$hit]['PY'] = trim(str_replace("</td>","",$newarray[$counter+1]));
    
        // volume
        if(trim(str_replace("</td>","",$newarray[$counter])) == "VL")
            $finalArray[$hit]['VL'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // issue
        if(trim(str_replace("</td>","",$newarray[$counter])) == "IS")
            $finalArray[$hit]['IS'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // first page
        if(trim(str_replace("</td>","",$newarray[$counter])) == "BP")
            $finalArray[$hit]['BP'] = trim(str_replace("</td>","",$newarray[$counter+1]));
        
        // last page
        if(trim(str_replace("</td>","",$newarray[$counter])) == "EP")
            $finalArray[$hit]['EP'] = trim(str_replace("</td>","",$newarray[$counter+1]));
                
        // DOI
        if(trim(str_replace("</td>","",$newarray[$counter])) == "DI"){
            $finalArray[$hit]['DI'] = trim(str_replace("</td>","",$newarray[$counter+1]));
            $hit++;
        }
            
        $counter++;
    }
   
    echo "<hr><pre>";   
    print_r($finalArray);
    echo "</pre>";
    
    // add array to database - citation table
    // ID, authors, journal, year, volume, issue, lastPage, user, hits, title, pages, abstract
    
    
    //connect to database
    $dbname = "ees"; 
    $ip = getenv('IP'); 
    $user = getenv('C9_USER');
    $mysqli = new mysqli($ip, $user, "", $dbname, 3306); 
    if ($mysqli->connect_errno) { 
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error; 
    }

  
    foreach($finalArray as $item){
        $sql = "INSERT INTO citation (authors,journal,year,volume,issue,pages,lastPage,abstract) 
        VALUES ($item['AF'],$item['SO'],$item['PY'],$item['VL'],$item['IS'],$item['BP'],$item['EP'],$item['AB'])";
        $result = $mysqli->query($sql);
    }
    
    
    file_put_contents("files/iansupload.html",print_r($details, true), FILE_APPEND|LOCK_EX);
    
    /* end of Ian's effort */
    
   //file_put_contents("files/iansupload.html",print_r($details, true), FILE_APPEND|LOCK_EX);
   
   /* Matt's effort IC> Can I delete this?
    if (strpos($fileData,'Thomson Reuters Web of Knowledge') == false) {
        //check to see if file includes the test string
        file_put_contents("files/upload.html", 'Incompatible file uploaded');
    } else{
        //file_put_contents("files/upload.txt",$fileData); 
        
        $details = array();
        foreach(explode("<table>",$fileData) as $paper){                        
            $details[] = explode("<tr>", $paper);                       
        }
        
        for($i = 0; $i < count($details); $i++){
            for($j = 0; $j < count($details[$i]); $j++){
                $details[$i][$j] = strip_tags($details[$i][$j]);
            }  
        }

        
        file_put_contents("files/iansupload.html",print_r($details, true), FILE_APPEND|LOCK_EX);
    } end of Matt's effort*/
   
   
   // wont be needing this below
   //file_put_contents("images/testthisshit.php",$array[1]);
   
 /*
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['file']['tmp_name'],$upload_path . $filename))
         echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
      else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
    */
    //echo file_get_contents($filename);



?>  
