<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Convertcsv {

    function array_to_csv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"'){
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
    
}
?>