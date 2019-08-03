<?php 
$timestamp = R::find( 'link', ' ORDER BY timestamp DESC' );
$zeroday = time()-1209600; // 2 weeks
if ($timestamp) {
	foreach ($timestamp as $key) {
		if ($key->timestamp < $zeroday) {
			$delete = R::load('link', $key->id);
			R::trash($delete);
			echo('ok');
		}
	}
}






