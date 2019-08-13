<?php 
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
		$uri = $_POST['ulink'];
	if (!parse_url($uri, PHP_URL_SCHEME)) {
		$uri = 'http://'.$uri;
	}
	if (get_headers($uri)) {
		$saveLink = R::dispense('link');
		$saveLink->url = rawurlencode($uri);
		$saveLink->hash = $link;
		$saveLink->timestamp = time();
		$saveLink->uid = $_COOKIE['UID'];
		R::store($saveLink);
		?>
		<section id="footer">
			<div class="inner">
				<form>
					<div class="field half first">
						<input id="youlink" type="url" value="<?php echo $_SERVER['HTTP_REFERER'] . $link ?>">
					</div>
					<div class="field half">
						<input onclick="copyes()" type="button" value="COPY LINK" class="special">
					</div>
					<p>You link is valid for 2 weeks. After this time, the link will be removed.</p>
				</form>
			</div>
		</section>
		<script>
			window.document.title="You link created! — Hiddder";
			function copyes() {
				var copyText = document.getElementById("youlink");
				copyText.select();
				document.execCommand("copy");
			}
		</script>
		<?php
	}else{
		echo '<script>alert("This site does not exist");</script>';
		echo '<meta http-equiv="refresh" content="0;URL=/">';
	}
?>