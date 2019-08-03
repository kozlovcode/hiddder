<?php 
require str_replace('/public/', '', dirname(__DIR__).'//config/config.php');

define('CONFIRMATION', '8d');
define('SECRET', 'KJ');
define('TOKEN', '3c');
define('DOMAIN', 'https://example.com/');

$data = json_decode(file_get_contents('php://input'));
if(!$data){
	echo 'error';
	return;
}

if ($data->secret !== SECRET && $data->type !== 'confirmation') {
	echo 'error';
	return;
}

switch ($data->type) {
	case 'confirmation':
		echo CONFIRMATION ;
		break;
	case 'message_new':
	
	function generate(){
		$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$max=6; 
		$size=StrLen($chars)-1; 
		$genlink=null; 
		while ($max--) {
			$genlink.=$chars[rand(0,$size)];
		}
		return $genlink;
	}
	$link = R::findOne('link', 'hash = ?', [generate()]);
	if ($link->hash !== generate()) {
		$link = generate();
	}else{
		generate();
	}
	
	if ($data->object->text != '') {
		$uri = $data->object->text;
	}
	
	if ($data->object->attachments[0]->link->url != '') {
		$uri = $data->object->attachments[0]->link->url;
	}
	
	if (!parse_url($uri, PHP_URL_SCHEME)) {
		$uri = 'http://'.$uri;
	}
	
	if (get_headers($uri)) {
		$saveLink = R::dispense('link');
			$saveLink->url = rawurlencode($uri);
			$saveLink->hash = $link;
			$saveLink->timestamp = time();
			R::store($saveLink);
			$link = DOMAIN . $link;
	}else{
		$link = 'This site does not exist';
	}
		$params = array(
			'user_id' => $data->object->from_id,
			'random_id' => rand(1000, 5000),
			'message' => $link,
			'read_state' => 1,
			'access_token' => TOKEN,
			'v' => '5.95'
		);
		file_get_contents('https://api.vk.com/method/messages.send?' . http_build_query($params));
		if (get_headers($uri)) {
			$params2 = array(
				'user_id' => $data->object->from_id,
				'random_id' => rand(1000, 5000),
				'message' => 'You link is valid for 2 weeks. After this time, the link will be removed.',
				'read_state' => 1,
				'access_token' => TOKEN,
				'v' => '5.95'
			);
			file_get_contents('https://api.vk.com/method/messages.send?' . http_build_query($params2));
		}
		header("HTTP/1.1 200 OK");
		echo 'OK';
		break;
	default:
		header("HTTP/1.1 200 OK");
		echo 'OK';
		break;
}