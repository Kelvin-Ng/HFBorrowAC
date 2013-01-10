<?

function init()
{
	require 'header.php';
	echo "\t\t<h2>" . _('Admin Area') . "</h2>\n";
}

function show_login($wrong)
{
	if ($wrong)
	{
		echo "\t\t<a>" . _('Wrong password') . "</a>\n";
	}
?>
		<form action="admin.php" method="post">
			<a><?echo _('Password: ')?></a>
			<input type="password" name="password">
			<br>
			<input type="submit" name="submit">
		</form>
<?
}

if (isset($_POST['submit']))
{
	if ($_POST['password'] == '08b40')
	{
		setcookie('admin', $_POST['password'], time() + 3600 * 24 * 7);
	}
	else
	{
		init();
		show_login(true);
		die(0);
	}
}
else if ($_COOKIE['admin'] != '08b40')
{
	init();
	show_login();
	die(0);
}

init();
require 'config.php';

?>
		<h3><?echo _('Awaiting List')?></h3>
		<form class="left_form" action="confirm.php" method="post">
		<table>
			<tr>
				<td><?echo _('Borrower')?></td>
				<td><?echo _('Provider')?></td>
				<td><?echo _('Blacklist')?></td>
			</tr>
<?

$handle = mysqli_connect($db_host, $db_username, $db_password);
$handle->select_db($db_name);
$result = $handle->query(
	"SELECT username FROM borrow WHERE provider='' AND blacklist=FALSE");
while ($row = $result->fetch_row())
{
?>
			<tr>
				<td><?echo $row[0]?></td>
				<td><input type="text"
					name="provider[<?echo $row[0]?>]"></td>
				<td><input type="checkbox"
					name="blacklist[<?echo $row[0]?>]"></td>
			</tr>
<?
}
?>
		</table>
		<input type="submit" name="submit_borrower">
		</form>

		<h3><?echo _('Old Borrowers')?></h3>
		<form class="left_form" action="confirm.php" method="post">
		<table>
			<tr>
				<td><?echo _('Borrower')?></td>
				<td><?echo _('Blacklist')?></td>
			</tr>
<?
$result = $handle->query(
	"SELECT username, blacklist FROM borrow WHERE time < " . time());
while ($row = $result->fetch_row())
{
?>
			<tr>
				<td><?echo $row[0]?></td>
				<input type="hidden"
					name="blacklist[<?echo $row[0]?>]">
				<td><input type="checkbox"
					name="blacklist[<?echo $row[0]?>]"
					<?echo ($row[1] ? 'checked' : '')?>></td>
			</tr>
<?
}
$result->free();
?>
		</table>
		<input type="submit" name="submit_blacklist">
		</form>
		<h3><?echo _('Provider List')?></h3>
		<form class="left_form" action="confirm.php" method="post">
		<table>
			<tr>
				<td><?echo _('Id')?></td>
				<td><?echo _('Delete')?></td>
			</tr>
<?
$result = $handle->query('SELECT id FROM provide');
while ($row = $result->fetch_row())
{
?>
			<tr>
				<td><?echo $row[0]?></td>
				<td><input type="checkbox"
					name="del_provider[<?echo $row[0]?>]"></td>
			</tr>
<?
}
$result->free();
?>
		</table>
		<input type="submit" name="submit_del_provider">
		</form>

		<h3><?echo _('Add Provider')?></h3>
		<form action="confirm.php" method="post">
			<a><?echo _('Provider Id: ')?></a>
			<input type="text" name="id">
			<br>
			<input type="submit" name="submit_add_provider">
		</form>
	</body>
</html>	
