<?php 
namespace Inc;

use PDO;

class Connect
{
	private $pdo; 

    private static function dbConnect(){
    	$host = '';
    	$db_name = '';
    	$db_user = '';
    	$db_pass = '';
    	$charset = 'utf8';
    	$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
    	$opt = [
	        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	        PDO::ATTR_EMULATE_PREPARES   => false,
    	];
    	
    	$pdo = new PDO($dsn, $db_user, $db_pass, $opt);

    	return $pdo;
    }

    private static function createTable(){
    	
    }

    private static function createDateUpdate(){
        $tz = 'Europe/Kiev';
        $timestamp = time();
        $now_time = new \DateTime("now", new \DateTimeZone($tz));
        $now_time->setTimestamp($timestamp);
        $time = $now_time->format('Y-m-d H:i:s');

        return $time;
    }

    private static function checkUnicHosting($hosting){
        $pdo = self::dbConnect();
        $stmt = $pdo->prepare('SELECT h_name FROM kp_hostings WHERE h_name=?');
        $stmt->execute([$hosting]);
        $result = $stmt->fetch();

        if(!empty($result)){
           return 1;
        }
    }

    private static function validateDataHostings(array $data){
        $clear_data = [];
        foreach ($data as $value) {
            if(is_int($value)){
                filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            }
            if(is_string($value)){
                filter_var($value, FILTER_SANITIZE_STRING);
            }
            $clear_data[] = $value;
        }
        return $clear_data;
    }

    private static function updateHostingTable($data){
        $pdo = self::dbConnect();
        $stmt = $pdo->prepare('UPDATE kp_hostings SET 
                h_service_count = ?,
                h_domain_count = ?,
                h_tickets_count = ?,
                h_bill_count = ?,
                h_date_update = ?
             WHERE h_name = ?');
        $stmt->execute($data);

        return $stmt;
    }

    public static function saveInfoHosting($h_name, array $h_info){
    	$pdo = self::dbConnect();
    	$db_table = 'kp_hostings';
        array_push($h_info,self::createDateUpdate(),$h_name);
        $h_info = self::validateDataHostings($h_info);

        if(self::checkUnicHosting($h_name)){
            self::updateHostingTable($h_info);
            return 'String update';
        }

    	$stmt = $pdo->prepare('INSERT INTO kp_hostings (h_service_count,h_domain_count,h_tickets_count,h_bill_count,h_date_update,h_name) VALUES (?,?,?,?,?,?)');
		$stmt->execute($h_info);

        return 'String add';
    }



    public static function deleteInfo(){

    }

}// class Connect