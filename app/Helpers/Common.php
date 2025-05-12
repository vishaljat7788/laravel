<?php
use Illuminate\Support\Facades\Config;

function apiCall($usertype, $reqtype, $data = [], $uri = "", $authtoken = null)
{
    // dd($data);
    $endpoint = Config::get('constant.API_URL');
    
    if ($usertype != "") {
        $requrl = $endpoint . $usertype . '/' . $uri;
    } else {
        $requrl = $endpoint . $uri;
    }
    // dd($requrl);

    $encryptionMethod = Config::get('constant.ENCRYPT_DECRYPT_METHOD');
    $secret = Config::get('constant.SECRET');
    $iv = Config::get('constant.IV');
    // dd($secret);
    $language = Session()->get('locale', 'en');

    if ($authtoken) {
        $authtoken = openssl_encrypt($authtoken, $encryptionMethod, $secret, 0, $iv);
        $apiKey = Config::get('constant.APP_KEY_ENC');
        $headers = [
            "api-key:$apiKey",
            "token:$authtoken",
            "Accept-Language:$language",
            'Content-Type:text/plain',
        ];
    } else {
        $apiKey = Config::get('constant.APP_KEY_ENC');
        $headers = [
            "api-key:$apiKey",
            "Accept-Language:en",
            'Content-Type:text/plain',
        ];
    }

    $encrypt_value = $data != [] ? openssl_encrypt(json_encode($data), $encryptionMethod, $secret, 0, $iv) : '';
    dd($encrypt_value);

    $api_key = Config::get('constant.APP_KEY_ENC');
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        [
            CURLOPT_URL => $requrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $reqtype,
            CURLOPT_POSTFIELDS => $encrypt_value,
            CURLOPT_HTTPHEADER => $headers,
        ]
    );

    $response = curl_exec($curl);
    dd($response);
    curl_close($curl);

    // Decrypt the response using CryptoJS
    $decrypted_response = decryptUsingCryptoJS($response, $secret, $iv);
    dd($decrypted_response);

    return json_decode($decrypted_response, true);
}

// Function to decrypt using CryptoJS
function decryptUsingCryptoJS($encryptedData, $secret, $iv)
{
    dd($encryptedData);

    // Use JavaScript engine (V8) to run CryptoJS
    $jsCode = "
        const CryptoJS = require('crypto-js');
        const encryptedData = '$encryptedData';
        const key = CryptoJS.enc.Hex.parse('$secret');
        const iv = CryptoJS.enc.Hex.parse('$iv');
        const decrypted = CryptoJS.AES.decrypt(encryptedData, key, { iv: iv });
        decrypted.toString(CryptoJS.enc.Utf8);
    ";

    $output = null;
    $tmpFile = tempnam(sys_get_temp_dir(), 'cryptojs');
    file_put_contents($tmpFile, $jsCode);

    exec("node $tmpFile", $output);

    unlink($tmpFile);

    return implode('', $output);
}

function apiCall1($usertype, $reqtype, $data = [], $uri = "", $authtoken = null)
{
    $endpoint = Config::get('constant.API_URL');
    if ($usertype != "") {
        $requrl = $endpoint . $usertype . '/' . $uri;
    } else {
        $requrl = $endpoint . $uri;
    }
    // dd($requrl);
    // dd(Config::get('constant.APP_KEY_ENC'));
    /*Encrypt*/
    // dd(Config::get('constant.ENCRYPT_DECRYPT_METHOD'));
    $encryptionMethod = Config::get('constant.ENCRYPT_DECRYPT_METHOD');
    $secret = hash(Config::get('constant.ENCRYPT_DECRYPT_HASH_METHOD'), Config::get('constant.SECRET'));
    $iv = Config::get('constant.IV');

    $language = ((Session()->get('locale') != null)) ? Session()->get('locale') : 'en';

    if ($authtoken) {
        // dd('idfff');
        $authtoken = openssl_encrypt($authtoken, $encryptionMethod, $secret, 0, $iv);
        $apiKey = Config::get('constant.APP_KEY_ENC');
        $headers = array(
            "api-key:$apiKey",
            "token:$authtoken",
            "Accept-Language:$language",
            'Content-Type:text/plain'
        );
    } else {
        // dd('abcd');
        $apiKey = Config::get('constant.APP_KEY_ENC');
        $headers = array(
            "api-key:$apiKey",
            "Accept-Language:en",
            'Content-Type:text/plain'
        );
    }
    // dd();
    // dd($data);
    $encrypt_value = $data != [] ? openssl_encrypt($data, $encryptionMethod, $secret, 0, $iv) : [];
    // dd($encrypt_value);
    $api_key = Config::get('constant.APP_KEY_ENC');
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $requrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => ($reqtype),
            CURLOPT_POSTFIELDS => $encrypt_value,
            CURLOPT_HTTPHEADER => $headers,
        )
    );

    $response = curl_exec($curl);
    // dd($response);
    curl_close($curl);
    $decrypt_value = openssl_decrypt($response, $encryptionMethod, $secret, 0, $iv);
    // dd($decrypt_value);
    return json_decode($decrypt_value, true);
}


