<?php

function yesNo($var)
{
    if ($var == "1") {
        return "✔";
    } else {
        return "✘";
    }
}

function status($firstDate, $secondDate)
{
    $currentDate = strtotime(date('Y/m/d'));
    $time1 = strtotime($firstDate);
    $time2 = strtotime($secondDate);

    if ($time2 < $currentDate) {
        return "Archiwalny";
    } else if ($time1 < $currentDate && $currentDate < $time2) {
        return "Bieżący";
    } else if ($time2 == $currentDate){
        return "Bieżący";
    } else {
        return "Przyszły";
    }
}

?>