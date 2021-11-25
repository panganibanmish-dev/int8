<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/**** USER DEFINED CONSTANTS **********/

define('ROLE_ADMIN',                     '1');
define('ROLE_PURCHASER',                        '4');
define('ROLE_CONTRACTOR',                       '5');
define('ROLE_BUILDER',                          '6');

define('SEGMENT',								2);

/************************** EMAIL CONSTANTS *****************************/
/**************************SYSTEM ADMIN CREDENTIALS HERE***********************/
define('EMAIL_FROM',                            "int8dev@int8.dev.humanpixel.com.au");		// e.g. email@example.com
//define('EMAIL_TO',                            	"michelle@team.humanpixel.com.au");		// e.g. email@example.com
// define('EMAIL_CC',                            	"the receiver email here");	
// define('EMAIL_BCC',                            	"the receiver email here");	
define('FROM_NAME',                             "CIAS Admin System");	// Your system name
define('EMAIL_PASS',                            "6r}%6}WJ#n]v");	// Your email password
define('PROTOCOL',                             	"smtp");				// mail, sendmail, smtp
define('SMTP_HOST',                             "mail.int8.dev.humanpixel.com.au");		// your smtp host e.g. smtp.gmail.com (OLDER VERSION)
define('SMTP_CRYPTO',                           "ssl"); //the security e.g. ssl, tls, auto
define('SMTP_PORT',                             465);					// your smtp port e.g. 25 (DEFAULT), 465 (SSL), 587 (TLS)
define('SMTP_USER',                             "int8dev@int8.dev.humanpixel.com.au");		// your smtp user
define('SMTP_PASS',                             "6r}%6}WJ#n]v");	// your smtp password
define('MAIL_PATH',                             "/usr/sbin/sendmail"); 

/* End of file constants.php */
/* Location: ./application/config/constants.php */