function getLanguage()
{
    return (Session()->get('locale') != null) ? Session()->get('locale') : 'en';
}
function get_restaurant_types()
{

    $result = DB::table('tbl_restaurant_category AS c')->select('c.*')
        ->where('c.status', '1')->orderBy('c.name')->get();

    if (isset($result)) {
        return $result;
    } else {
        return array();
    }
}
function getAllCountryCode()
{
    $path = storage_path() . "/json/country.json";
    return json_decode(file_get_contents($path), true);
}
function get_hastags()
{

    $api_call = apiCall(Config::get('constant.EVENT_URI_FOR_API'), "POST", [], "hashtag_list");

    if ($api_call['code'] == 1 || $api_call['code'] == '1') {
        return $api_call['data'];
    } else {
        return array();
    }
}
function get_categories()
{

    $api_call = apiCall(Config::get('constant.EVENT_URI_FOR_API'), "POST", [], "category_list");

    if ($api_call['code'] == 1 || $api_call['code'] == '1') {
        return $api_call['data'];
    } else {
        return array();
    }
}

function get_cities($page_token)
{


    $api_call = apiCall(Config::get('constant.EVENT_URI_FOR_API'), "POST", json_encode(['page_token' => $page_token]), "city_list");
    if ($api_call['code'] == 1 || $api_call['code'] == '1') {
        return $api_call['data']['result'];
    } else {
        return array();
    }
}

function get_cities1()
{
    $c = DB::table('tbl_cities')->select('id', 'name')->where('status', '1')->get();

    // $api_call = apiCall(Config::get('constant.EVENT_URI_FOR_API'), "POST", json_encode(['page_token'=>$page_token]), "city_list");
    if (count($c) > 0) {
        return $c;
    } else {
        return array();
    }
}




function get_rest_type_by_id($cat_id)
{

    $result = DB::table('tbl_restaurant_category AS c')->select('c.*')
        ->where('c.id', $cat_id)->where('c.status', '1')->first();

    if (isset($result)) {
        return $result;
    } else {
        return array();
    }
}



function nice_datetime($string = '')
{
    if ($string == '') {
        // return date('d M, Y h:i A', time());
        $t = (Session()->get('user_time_zone')) ? Session()->get('user_time_zone') : 'Asia/Kolkata';

        $timezone = new DateTimeZone($t); // Change to your desired timezone

        // Create a DateTime object with the current time
        $datetime = new DateTime();

        // Set the timezone of the DateTime object
        $datetime->setTimezone($timezone);

        // Format the converted date and time
        $convertedDateTime = $datetime->format('d M, Y at h:i A');
        return $convertedDateTime;
    } else {
        // return date('d M, Y h:i A', strtotime($string));
        $t = (Session()->get('user_time_zone')) ? Session()->get('user_time_zone') : 'Asia/Kolkata';

        $timezone = new DateTimeZone($t);
        $datetime = new DateTime($string);
        $datetime->setTimezone($timezone);
        $convertedDateTime = $datetime->format('d M, Y h:i A');
        return $convertedDateTime;
    }
}


function nice_date($string = '')
{
    if ($string == '') {
        // return date('d M, Y', time());
        $t = (Session()->get('user_time_zone')) ? Session()->get('user_time_zone') : 'Asia/Kolkata';
        $timezone = new DateTimeZone($t); // Change to your desired timezone

        // Create a DateTime object with the current time
        $datetime = new DateTime();

        // Set the timezone of the DateTime object
        $datetime->setTimezone($timezone);

        // Format the converted date and time
        $convertedDateTime = $datetime->format('d M, Y');
        return $convertedDateTime;
    } else {
        // return date('d M, Y', strtotime($string));
        $t = (Session()->get('user_time_zone')) ? Session()->get('user_time_zone') : 'Asia/Kolkata';
        $timezone = new DateTimeZone($t);
        $datetime = new DateTime($string);
        $datetime->setTimezone($timezone);
        $convertedDateTime = $datetime->format('d M, Y');

        return $convertedDateTime;
    }
}

function return_json($json_array)
{
    return \json_encode($json_array);
}


function check_user_type()
{
}
