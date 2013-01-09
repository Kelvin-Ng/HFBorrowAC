<?

require 'header.php';
require 'config.php';

?>
		<h2><?echo _('Admin Area')?></h2>
		<h3>Awaiting List</h3>
		<form action="confirm.php" method="post"><table>
			<tr>
				<td><?echo _('Borrower')?></td>
				<td><?echo _('Provider')?></td>
				<td><?echo _('Blacklist')?></td>
			</tr>
<?

$handle = mysqli_connect($db_host, $db_username, $db_password);
$handle->select_db($db_name);
$result = $handle->query("SELECT username FROM borrow WHERE provider = ''");
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
		<input type="submit" name="submit_provider">
		</form>

		<h3>Old Borrowers</h3>
		<form action="confirm.php" method="post"><table>
<?
$result = $handle->query(
	"SELECT username FROM borrow WHERE time < " . time());
while ($row = $result->fetch_row())
{
?>
			<tr>
				<td><?echo $row[0]?></td>
				<td><input type="checkbox"
					name="blacklist[<?echo $row[0]?>]"></td>
			</tr>
<?
}
?>
		</table>
		<input type="submit" name="submit_blacklist"></input>
		</form>
	</body>
</html>	
