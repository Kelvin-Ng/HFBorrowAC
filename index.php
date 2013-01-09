<?

require 'header.php';

?>
		<h2><?echo _('Approved List')?></h2>
		<table>
			<tr>
				<td><?echo _('AC in tieba')?></td>
				<td><?echo _('Date')?></td>
				<td><?echo _('Provider')?></td>
			</tr>
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
			<tr>
				<td><?echo $row[0]?></td>
				<td><?echo $date?></td>
				<td><?echo $row[2]?></td>
			</tr>
<?
}
$result->free();

?>
		</table>
		<h2><?echo _('Borrow an AC')?></h2>
		<form action="submit.php" method="post">
			<table>
				<tr>
					<td><?echo _('User name in tieba')?></td>
					<td><?echo _('Date')?></td>
				</tr>
				<tr>
					<td><input type="text" name="username"></td>
					<td>
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
					</td>
				</tr>
			</table>
			<input type="submit" name="submit">
		</form>
	</body>
</html>
