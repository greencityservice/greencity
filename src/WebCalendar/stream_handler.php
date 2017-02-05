<?php
/* $Id: month.php,v 1.95.2.9 2010/08/15 18:54:34 cknudsen Exp $ */
include_once 'includes/init.php';

//check UAC
if ( ! access_can_access_function ( ACCESS_MONTH ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();

  
if ( ( $user != $login ) && $is_nonuser_admin )
  load_user_layers ( $user );
else
if ( empty ( $user ) )
  load_user_layers ();

$cat_id = getValue ( 'cat_id', '-?[0-9,\-]*', true );
load_user_categories ();

$today = time ();

$startdate = $today;
$enddate = strtotime('+1 month');

/* Pre-Load the repeated events for quicker access */
$repeated_events = read_repeated_events (
  ( ! empty ( $user ) && strlen ( $user ) )
  ? $user : $login, $startdate, $enddate, $cat_id );

/* Pre-load the non-repeating events for quicker access */
$events = read_events ( ( ! empty ( $user ) && strlen ( $user ) )
  ? $user : $login, $startdate, $enddate, $cat_id );

header('Content-type:application/json;charset=utf-8');
echo json_encode($events);
// TODO: Add $repeated_events
?>
