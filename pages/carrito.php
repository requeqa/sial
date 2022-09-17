<?php
if ( ! session_id() ){    
    echo "<pre>";
    print_r($_SESSION); 
    echo "</pre>";
}

?>