
<?php
/*
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
	*/
?>


<?php 
require("connection.php");
include("navbar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<head>

<title> Fashion Store Admin </title>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<META charset="UTF-8">

</head>
<body>
	
body {
  font-family: Arial, Helvetica, sans-serif;
}

.pill-nav a {
  display: block;
  color: black;
  padding: 14px;
  text-decoration: none;
  font-size: 17px;
  border-radius: 5px;
}

.pill-nav a:hover {
  background-color: #ddd;
  color: black;
}

.pill-nav a.active {
  background-color: dodgerblue;
  color: white;
}
</style>
</head>
<body>



<div class="pill-nav">
  <a class="active" href='show_product.php' >show/edit product</a>
  <a href='add_product.php' >add product</a>
  <a href='payment.php' >payment</a>
  <a href='packing.php' >tracking</a>
</div>


</body>
<HTML>
