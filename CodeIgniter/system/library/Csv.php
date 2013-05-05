<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csv {

    private $file_name = '';
    private $parse_header = FALSE;
    private $delimiter = ',';
    private $length = 0;
 
    private $header;
    private $file_pointer;
 
    function __construct($config = array()) {
 
        if(count($config > 0)) {
            $this->initialize($config);
        }
 
        log_message('debug', "CSV Class Initialized");
    }
 
    function initialize($config = array()) {
 
        foreach($config as $key => $val) {
 
            if(isset($this->$key)) {
                $this->$key = $val;
            }
 
        }
 
        if(is_file($this->file_name))
            $this->file_pointer = fopen($this->file_name, 'r');
 
        if($this->parse_header) {
            $this->header = fgetcsv($this->file_pointer, $this->length, $this->delimiter);
        }
    }
 
    function parse() {
 
        $data = array();
 
        while(($row = fgetcsv($this->file_pointer, $this->length, $this->delimiter)) !== FALSE) {
            if($this->parse_header) {
 
                foreach ($this->header as $i => $heading_i)
                    $row_new[$heading_i] = $row[$i];
 
                $data[] = $row_new;
            } else
                $data[] = $row;
        }
 
        return $data;
    }
 
    function __destruct() {
 
        if($this->file_pointer) {
            fclose($this->file_pointer);
        }
    }
}
?>