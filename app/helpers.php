<?php

use Carbon\Carbon;

function helpmedothis()
{
    echo "This is an helper function";
}

function convertToPriceString($number)
{
    return number_format($number, 2);
} //end function convertToPriceString

function dateToHumanDiff($date)
{
    return toCarbonDate($date)->diffForHumans();
} //end function dateToHumanDiff

function toCarbonDate($date)
{
    return Carbon::create((string) $date);
}//end toCarbonDate
