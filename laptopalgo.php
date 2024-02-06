<?php

/* preferences:
price (hard cap + constant percentage)
ram (gigabytes, float)
weight (kg)
etc.
*/

/*
consider user's quiz preferences

potential v2 algorithm:
if match: increase user's prefs by a percentage of the laptop's values
if not match: decrease user's prefs by a percentage of the laptop's values
see shift effect for what the percentage is that we decide

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

function updatePreferenceV2 ($match,$preferences,$laptop) {
    if ($match) {
        $adjustment = SHIFTEFFECT * 1;
    } else {
        $adjustment = SHIFTEFFECT * -1;
    }
    for ($i = 0; $i < count($preferences);$i++) {
        $preferences[$i] = $preferences[$i] + ($laptop[$i] * $adjustment);
    }
    return $preferences;
}

?>