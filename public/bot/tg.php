<?php
require str_replace('/public/', '', dirname(__DIR__).'//config/config.php');

define('TOKEN', 'PUT YOU TOKEN');
define('API', 'https://api.telegram.org/bot'.TOKEN.'/');
define('SITE', 'PUT YOU SITE https://example.com/');

$data = json_decode(file_get_contents('php://input'));

switch ($data->message->text) {
	case '/start':
		file_get_contents(API.'sendMessage?chat_id='.$data->message->chat->id."&text=Write me your link and I'll hide it");
		break;
	case '/mylinks':
		$links = R::findLike('link', ['uid' => md5($data->message->chat->id)], 'ORDER BY timestamp DESC');
		if ($links) {
			foreach ($links as $link) {
				$myLinks = $myLinks.'`'.SITE.$link->hash.'`'.PHP_EOL.$link->views.' views'.PHP_EOL.'`'.rawurldecode($link->url).'`'.PHP_EOL.'---'.PHP_EOL;
			}
			$queryData = [
				'parse_mode' => 'markdown',
				'chat_id' => $data->message->chat->id,
				'text' => $myLinks
			];
			file_get_contents(API.'sendMessage?'.http_build_query($queryData));
		}else{
			file_get_contents(API.'sendMessage?chat_id='.$data->message->chat->id."&text=You links list is empty");
		}
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

		$uri = $data->message->text;
		if (!parse_url($uri, PHP_URL_SCHEME)) {
			$uri = 'http://'.$uri;
		}
		if (get_headers($uri)) {
			$saveLink = R::dispense('link');
				$saveLink->url = rawurlencode($uri);
				$saveLink->hash = $link;
				$saveLink->timestamp = time();
				$saveLink->uid = md5($data->message->chat->id);
				R::store($saveLink);
				$link = SITE.$link;
		}else{
			$link = 'This site does not exist';
		}

			file_get_contents(API.'sendMessage?parse_mode=markdown&chat_id='.$data->message->chat->id.'&text=`'.$link.'`');
			if (get_headers($uri)) {
				file_get_contents(API.'sendMessage?chat_id='.$data->message->chat->id.'&text=You link is valid for 2 weeks. After this time, the link will be removed.');
			}
		break;
}