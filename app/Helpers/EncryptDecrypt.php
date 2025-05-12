<?php

namespace App\Helpers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class EncryptDecrypt
{
    public static function bodyEncrypt($string)
    {
        // dd($string);
        $encryptionMethod = 'AES-256-CBC';
        $secret = hash('sha256', Config::get('constant.SECRET'));
        $iv = Config::get('constant.IV');
        $encrypt_value = openssl_encrypt($string, $encryptionMethod, $secret, 0, $iv);
        // dd($encrypt_value);
        return $encrypt_value;
    }
    public static function bodyDecrypt($string)
    {

        $encryptionMethod = 'AES-256-CBC';
        $secret = hash('sha256',Config::get('constant.SECRET'));
        $iv = Config::get('constant.IV');

        $decryptValue = openssl_decrypt($string, $encryptionMethod, $secret, 0, $iv);

        // print_r($decryptValue);die;

        return $decryptValue;
    }
    public static function requestDecrypt($request, $type = '')
    {
        if (!empty($type) &&  $type == 'api-key') {
            return self::bodyDecrypt($request);
        }
        $data = (array) json_decode(self::bodyDecrypt($request));

        return new Request($data);
    }
}
