<?php


    //Subject array.
$array[] = array('key1' => 'row1-1', 'key2' => 'row1-2', 'key3' => 'row1-3', 'key4' => 'row1-4', 'key5' => 'row1-5');
$array[] = array('key1' => 'row2-1', 'key2' => 'row2-2', 'key3' => 'row2-3', 'key4' => 'row2-4', 'key5' => 'row2-5');
$array[] = array('key1' => 'row3-1', 'key2' => 'row3-2', 'key3' => 'row3-3', 'key4' => 'row3-4', 'key5' => 'row3-5');
$array[] = array('key1' => 'row4-1', 'key2' => 'row4-2', 'key3' => 'row4-3', 'key4' => 'row4-4', 'key5' => 'row4-5');

echo '<pre>';
print_r($array);
echo '</hr>';

//Converting array to SCV.
$csv_data = array_to_scv($array, false);
print_r($csv_data);


echo '</pre>';

?>