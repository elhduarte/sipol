<?php

    class Decrypter 
    {
        public  function decrypt ($input,$Key) 
        {

            $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5($Key))), "\0");
           // $output = $input.$Key;
            return $output;
        }
    }

?>