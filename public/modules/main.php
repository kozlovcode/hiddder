<?php
function UID()
{
	return md5(sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)));
}
$uid = UID();

if (empty($_COOKIE['UID'])){
	setcookie('UID', $uid, time() + 60 * 60 * 24 * 30 * 12);
}
require 'views/header.php';
if ($_POST['do_create']) {
	require 'views/link.php';
}else{
	require 'views/create.php';
}
require 'views/footer.php';