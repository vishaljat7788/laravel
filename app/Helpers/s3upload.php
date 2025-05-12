<?php

namespace App\Helpers;

use Cookie;
// use Illuminate\Support\Facades\Storage;

use AWS\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class s3upload
{

  // public function __construct(){
  //     parent::__construct();

  // }

  public static function uploadImage($file_name, $tmp_name, $bucket_path)
  {

    $image_path = time() . $file_name;
    // dd($image_path);

    try {
      

      $s3Client = new S3Client([
        'region'      => env('AWS_DEFAULT_REGION'),
        'version'     => 'latest',
        'credentials' => [
            'key'    => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
       ]);

      $s3Client->putObject([
        'Bucket' => env('AWS_BUCKET'),
        'Key'    => $bucket_path . $image_path,
        'SourceFile' => ($tmp_name != "") ? $tmp_name : '',
        'ACL'    => 'public-read',
      ]);

      return $image_path;
    } catch (S3Exception $e) {

      // dd($e);
      echo "There was an error uploading the file.\n";
    }
  }









  // public static function uploadImage($field, $path,$image_name)
  // {
  //   try
  //   {
  //     $s3 = S3Client::factory([
  //         'region' => 'eu-west-1',
  //         'version' => '2006-03-01',
  //         'signature_version' => 'v4',
  //         'credentials' => [
  //         'key' => 'AKIAY7ZQSWXBE7WITQUM',
  //         'secret' => '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',
  //         ],
  //         ]);

  //       /* code to upload file on bucket */
  //       $s3->putObject([
  //           'Bucket' => 'hlink-bucket-office1',
  //           'Key' => $path . $image_name,
  //           'SourceFile' => $field,
  //           'ServerSideEncryption' => 'AES256',
  //           'ACL' => 'public-read',
  //           ]);

  //       return $image_name;
  //   } catch (S3Exception $e) {

  //     dd($e);
  //       return false;
  //   }
  // }

}
