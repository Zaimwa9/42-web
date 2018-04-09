<head>
<link rel="stylesheet" type=text/css href="public_html/css/stylenav.css">
</head>
<style>
#myhead {
	display: flex;
	flex-direction: row;
	align:left;
	font-family: monospace;
	font-size: 2em;
}

#logs {
	border-style: solid;
  border-width: thin;
	list-style-type: none;
	padding-left: 5px;
	margin-left: 5px;
}
.a {
	text-decoration: none;
}

</style>
<?php
	session_start();
	if (($_SESSION['isAuthenticated'])) {
		include "./logout.php";
		echo ('<div class="profile" id="myhead">');
		echo ('Hello ' . $_SESSION['user']['usr_firstname']);
		echo ('<a class="profile" id="myhead" href="http://192.168.99.100:8100/rush00/profile.php"><button>Go to profile</button></a></div>');
		echo ('</div>');
	} else {
		echo ('<div class="profile" id="myhead">');
		echo ('<div>');
		include "./signin.php";
		echo ('</div>');
		echo ('<a href="http://192.168.99.100:8100/rush00/signup.php"><button class="item">Create account</button></button></a>');
		echo ('</div>');
	}
?>
