<?php 
require("connection.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<head>

<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<META charset="UTF-8">

</head>
<body>

<TABLE border=1>
<TR>
	<TD>pay_id</TD>
	<TD>pay_slip</TD>
	<TD>pay_date</TD>
	<TD>pay_time</TD>
	<TD>order_id</TD>
	<TD>total_price</TD>
	<TD>status</TD>
</TR>

<?php
/*
if ($_POST['action'] != '')
{
	$order_array = pg_query($db,"SELECT order_id FROM payment WHERE pay_check = '0'");
	for($i=0;$i<pg_num_rows($order_array);$i++)
	{
	if ($_POST['action'] == pg_fetch_row($order_array)[0])
	{
	$order_id = $_POST['action'];
	pg_query($db,"UPDATE orderlist SET order_status = 'waiting for packing' WHERE order_id = '$order_id'");
	pg_query($db,"UPDATE payment SET pay_check = '1' WHERE order_id = '$order_id'");
	}
	}

}

*/
?>

<?php
//show payment list
$pay_array = pg_query($db,"SELECT * FROM payment WHERE pay_check = '0'");
while($pay = pg_fetch_row($pay_array))
{
	$pay_id = $pay[0];
	$pay_slip = $pay[1];
	if ($pay_slip != '') { $pay_slip = "<img src='img/$pay_slip' height='42' width='42'>";}
	$pay_date = $pay[2];
	$pay_time = $pay[3];
	$order_id = $pay[4];
	$total_price = pg_fetch_row(pg_query($db,"SELECT total_price FROM orderlist WHERE order_id = '$order_id'"));
	
			echo "<FORM METHOD=POST ACTION='payment_handler.php'><TR>
			<TD>$pay_id</TD>
			<TD>$pay_slip</TD>
			<TD>$pay_date</TD>
			<TD>$pay_time</TD>
			<TD>$order_id</TD>
			<TD>$total_price</TD>
			<TD><INPUT TYPE='hidden' name='action' id=$order_id value='$order_id'><INPUT TYPE='submit' value='Confirm'></TD>
			</TR></form>";

}
?>

</table>
<?php
function update_status($order_id)
{
	pg_query($db,"UPDATE FROM TABLE orderlist SET order_status = 'waiting for packing' WHERE order_id = 'order1'");
	pg_query($db,"UPDATE FROM TABLE payment SET pay_check = '1' WHERE order_id = 'order1''");	
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	var replace_button = $('.replaceButton');
	var accepted = '<div><center>confirmed</center></div>';
	$(replace_button).click(function()
	{
    	$(this).replaceWith(
          "<p><center>confirmed</center></p>");
		
	});
	
});

</script>






</body>
<HTML>
