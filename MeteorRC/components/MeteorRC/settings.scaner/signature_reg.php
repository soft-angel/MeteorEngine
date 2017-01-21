<?
return $arSignature = array(

	array(
		's' => '/eval\\(base64_decode\\((?s).*?\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (encoded code - base64)',
		'l' => 'danger',
	),
	array(
		's' => '/\\(gzinflate\\(base64_decode\\((?s).*\\)s/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (compressed code - gzip)',
		'l' => 'danger',
	),
	array(
		's' => '/str_rot13\\(base64_decode\\((?s).*?\\)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (encoded code - str_rot13())',
		'l' => 'danger',
	),
	array(
		's' => '/strrev\\(base64_decode\\((?s).*?\\)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (encoded code - strrev())',
		'l' => 'danger',
	),
	array(
		's' => '/eval\\(stripslashes\\(\\$_(.*?)\\)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (code executed from superglobal variable)',
		'l' => 'danger',
	),
	array(
		's' => '/eval\\(\\$_(.*?)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (code executed from superglobal variable)',
		'l' => 'danger',
	),
	array(
		's' => '/_il_exec\\(\\)/',
		'f' => 'regex',
		'd' => 'Possible risk - ionCube encrypted file',
		'l' => 'danger',
	),
	array(
		's' => '/header(\\s+)?\\(["|\'\'](l|L)ocation:(\\s+)?http:(.*?)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (redirect)',
		'l' => 'warning',
	),
	array(
		's' => '/$wp_add_filter\\(/',
		'f' => 'regex',
		'd' => 'PHP injection (obfuscated code)',
		'l' => 'warning',
	),
	array(
		's' => '/if\\(function_exists\\(\'\'ob_start\'\'\\)&&!isset\\(\\$GLOBALS\\[(.*?)	\\]\\)\\){\\$GLOBALS\\[(.*?)\\	]=/',
		'f' => 'regex',
		'd' => 'PHP injection',
		'l' => 'danger',
	),
	array(
		's' => '/$_[a-zA-Z]=__FILE__;\\$_[a-zA-Z]=/',
		'f' => 'regex',
		'd' => 'PHP injection (obfuscated code)',
		'l' => 'danger',
	),
	array(
		's' => '/mail(\\s+)?\\(("|\'\')(.*@)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (mailer)',
		'l' => 'danger',
	),
	array(
		's' => '/strrev\\((\'\'|")edoced_46esab(\'\'|")\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (obfuscated code)',
		'l' => 'danger',
	),
	array(
		's' => '/(shell_exec|passthru|system|exec|popen)\\s?\\((\'\'|")(wget|lynx|links|cur	l)/',
		'f' => 'regex',
		'd' => 'Possible PHP Injection (file download)',
		'l' => 'danger',
	),
	array(
		's' => '/<script .*?src=["|\'\']https?:(.*)["|\'\']/',
		'f' => 'regex',
		'd' => 'Suspicious JS inclusion',
		'l' => 'warning',
	),
	array(
		's' => '/bash_history/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/bitchx/',
		'f' => 'filename',
		'd' => 'IRC Client - possible hijacked server'
	),
	array(
		's' => '/brute *force/',
		'f' => 'filename',
		'd' => 'Bruteforce'
	),
	array(
		's' => '/c99shell/',
		'f' => 'filename',
		'd' => 'PHP Shell'
	),
	array(
		's' => '/cwings/',
		'f' => 'filename',
		'd' => 'PHP Shell'
	),
	array(
		's' => '/DALnet/',
		'f' => 'filename',
		'd' => 'IRC Client - possible hijacked server'
	),
	array(
		's' => '/directmail/',
		'f' => 'filename',
		'd' => 'Mailer - possible hijacked server'
	),
	array(
		's' => '/eggdrop/',
		'f' => 'filename',
		'd' => 'IRC Bot - possible hijacked server'
	),
	array(
		's' => '/guardservices/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/m0rtix/',
		'f' => 'filename',
		'd' => 'Backdoor - possible hijacked server'
	),
	array(
		's' => '/phpremoteview/',
		'f' => 'filename',
		'd' => 'PHP Shell'
	),
	array(
		's' => '/phpshell/',
		'f' => 'filename',
		'd' => 'PHP Shell'
	),
	array(
		's' => '/psyBNC/',
		'f' => 'filename',
		'd' => 'IRC Client - possible hijacked server'
	),
	array(
		's' => '/r0nin/',
		'f' => 'filename',
		'd' => 'Exploit - possible hijacked server'
	),
	array(
		's' => '/w00t/',
		'f' => 'filename',
		'd' => 'Exploit - possible hijacked server'
	),
	array(
		's' => '/r57shell/',
		'f' => 'filename',
		'd' => 'PHP Shell'
	),
	array(
		's' => '/raslan58/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/spymeta/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/shellbot/',
		'f' => 'filename',
		'd' => 'Backdoor - possible hijacked server'
	),
	array(
		's' => '/undernet/',
		'f' => 'filename',
		'd' => 'IRC Client - possible hijacked server'
	),
	array(
		's' => '/void\\.ru/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/vulnscan/',
		'f' => 'filename',
		'd' => 'Vulnerability Scanner - possible hijacked server'
	),
	array(
		's' => '/.ru/',
		'f' => 'filename',
		'd' => 'Possible hijacked server'
	),
	array(
		's' => '/r57\\.gen\\.tr/',
		'f' => 'regex',
		'd' => 'PHP Shell - General variant',
		'l' => 'danger',
	),
	array(
		's' => '/h4cker\\.tr/',
		'f' => 'regex',
		'd' => 'PHP Shell - General variant',
		'l' => 'danger',
	),
	array(
		's' => '/$QBDB51E25BF9A7F3D2475072803D1C36D/',
		'f' => 'regex',
		'd' => 'PHP Shell - c99shell variant compressed',
		'l' => 'danger',
	),
	array(
		's' => '/antichat/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell Antichat variant'
	),
	array(
		's' => '/PHPencoder/',
		'f' => 'regex',
		'd' => 'PHP Encoded file - PHPencoder variant, please review manually',
		'l' => 'danger',
	),
	array(
		's' => '/ccteam\\.ru/',
		'f' => 'regex',
		'd' => 'PHP Shell - c99shell variant',
		'l' => 'danger',
	),
	array(
		's' => '/c99shell/',
		'f' => 'regex',
		'd' => 'PHP Shell - c99shell variant',
		'l' => 'danger',
	),
	array(
		's' => '/act=phpinfo/',
		'f' => 'regex',
		'd' => 'PHP Shell - c99shell variant',
		'l' => 'danger',
	),
	array(
		's' => '/CWShellDumper/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell CWShellDumper variant',
		'l' => 'danger',
	),
	array(
		's' => '/ekin0x/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell ekin0x variant'
	),
	array(
		's' => '/kacak/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell kacak variant'
	),
	array(
		's' => '/liz0zim/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell liz0zim variant'
	),
	array(
		's' => '/r57shell/',
		'f' => 'regex',
		'd' => 'PHP Shell - r57shell variant',
		'l' => 'danger',
	),
	array(
		's' => '/etc\\/passwd/',
		'f' => 'regex',
		'd' => 'PHP Shell - suspicious code',
		'l' => 'danger',
	),
	array(
		's' => '/ps -aux/',
		'f' => 'regex',
		'd' => 'PHP Shell - suspicious code',
		'l' => 'danger',
	),
	array(
		's' => '/$_POST\\[\'\'cmd\'\'\\]\\=\\="php_eval"/',
		'f' => 'regex',
		'd' => 'PHP Shell - r57shell variant',
		'l' => 'danger',
	),
	array(
		's' => '/safe0ver/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell safe0ver variant'
	),
	array(
		's' => '/$_GET\\[\'\'sws\'\'\\]\\=\\= \'\'phpinfo\'\'/',
		'f' => 'regex',
		'd' => 'PHP Shell - Saudi Sh3ll variant',
		'l' => 'danger',
	),
	array(
		's' => '/Saudi Sh3ll/',
		'f' => 'filename',
		'd' => 'PHP Shell - Saudi Sh3ll variant'
	),
	array(
		's' => '/sosyete/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell sosyete variant'
	),
	array(
		's' => '/tryag/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell tryag variant'
	),
	array(
		's' => '/zehir4/',
		'f' => 'filename',
		'd' => 'PHP Shell - c99shell zehir4 variant'
	),
	array(
		's' => '/create\\_function\\(\\\'\'\\$\\\'\'(.*)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (create_function() call)',
		'l' => 'danger',
	),
	array(
		's' => '/Upload Gagal/',
		'f' => 'regex',
		'd' => 'PHP Shell - File uploader'
	),
	array(
		's' => '/^GIF89;([^\\n]*\\n+)+(\\<\\?php)/',
		'f' => 'regex',
		'd' => 'PHP injection - Hidden inside GIF file',
		'l' => 'danger',
	),
	array(
		's' => '/exec\\((.*)\\/bin\\/sh/',
		'f' => 'regex',
		'd' => 'Possible PHP Injection (shell execution)',
		'l' => 'danger',
	),
	//array(
	//	's' => '/preg_replace\\("/\\.\\*/e"/',
	//	'f' => 'regex',
	//	'd' => 'Possible PHP injection (obfuscated code using /e modifier)/'
	//),
	array(
		's' => '/\\("\\/[a-zA-Z0-9]+\\/e",/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (obfuscated code using /e modifier)/',
		'l' => 'danger',
	),
	array(
		's' => '/ob_start\\("callbck"\\)/',
		'f' => 'regex',
		'd' => 'PHP Injection',
		'l' => 'danger',
	),
	array(
		's' => '/eval\\("\\?\\>"\\.base64_decode/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (encoded code - base64)/',
		'l' => 'danger',
	),
	array(
		's' => '/eval[\\s]?\\([\\s]?base64_decode\\([\\s]?.*?\\)\\)/',
		'f' => 'regex',
		'd' => 'Possible PHP injection (encoded code - base64)',
		'l' => 'danger',
	),
	array(
		's' => '/(wget|lynx|links|curl) https?:\\/\\/.*?; perl .*?/',
		'f' => 'regex',
		'd' => 'Possible PHP Injection (file download and execution)/',
		'l' => 'danger',
	),
	array(
		's' => '/(wget|lynx|links|curl) https?:\\/\\/.*?; chmod .*?; \\.\\//',
		'f' => 'regex',
		'd' => 'Possible PHP Injection (file download and execution)',
		'l' => 'danger',
	)
);
?>