<?php 

namespace Inc\Hostings;

use Inc\Hosting;
use Inc\Connect;

class Thehost extends Hosting {

    private $hosting = 'Thehost';

	public function __construct(){
        $this->getThehostStatistic();
	}

	protected function getRequestUrl(){
    	$url = ''; 
    	return $url;
    }

    protected function getBodyResponse(){
    	$body = 'username=&password=&theme=&lang=&func=&project&welcomfunc&welcomparam'; 
		return $body;
    }

    public function getThehostStatistic(){
       print_r($this->getResponse());
    }
}