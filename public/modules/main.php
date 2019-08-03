<?php
require 'views/header.php';
if ($_POST['do_create']) {
	require 'views/link.php';
}else{
	require 'views/create.php';
}
require 'views/footer.php';