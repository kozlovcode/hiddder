<?php
require str_replace('/public/', '', dirname(__DIR__).'//config/config.php');

define('TOKEN', '97');
define('DOMAIN', 'https://example.com/');
define('WEBHOOK', DOMAIN.'bot/tg.php');
define('API', 'https://api.telegram.org/bot'.TOKEN.'/');

$result = file_get_contents(API.'getWebhookInfo');
$result = json_decode($result);

if (empty($result->result->url)) {
	file_get_contents(API.'setWebhook?url='.WEBHOOK);
}

$result = file_get_contents('php://input');
$result = json_decode($result);
switch ($result->message->text) {
	case '/start':
		file_get_contents(API.'sendMessage?chat_id='.$result->message->chat->id."&text=Write me your link and I'll hide it");
		break;
	default:
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
		$uri = $result->message->text;
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
			file_get_contents(API.'sendMessage?chat_id='.$result->message->chat->id.'&text='.$link);
			if (get_headers($uri)) {
				file_get_contents(API.'sendMessage?chat_id='.$result->message->chat->id.'&text=You link is valid for 2 weeks. After this time, the link will be removed.');
			}
		break;
}