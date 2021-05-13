<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7;
use \GuzzleHttp\Exception\RequestException;
use \GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
require "/var/www/html/cse451-hayesbm3-web/laravel1-project/vendor/autoload.php";
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;


class S3 extends Controller
{
	public function getBucket() {
		$profile = 'class';                                       //this specifies which profile inside of credential file to use
		$path = '/var/www/.aws/credentials';        //path to credential file

		$provider = CredentialProvider::ini($profile, $path);
		$provider = CredentialProvider::memoize($provider);

		$s3Client = new S3Client([
    			'region' => 'us-east-2',
    			'version' => '2006-03-01',
    			'credentials' => $provider
		]);

		header("content-type: text/plain");

		$bucket = "cse451-s21-web";

		// Use the plain API (returns ONLY up to 1000 of your objects).
		try {
    			$result = $s3Client->getObject([
				'Bucket' => $bucket,
				'Key' => 'hayesbm3/information'
			]);

			return response()->json(['status' => 'OK', 'content' => $result['Body']->getContents()], 201);
		} catch (S3Exception $e) {
			echo $e->getMessage() . PHP_EOL;
			return response()->json(['status' => 'FAIL'], 201);
		}
	}

	public function putBucket(Request $request) {
		$profile = 'class';                                       //this specifies which profile inside of credential file to use
                $path = '/var/www/.aws/credentials';        //path to credential file
		$content = $request->content;

                $provider = CredentialProvider::ini($profile, $path);
                $provider = CredentialProvider::memoize($provider);
		
                $s3Client = new S3Client([
                        'region' => 'us-east-2',
                        'version' => '2006-03-01',
                        'credentials' => $provider
                ]);

                header("content-type: text/plain");

                $bucket = "cse451-s21-web";

		try {
			$result = $s3Client->putObject([
				'Bucket' => $bucket,
				'Key' => 'hayesbm3/information',
				'Body' => $content,
				'ContentType' => 'text/plain'
			]);
		} catch (S3Exception $e) {
			var_dump ($e);
			return response()->json(['status' => 'FAIL'], 201);
		}

		 return response()->json(['status' => 'OK'], 201);
	}
}
