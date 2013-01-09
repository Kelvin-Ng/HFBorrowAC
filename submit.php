<?

require 'header.php';
require 'config.php';

function ERR_FULL($max_num)
{
?>
		<a><?echo _('Sorry, the booking is full that day.')?></a>
		<br>
		<a><?echo _('We will only accept') .
			 $max_num .
			 _('booking(s) each day.')?></a>
		<br>
		<a><?echo _('Please be earlier next time! :)');?>
<?
	die(1);
}

function ERR_LOW_LV($lv)
{
?>
		<a><?echo _('Sorry, your level in tieba is too low.')?></a>
		<br>
		<a><?echo _('You need to be lv 5 or above but you are lv ') .
			$lv .
			_(' only.');?></a>
<?
	die(1);
}

function ERR_2_WEEKS($last_time)
{
	$time = strtotime('+2 week', $last_time);
	$date = date('j/n', $time);
?>
		<a><?echo _('Sorry, you borrowed an AC on the pass two weeks.')?></a>
		<br>
		<a><?echo _('You can borrow an AC again on ') .  $date?></a>
<?
	die(1);
}

function ERR_BLACK_LST()
{
?>
		<a><?echo _('Error: you are in the blacklist now.')?></a>
		<br>
		<a><?echo _('You will nerver be able to borrow an AC again.');?>
<?
	die(1);
}

function get_level($username)
{
	$str = file_get_contents("http://www.baidu.com/p/" . 
			urlencode($username) . "?from=tieba");
	
	$barpos = strpos($str, 'herofighter吧');
	if ($barpos !== false)
	{
		$lvpos = strpos($str, 'level', $barpos) + 25;
		$lvend = strpos($str, '级', $lvpos) - 1;
		$lv = substr($str, $lvpos, $lvend - $lvpos + 1);
	}
	return intval($lv);
}

if (isset($_POST['submit']))
{
	$username = $_POST['username'];
	$time = $_POST['date'];

	$lv = get_level($username);
	if ($lv < 5)
	{
		ERR_LOW_LV($lv);
	}

	$handle = mysqli_connect($db_host, $db_username, $db_password);
	$handle->select_db($db_name);

	$result = $handle->query("SELECT COUNT(*) FROM borrow WHERE time = $time");
	$num = $result->fetch_row();
	$num = (int)$num[0];
	$result->free();
	
	$result = $handle->query("SELECT COUNT(*) FROM provide");
	$max_num = $result->fetch_row();
	$max_num = (int)$max_num[0];
	$result->free();

	if ($num >= $max_num)
	{
		ERR_FULL($max_num);
	}

	$last_2_weeks = strtotime('-2 week', $time);

	$result = $handle->query(
		"SELECT time, blacklist FROM borrow WHERE username = '$username'");
	if ($result->num_rows)
	{
		$row = $result->fetch_row();
		if ($row[0] >= $last_2_weeks)
		{
			ERR_2_WEEKS($row[0]);
		}
		else if ($row[1])
		{
			ERR_BLACK_LST();
		}
		else
		{
			$handle->query(
	"UPDATE borrow SET time=$time, provider='' WHERE username='$username'");
		}
	}
	else
	{
		$handle->query("INSERT INTO borrow VALUES('$username', $time)");
	}
	$result->free();
}

?>
