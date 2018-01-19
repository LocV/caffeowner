<?php
/*	
Even the top rated comment here, Sergio Abreu's, doesn't treat leap years entirely correctly. It should work between 1901 and 2099, but outside that it'll be a little off.

If you want to find out the number of days between two dates, use below. You can change to a different unit from that. It looks a little insane, but keep in mind the full set of rules for leap years:

If the year is divisible by 4, it's a leap year...
- unless the year is divisible by 100, then it isn't...
- - unless the year is divisible by 400, then it really is.

So in the functions below, we find the total numbers of days in full years since the mythical 1/1/0001, then add the number of days before the current one in the year passed. Do this for each date, then return the absolute value of the difference.
*/

function days_diff($d1, $d2) {
    $x1 = days($d1);
    $x2 = days($d2);
    
    if ($x1 && $x2) {
        return abs($x1 - $x2);
    }
}

function days($x) {
    if (get_class($x) != 'DateTime') {
        return false;
    }
    
    $y = $x->format('Y') - 1;
    $days = $y * 365;
    $z = (int)($y / 4);
    $days += $z;
    $z = (int)($y / 100);
    $days -= $z;
    $z = (int)($y / 400);
    $days += $z;
    $days += $x->format('z');

    return $days;
}

?>