<?php

 	if (!isset($_COOKIE['visits'])) {
		echo "<h1 class='counter'>Witaj pierwszy raz na stronie</h1>";
       setcookie('visits', 1, time() + (3600 * 24 * 365));
 		
    } else {    
        setcookie('visits', $_COOKIE['visits'] + 1, time() + (3600 * 24 * 365));
         echo "<h1 class='counter'>Witaj, odwiedziłeś nas już " . $_COOKIE['visits'] . " razy</h1>";
    }

?>