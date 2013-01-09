<?

require 'header.php'
require 'config.php';

$handle = mysqli_connect($db_host, $db_username, $db_password);
if (isset($_POST['submit_provider']))
{
	foreach ($_POST['provider'] as $borrower => $provider)
	{
		if ($_POST['blacklist'][$borrower])
		{
			continue;
		}
		$result= $handle->query(
			"SELECT id FROM provide WHERE id='$provider'");
		if ($result->num_rows == 0)
		{
			echo _("Error: No this provider: $provider");
			continue;
		}
		$result->free();

		$provide_result= $handle->query(
			"SELECT time FROM borrow WHERE provider='$provider'");
		if ($provide_result->num_rows)
		{
			$result = $handle->query(
			"SELECT time FROM borrow WHERE username='$borrower'");
			$borrow_row = $result->fetch_row();
			$result->free();
			while ($provide_row = $provide_result->fetch_row())
			{
				if ($provide_row[0] == $borrow_row[0])
				{
					$ERR_REPEAT = true;
					break;
				}
			}
			if ($ERR_REPEAT)
			{
				echo _(
		"Error: $provider has already lent his/her account to a player.");
				continue;
			}
		}
		$handle->query(
		"UPDATE borrow SET provider='$provider' WHERE username='$borrower'");
	}
}

foreach ($_POST['blacklist'] as $username => $value)
{
	if ($value)
	{
		$handle->query(
	"UPDATE borrow SET provider='', blacklist=TRUE WHERE username=$username");
	}
}

echo '<a herf="admin.php">' . _('Click me to return to Admin Area') . '</a>';

?>