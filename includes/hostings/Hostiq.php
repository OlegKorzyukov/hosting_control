<?php 

namespace Inc\Hostings;

use Inc\Hosting;
use Inc\Connect;

class Hostiq extends Hosting {

	private $hosting = 'Hostiq';

	public function __construct(){
		$this->getHostiqStatistic();
	}

	protected function getRequestUrl(){
    		$url = ''; 
    	return $url;
    }

    protected function getBodyResponse(){
    	$body = 'username=&password='; 
		return $body;
    }

	public function getHostiqServices(){
		preg_match_all('#<tr[^>]*class="[^"]*(?<=\s|")clientareatableactive(?=\s|")[^>]*>.?\s*<td[^>]*>(?<service>[^"]*)>.?\s*<a[^>]*href=[^>](?<url>[^"]*)"[^>]*>[^>]*><.td>.?\s*<td[^>]*>(?<price>[^\s]*).?\s*<td[^>]*>(?<period>[^>]*)>.?\s*<td[^>]*>(?<next_date>[^>]*)>#ims', $this->getResponse(), $link_main_domain, PREG_SET_ORDER);
		
		foreach ($link_main_domain as $item){
			echo $item['service'];
			echo $item['url'];
			echo $item['price'];
			echo $item['period'];
			echo $item['next_date'];

		}
	}

	public function getHostiqStatistic(){
		preg_match_all('#<p[^>]*class="[^"]*(?<=\s|")header(?=\s|")">Статистика учетной записи[^\s]*\s*<p[^>]*>*[^>]*.(?<statistic_sevices>[^>])[^>]*>[^>]*>.?[^>]*>(?<statistic_domains>[^>])[^>]*>\s[^>]*>\s*[^>]*>(?<statistic_tickets>[^>])[^>]*>[^>]*>.?[^>]*>(?<statistic_clients>[^>])[^>]*>[^>]*>[^>]*>(?<statistic_balans>[^<]*)[^>]*>[^>]*>.?[^>]*>(?<statistic_pay>[^<]*)#ims', self::getResponse(), $statistic_domain, PREG_SET_ORDER);

		preg_match_all('#<h2[^>]*><strong>(?<bill>[^>])<[^>]*>\s*Неоплаченные счета[^>]*>#ims',self::getResponse(), $statistic_bill);

		$hiq_statistic = [];
		foreach ($statistic_domain as $item){

			$statistic_sevices = $item['statistic_sevices']; //Количество сервисов
			$statistic_domains = $item['statistic_domains']; //Количество доменов
			$statistic_tickets = $item['statistic_tickets']; //Количество тикетов
			$statistic_clients = $item['statistic_clients']; //Количество приглашенных клиентов
			$statistic_balans = $item['statistic_balans']; //Баланс счета
			$statistic_pay = $item['statistic_pay']; //К оплате
			$statistic_bill = $statistic_bill['bill'][0];

			$hiq_statistic = [$statistic_sevices,
							 $statistic_domains,
							 $statistic_tickets,
							 $statistic_bill];
							  //$statistic_clients,
							  //$statistic_balans,
							  //$statistic_pay

			$save = new Connect();
			$save->saveInfoHosting($this->hosting, $hiq_statistic);
		}
	}



}// class Hostiq