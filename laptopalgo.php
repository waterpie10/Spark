<?php

/* preferences:
price (hard cap + constant percentage)
ram (gigabytes, float)
weight (kg)
etc.
*/

define("SHIFTEFFECT",0.05);


$preferences = array(273.0,8.12,5919.44);


function updatePreference($match,$preferences,$laptop) {
    if ($match) {
        for ($i = 0; $i < count($preferences);$i++) {
            $preferences[$i] = $preferences[$i] + (($laptop[$i] - $preferences[$i]) * SHIFTEFFECT);
        }
    } else {

    }
}

?>