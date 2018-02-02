<?php
class Encrypter 
{ 
    private static $Key = "mingob$2013SIPOL";
    public static function encrypt ($input) 
    {
            $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
            return $output;
    } 
    public static function decrypt ($input) 
    {
            $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))), "\0");
            return $output;
    }
    public function compilarnumeros($numero)
    {
        switch ($numero) 
        {
            case '1':
            return "ibyo";
            break;
            case '2':
            return"ncxi";
            break;
            case '3':
            return "idwc";
            break;
            case '4':
            return "seva";
            break;
            case '5':
            return "tfun";
            break;
            case '6':
            return "egtr";
            break;
            case '7':
            return "rhse";
            break;
            case '8':
            return "iirb";
            break;
            case '9':
            return "ojoq";
            break;
            case '0':
            return "mazn";
            break;
        }
    }
    public function descompilarnumeros($numero)
    {
            switch ($numero) 
            {
                case 'ibyo':
                return "1";
                break;
                case 'ncxi':
                return"2";
                break;
                case 'idwc':
                return "3";
                break;
                case 'seva':
                return "4";
                break;
                case 'tfun':
                return "5";
                break;
                case 'egtr':
                return "6";
                break;
                case 'rhse':
                return "7";
                break;
                case 'iirb':
                return "8";
                break;
                case 'ojoq':
                return "9";
                break;
                case 'mazn':
                return "0";
                break;
            }
    }
    public function compilarget($numeroget)
    {
        $cantidadnumeros = strlen($numeroget);
        $variableresult = "";
        for($i=0; $i<$cantidadnumeros; $i++)
        {
          $variableresult = $variableresult.$this->compilarnumeros($numeroget[$i]);
        }
        return $variableresult;
    }
    public function descompilarget($numeroget)
    {
        $resultado ="";
        $cantidadletrass = strlen($numeroget);
        $contadoletras = 0;
        $numeroletra = "";
        for($i=0; $i<$cantidadletrass; $i++)
        {
            if($contadoletras==3)
            {
                $numeroletra = $numeroletra.$numeroget[$i];
                $contadoletras = 0;
                $resultado = $resultado.$this->descompilarnumeros($numeroletra);
                $numeroletra="";
            }else{
                $numeroletra = $numeroletra.$numeroget[$i];
                $contadoletras = $contadoletras  +1;
            }
        }
        return $resultado;
    }
}
?>