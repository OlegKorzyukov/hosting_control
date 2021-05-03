<?php 

namespace Inc\Hostings;

use Inc\Hosting;
use Inc\Connect;

class Forward extends Hosting {

	private $hosting = 'Forward';

	public function __construct(){
		$this->getForwardStatistic();
	}
	protected function getRequestUrl(){
    		$url = ''; 
    	return $url;
    }

    protected function getBodyResponse(){
    	$body = 'username=&password='; 
		return $body;
    }

	public function getForwardStatistic(){

	preg_match_all('#<div[^>]* class="[^"]*(?<=\s|")stat(?=\s|")[^>]*>(?<stat>[^>])#ims', $this->getResponse(), $statistic, PREG_SET_ORDER);
		
		$services = $statistic[0]['stat'];
		$domains = $statistic[1]['stat'];
		$tickets = $statistic[2]['stat'];
		$bill = $statistic[3]['stat'];

		$forw_statistic = [$services,
							$domains,
							$tickets,
							$bill];
		
		$save = new Connect();
		$save->saveInfoHosting($this->hosting, $forw_statistic);
	}


}// class Forward