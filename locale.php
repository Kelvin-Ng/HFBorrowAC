<?

require 'locale_code.php';

function use_locale($locale)
{
	putenv("LC_MESSAGES=$locale");
	setlocale(LC_MESSAGES, $locale);
	bindtextdomain('HFBorrowAC', './locale');
	textdomain('HFBorrowAC');
}

if (isset($_GET['locale']))
{
	setcookie('locale', $_GET['locale'], time() + 3600 * 24);
	use_locale($locale_code[$_GET['locale']]);
}
else if (!isset($_COOKIE['locale']))
{
	$locale = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	setcookie('locale', $locale[0], time() + 3600 * 24 * 7);
	use_locale($locale_code[$locale]);
}
else
{
	use_locale($locale_code[$_COOKIE['locale']]);
}

?>
