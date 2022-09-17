<?php
global $wppa;
$wppa = array( 'elm1' => 'value1', 'elm2' => 'value2','elm3' => 'value3');

if ( ! session_id() ) @ session_start();
if ( ! isset($_SESSION['wppa'])) $_SESSION['wppa'] = array();

if ( ! isset($_SESSION['wppa']['album']) ) $_SESSION['wppa']['album'] = array();
$_SESSION['wppa']['album'][1234] = 1;

$wppa['elm1'] = 'newvalue1';
echo "<pre>";
print_r($_SESSION);
print_r(session_id());  
echo"</pre>";

if ( session_id() ) @ session_abort();



?>