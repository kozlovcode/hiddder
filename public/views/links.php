<?php 
include 'views/header.php';
?>
<header class="error links">
	<h2>Links</h2><p>This is you created links</p>
	<section id="footer">
	<section class="inner">
	<div class="table-wrapper">
		<div id="list">
			<?php 
			$links = R::findLike('link', ['uid' => $_COOKIE['UID']], 'ORDER BY timestamp DESC');
			foreach ($links as $link) {
				echo '<span><a href="'.$_SERVER['HTTP_REFERER'].$link->hash.'"">'.$_SERVER['HTTP_REFERER'].$link->hash.'</a></span><small>Views: '.$link->views.'<br><a href="'.rawurldecode($link->url).'">'.rawurldecode($link->url).'</a></small>';
			}
			?>
		</div>
	</table>
	</div>
	</section>
	</section>
	<script>
		window.document.title="You links — Hiddder";
	</script>
</header>
<?php 
include 'views/footer.php';
?>