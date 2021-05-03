<?php 
namespace Inc;

use Inc\Hostings\Hostiq;
use Inc\Hostings\Forward;
use Inc\Hostings\Thehost;

class Hosting
{

    public function __construct(){
    	$hostiq =	new Hostiq();
    	$forward =	new Forward();
    	$thehost = new Thehost();
    }

    public static function vardump($var) {
	  echo '<pre>';
	  var_dump($var);
	  echo '</pre>';
	}

    private static function getHeaderResponse(){
    	$headers = [
			"Content-Type" => "application/x-www-form-urlencoded",
			"Cache-Control" => "no-cache",
			"Pragma" => "no-cache",
			"Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
			"User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15"
	      ];

	      return $headers;
    }


	public function getResponse(){
		$client = new \GuzzleHttp\Client();
		$cookie  = new \GuzzleHttp\Cookie\CookieJar;

		$result = $client->request('POST', $this->getRequestUrl(), [
			 'cookies' => $cookie,
	         'headers' => self::getHeaderResponse(),
	          'body' => $this->getBodyResponse()
		]);
		$content = $result->getBody()->getContents();

		return $content;
	}



}// class GetHosting


