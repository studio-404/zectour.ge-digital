<?php
namespace functions; 

class files
{
	public static function get_size($file)
	{
		try{
            $file = str_replace(' ','%20', $file);
            $curl = curl_init();
            curl_setopt_array($curl, array(    
                CURLOPT_URL => $file,
                CURLOPT_HEADER => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_NOBODY => true));

            $headers = explode("\n", curl_exec($curl));
            curl_close($curl);
            return preg_replace("/[^0-9]/", "", $headers[5]);
		}catch(Exception $e){
			return 0;
		}
	}

	public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
	}
}