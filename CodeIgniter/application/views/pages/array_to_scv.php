<?php

function array_to_scv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"')
{
	if (!is_array($array) or !is_array($array[0])) return false;
	
	//Header row.
	if ($header_row)
	{
		foreach ($array[0] as $key => $val)
		{
			//Escaping quotes.
			$key = str_replace($qut, "$qut$qut", $key);
			$output .= "$col_sep$qut$key$qut";
		}
		$output = substr($output, 1)."\n";
	}
	//Data rows.
    $output = '';
	foreach ($array as $key => $val)
	{
		$tmp = '';
		foreach ($val as $cell_key => $cell_val)
		{
			//Escaping quotes.
			$cell_val = str_replace($qut, "$qut$qut", $cell_val);
			$tmp .= "$col_sep$qut$cell_val$qut";
		}
		$output .= substr($tmp, 1).$row_sep;
	}
	
	return $output;
}




    $A = array();
    $idx = 1;
    foreach ($matches as $match){     
    
    $nameA[0] = '';
    $nameA[] = $match['filenameB'];
    $array[0] = $nameA;
    $array[] = array($idx => $match['filenameA']);
    $idx++;
}
    
    
    echo '<pre>';
print_r($array);

//Converting array to SCV.
$csv_data = array_to_scv($array, false);
print_r($csv_data);


echo '</pre>';
    
?>