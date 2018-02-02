<?php    


    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    $filename = $PNG_TEMP_DIR.'test.png';

    $errorCorrectionLevel = 'H';
      

    $matrixPointSize = 9;
   

    if (isset($_GET['data'])) { 
    
        //it's very important!
        if (trim($_GET['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_GET['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_GET['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
    //config form
    echo '<form action="index.php" method="GET">
        Data:&nbsp;<input name="data" value="" />&nbsp;
        
        <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
   //QRtools::timeBenchmark();    

      

    