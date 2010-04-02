<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:::testing:::</title>
<?php 
include("../includes/dbconnect.php");
include("functions.php");
include("classes.php");
$fc = new FeeCalculator;
$sql = "SELECT member_num AS m FROM members ORDER BY member_num DESC";
$result = mysql_query($sql);
?>
<style type="text/css">
h2 { color:#000000; }
</style>
</head>
<body>
<?php
if (isset($_GET['submit'])) {
	$mem_num = $_GET['m'];
	$mem_length = $_GET['l'];
	$type = $_GET['t'];
	$gender = $_GET['g'];
	
	if ($_GET['status'] == "new") { 
		$new_prices = $fc->forWhom($type, $mem_length, "new", $gender);
	}
	if ($_GET['status'] == "current") {
		$prices = $fc->forWhom($type, $mem_length, $mem_num, $gender);
	}
	if ($_GET['status'] == "") {
		die("pick a status, new or current");
	}
}
?>
<div style="width:500px;margin:0 auto;color:#444444;">
	<div><?php echo "<h2>" . date("l") . " - Hour: " . date("G") . "</h2>" . date("g:i:s"); ?>
        <form method="get" action="test.php">
            <p>Member# <select name="m">
            			<option selected="selected">¿&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;?</option>
            			<?php while ($option = mysql_fetch_assoc($result)) {
								echo "<option value=\"$option[m]\">$option[m]</option>";
							  }
						?>
                        </select>
            </p>
            <p><strong>Length:</strong></p>
                <table>
                    <tr><td>One Day</td> <td>      <input type="radio" name="l" value="One Day"/></td></tr>
                    <tr><td>One Month</td> <td>    <input type="radio" name="l" value="One Month"/></td></tr>
                    <tr><td>Three Months</td> <td> <input type="radio" name="l" value="Three Months"/></td></tr>
                    <tr><td>One Year</td> <td>     <input type="radio" name="l" value="One Year"/></td></tr>
                    <tr><td>One Year VIP</td> <td> <input type="radio" name="l" value="One Year VIP"/></td></tr>
                </table>
            <p><strong>Type:</strong> Single <input type="radio" name="t" value="single"/> Couple <input type="radio" name="t" value="couple"/></p>
            <p><strong>Gender:</strong> Male <input type="radio" name="g" value="male"/> Female <input type="radio" name="g" value="female"/></p>
            <p><strong>Status:</strong> New <input type="radio" name="status" value="new"/> Current <input type="radio" name="status" value="current"/></p>
            <p><input type="submit" name="submit" value="Test It"/></p>
        </form>
    </div>
    <div style="color:#222222;">	
    	<?php
			if (isset($_GET['submit'])) {
				if ($_GET['status'] == "new") {
					echo "New Prices...<br />";
					echo "Door Fee: " . $new_prices['door_fee'] . "<br />";
					echo "Mem Fee: " . $new_prices['mem_fee'];				
				}
				if ($_GET['status'] == "current") {
					echo "Current Prices...<br />";
					echo "Door Fee: " . $prices['door_fee'] . "<br />";
					echo "Mem Fee: " . $prices['mem_fee'];				
				}
			}
			echo "<hr />time test<br />";
			$end_date = "08-10-2008";			
			
			if (isExpired($end_date)) {
				echo "expired<br />";
			} else echo "not<br />";			
			
			echo strtotime("20-10-2008") . "<br />";
			echo strtotime("02-01-2009") . "\n";
		?>
        <hr />CHAR TESTING<br />
        <?php
			for ($i=65; $i<=90; $i++) {
				echo chr($i)." ";
			}
			$m = "E0998";
		?>
        <hr />String testing, start at <?php echo $m; ?><br />
        <?php 
			
			preg_match_all('/^[A-Z]/', $m, $f);
			$f = $f[0][0];
			echo $f ."<br />";
			echo "ASCII code: ".ord($f). " for ".$f."<br />";
			
			$ng = new MemSeriesNumberGenerator;
			 
			echo "<hr />Get Next full mem series number<br />";
			echo "Current: " . $ng->currentSeries . "<br />";
			echo "Next: " . $ng->newNum;
			
			echo "<hr />get the number and turn into INT<br />";
			$e = preg_replace('/^[A-Z]/', '', $m);
			$e = (int)$e;
			echo is_int($e) ? "$e has been typecasted into INT" : "no";
			
		?>
    </div>
</div>
</body>
</html>
