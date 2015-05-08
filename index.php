<?php
    $filepath = "transcripts.txt";
    $pattern = '\'\\d:[0-5][0-9]\'';
    $replacement =  "$0\r\n";
    
    modifyTxtFile($filepath,$pattern,$replacement);
    
    function modifyTxtFile($filepath, $regex,$replacement){
        if (!file_exists($filepath)){
            echo "File ".$filepath." doesn't exist";
            return;
        }
        $handle = fopen($filepath, "c+");
        $newFile = "copy".rand(0,1000).$filepath;
        $write_handle = fopen($newFile,"x");
        
        if (!$handle || !$write_handle)
        {
            print_r( sprintf ( '%o', fileperms ( $file ) ), PHP_EOL);
            print_r( posix_getpwuid ( fileowner ( $file ) ), PHP_EOL); // Get Owner
            print_r( posix_getpwuid ( posix_getuid () ), PHP_EOL); // Get User
           
            echo "Most likely permission error occured.";
            return;
        }
        
        
        $string = file_get_contents($filepath);
        $count = null;
        $content = preg_replace($regex, $replacement, $string, -1, $count);
        fwrite($write_handle, $content);
        fclose($handle);
        fclose($write_handle);
        echo "Completed. ".$count." found. Changes written to: ".$newFile;
    }  
?>
