<?php

$this_day = time();
echo $this_day.' ('.date('l, j F Y - h:i:s A',$this_day).')';
echo '<br />';

$now_day = strtotime('now');
echo $now_day.' ('.date('l, j F Y - h:i:s A',$now_day).')';
echo '<br />';

$next3_day = strtotime('+3 day');
echo $next3_day.' ('.date('l, j F Y - h:i:s A',$next3_day).')';
echo '<br />';

$date = date('Y-m-d H:i:s'); //'0000-00-00 00:00:00';
echo strtotime($date);

if(empty(strtotime($date))) echo 'Kosong';
?>