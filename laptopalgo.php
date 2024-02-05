<?php

/* preferences:
price (hard cap + constant percentage)
ram (gigabytes, float)
weight (kg)
etc.
*/

/*
consider 


*/


define("SHIFTEFFECT",0.05);


$preferences = array(273.0,8.12,5919.44);

function percentageMatch($preferences,$laptop) {
    $scores = array();
    for ($i = 0; $i < count($preferences);$i++) {
        $scores[$i] = 1 - (($laptop - $preferences) / $preferences);
    }
    return array_sum($scores) / count($scores);
}



function updatePreference($match,$preferences,$laptop) {
    if ($match) {
        for ($i = 0; $i < count($preferences);$i++) {
            $preferences[$i] = $preferences[$i] + (($laptop[$i] - $preferences[$i]) * SHIFTEFFECT);
        }
    } else {
        for ($i = 0; $i < count($preferences);$i++) {
            $preferences[$i] = $preferences[$i] + (($preferences[$i] - $laptop[$i]) * SHIFTEFFECT);
        }
    }
}

?>