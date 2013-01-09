<?

require 'header.php';
require 'config.php';

?>
		<h2><?echo _('Admin Area')?></h2>
		<h3>Awaiting List</h3>
		<form action="confirm.php" method="post"><table>
			<td>
				<tr><?echo _('Borrower')?></tr>
				<tr><?echo _('Provider')?></tr>
				<tr><?echo _('Blacklist')?></tr>
<?

$handle = mysqli_connect($db_host, $db_username, $db_password);
$result = $handle->query("SELECT username FROM borrow WHERE provider = ''");
while ($row = $result->fetch_row())
{
?>
			<td>
				<tr><?echo $row[0]?></tr>
				<tr><input type="text"
					name="provider[<?echo $row[0]?>]"></tr>
				<tr><input type="checkbox"
					name="blacklist[<?echo $row[0]?>]"></tr>
			</td>
<?
}
?>
			</td>
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
			<td>
				<tr><?echo $row[0]?></tr>
				<tr><input type="checkbox"
					name="blacklist[<?echo $row[0]?>]"></tr>
			</td>
<?
}
?>
		</table>
		<input type="submit" name="submit_blacklist"></input>
		</form>
	</body>
</html>	
