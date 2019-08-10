<?php 
include 'views/header.php';
?>
<header class="error links">
	<h2>Links</h2><p>This is you created links</p>
	<section id="footer">
	<section class="inner">
	<div class="table-wrapper">
		<table><thead><tr><th>Link</th><th>Short</th></tr></thead>
			<tbody id="list">
				
			</tbody>
	</table>
	</div>
	</section>
	</section>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script>
		for ( var i = 0, len = localStorage.length; i < len; ++i ) {
			var links = JSON.parse(localStorage.getItem(localStorage.key(i)));
		    $('#list').append('<tr><td><a href="'+links['link']+'">'+links['link']+'</a></td><td><a href="'+links['short']+'">'+links['short']+'</a></td></tr>');
		}
	</script>
</header>
<?php 
include 'views/footer.php';
?>

