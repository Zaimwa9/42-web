<link rel="stylesheet" type=text/css href="public_html/css/stylenav.css">
<?php
	include './connect.php';
	include './Model/Categories.php';
	$categories = fetch_categories($conn);
	$redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/index.php";
?>

<?php
		echo('<div class="area">');
		echo('<div class="menu">');
		echo('<ul class="menu-items">');
		echo ('<li class="item" id="homepage"><a class="" href="./index.php"> Happy Uku </li></a>');
		echo('<div class="title" id="navmenu"> Menu </div>');
			foreach($categories as $category) {
				$url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/categorypage.php?cat_name=" . $category['cat_name'];
				echo ('<li class="item" id="cats"> <a class="" href="' . $url . '">' .  $category['cat_name'] . "</a></li>");
			}
		echo('</ul>');
		echo('</div>');
		echo('</div>');
?>
