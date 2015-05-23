<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Zip {
    
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function unzip($file=null, $path=null)
    {
    	global $CONFIG;
    
    	if ($file==null) return false;
    	
    	$zip = new ZipArchive;
    	if ($zip->open($file) === TRUE) {
    		$zip->extractTo($path);
    		$zip->close();
            unlink($file);
    		return true;
    	}else{
            unlink($file);
            return false;
    	}
    }
    
    /**
     * @todo unzip file
     * @param String $file = full path to file that will be extract, including extension
     * @param String $path_extract = path to folder where $file will be extract
     * 
     * @return true
     * */
    function s_linux_unzip($file, $path_extract){
        mkdir($path_extract, 0755);
    
        //extract and delete zip file             
        shell_exec("unzip -jo $file  -d $path_extract");
        //unlink($file);
        return true;
    }
}

/* End of file Biomatcher_lib.php */