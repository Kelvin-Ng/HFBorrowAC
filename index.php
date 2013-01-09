<?

require 'header.php';

?>
		<h2><?echo _('Approved List')?></h2>
		<table>
			<td>
				<tr><?echo _('AC in tieba')?></tr>
				<tr><?echo _('Date')?></tr>
				<tr><?echo _('Provider')?></tr>
			</td>
<?

require 'config.php';

$handle = mysqli_connect($db_host, $db_username, $db_password);
$handle->select_db($db_name);
$today = mktime(0, 0, 0);
$result = $handle->query(
"SELECT username, time, provider FROM borrow WHERE time>=$today AND provider != ''");
while ($row = $result->fetch_row())
{
	$date = date('j/n', $row[1]);
?>
			<td>
				<tr><?echo $row[0]?>
				<tr><?echo $date?>
				<tr><?echo $row[2]?>
			</td>
<?
}
$result->free();

?>
		</table>
		<h2><?echo _('Borrow an AC')?></h2>
		<form action="submit.php" method="post">
			<table>
				<td>
					<tr><?echo _('User name in tieba')?></tr>
					<tr><?echo _('Date')?></tr>
				</td>
				<td>
					<tr><input type="text" name="username"></tr>
					<tr>
						<select name="date">
<?
$timestamp = mktime(0, 0, 0);
$date = date('j/n', $timestamp);
?>
							<option value="<?
							echo $timestamp?>">
								<?echo $date?>
							</option>
<?
for ($i = 0; $i < 6; $i++)
{
	$timestamp = strtotime('+1 day', $timestamp);
	$date = date('j/n', $timestamp);
?>
							<option value="<?
							echo $timestamp?>">
								<?echo $date?>
							</option>
<?
}
?>
						</select>
					</tr>
				</td>
			</table>
			<input type="submit" name="submit">
		</form>
	</body>
</html>
