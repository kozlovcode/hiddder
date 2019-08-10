<?php 
include 'views/header.php';
?>
<header class="error links">
	<h2>Links</h2><p>This is you created links</p>
	<section id="footer">
	<section class="inner">
	<div class="table-wrapper">
		<div id="list">
			
		</div>
	</table>
	</div>
	</section>
	</section>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script>
		window.document.title="You links — Hiddder";
		$(function(){
			for ( var i = 0, len = localStorage.length; i < len; ++i ) {
				var links = JSON.parse(localStorage.getItem(localStorage.key(i)));
			    $('#list').append('<span><a href="'+links['link']+'">'+links['link']+'</a></span><small><a href="'+links['short']+'">'+links['short']+'</a></small>');
			}
		});
	</script>
</header>
<?php 
include 'views/footer.php';
?>