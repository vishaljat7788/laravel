<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Helpers\EncryptDecrypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

trait ConsumeExternalService
{

    /**
     * Send a request to any external service
     * @param $method
     * @param $requestUri
     * @param array $formParams
     * @param array $headers
     * @param bool $async
     * @param bool $is_auth
     * @return String
     * @throws GuzzleException
     */
    public function performRequest($method, $requestUri, $formParams = '', array $headers = [], bool $async = false): string
    {
        // dd($headers);
        $client = new Client([
            'base_uri' =>  Config::get('constant.API_URL'), //env('BASE_URI_FOR_API'),
        ]);
        // dd($client);
        $headers["api-key"] = Config::get('constant.APP_KEY_ENC'); //EncryptDecrypt::bodyEncrypt(json_encode("PROJECT_BRAHMAND_YATRA"));//env
        // dd($headers);
        ('HEADER_KEY');
        // $headers['Accept'] = 'text/plain';
        // echo "<pre>";
        // print_r($headers);
        // die;
        $headers['Content-Type'] = 'text/plain';
        $headers['accept_language'] = 'en';
        $response = "";
        if ($async) {
            $promise = $client->requestAsync($method, $requestUri, ['verify' => false, 'http_errors' => false, 'body' => $formParams, 'headers' => $headers]);
            $response = $promise->wait();
            $promise->then(
                function (ResponseInterface $res) {
                    $response = $res->getBody()->getContents();
                },
                function (RequestException $exception) {
                    $response = $exception->getMessage();
                }
            );
        } else {
            if ($method == 'GET') {
                // $response = $client->request($method,  $requestUri . '?' . http_build_query($formParams), ['verify' => false, 'http_errors' => false, 'body' => $formParams, 'headers' => $headers]);
             
                // dd($response);

                $response = $client->request($method, $requestUri . '?' . http_build_query($formParams), [
                    'verify' => false,
                    'http_errors' => false,
                    'form_params' => $formParams, // Use 'form_params' instead of 'body'
                    'headers' => $headers,
                ]);
                
                $response = $response->getBody()->getContents();
                // Get the contents of the response body.
                // dd($response->getBody()->getContents());
            } else {
                if (empty($headers)) {
                    die('hello');
                }
                // echo "<pre>";
                // print_r($headers);die;
                $response = $client->request($method, $requestUri, ['http_errors' => false, 'body' => $formParams, 'headers' => $headers]);
                // dd($headers);
                // echo "<pre>";print_r($response->getBody()->getContents());die;

                // if($response->getStatusCode()== 401 || $response->getStatusCode()=='401')
                // {
                //  Session::forget('USER_LOGIN_SESSION');
                //  Session::save();
                //  return redirect()->route('home');
                // }  
                $response = $response->getBody()->getContents();
                // echo "<pre>";
                // print_r($response);
                // die;
            }
        }
        return $response;
    }
}
