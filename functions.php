<?php
//functions

//put stuff in array and serialize
function compactThis($string){
    $parts = explode(",",$string);
    foreach($parts as &$bit)
        $part[] = trim($bit);
    return serialize($part);
}

//echo compactThis("Ian, Dave,  Jon ,Alf");


//returns true if $haystack starts with $needle
function startsWith($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}

?>