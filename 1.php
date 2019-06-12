<?php
$thisTime = time();
$strTime = date('Y-m-d',$thisTime);
// var_dump($strTime);
$dataTime['start'] = strtotime($strTime);
$dataTime['end'] = strtotime($strTime."+1 day");

echo date('Y-m-d H:i:s',$dataTime['start']) .'--------------'.date('Y-m-d H:i:s',$dataTime['end']);

echo "<hr />";


echo $s1 = strtotime($strTime."-12 day");
echo "<hr />";
echo $s2 = date('Y-m-d',$s1);
echo "<hr />";

echo date('Y-m-01', strtotime('-1 month'));
echo "<br/>";
echo date('Y-m-t', strtotime('-1 month'));
echo "<br/>";


$BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
echo $BeginDate;
echo "<br/>";
echo date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
echo "<br/>";