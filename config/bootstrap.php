<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

Configure::load('mh13');

if (!Configure::read('Site.webroot')) {
	Configure::write('Site.webroot', WWW_ROOT);
}

$year = date('Y');
$month = date('m');
if ($month >= 9) {
	$from = $year.'-09-01';
	$to = ($year+1).'-08-31';
} else {
	$from = ($year-1).'-09-01';
	$to = $year.'-08-31';
}

Configure::write('SchoolYear.starts', $from);
Configure::write('SchoolYear.ends', $from);
Configure::write('SchoolYear.string', date('Y', strtotime($from)).'-'.date('Y', strtotime($to)));

App::import('Lib', 'ConfigureException');

if (!defined('PAGINATOR_LONG')) {
	define('PAGINATOR_LONG', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%');
}

if (!defined('PAGINATOR_SHORT')) {
	define('PAGINATOR_SHORT', 'Pag %page%/%pages%. # %start% - %end% / %count%.');
}

if (!defined('COMMENTS_NO')) {
	define('COMMENTS_NO', 0);
}

if (!defined('COMMENTS_CLOSED')) {
	define('COMMENTS_CLOSED', 1);
}

if (!defined('COMMENTS_MODERATED')) {
	define('COMMENTS_MODERATED', 2);
}

if (!defined('COMMENTS_FREE')) {
	define('COMMENTS_FREE', 3);
}

if (!defined('PAGE_LIMIT')) {
	define('PAGE_LIMIT', 15);
}

if (!defined('WIDGET_PAGE_LIMIT')) {
	define('WIDGET_PAGE_LIMIT', 5);
}

if (!defined('ADMIN_PAGE_LIMIT')) {
	define('ADMIN_PAGE_LIMIT', 15);
}

if (!defined('SPECIAL_PAGE_LIMIT')) {
	define('SPECIAL_PAGE_LIMIT', 3);
}

if (!defined('DATE_SHORT')) {
	define('DATE_SHORT', 'j/m/y');
}

if (!defined('DATE_LONG')) {
	define('DATE_LONG', 'j \d\e F \d\e Y');
}

if (!defined('DATE_EXTRA_SHORT')) {
	define('DATE_EXTRA_SHORT', 'j/m');
}

if (!defined('TIME')) {
	define('TIME', 'H:i');
}
//
//App::import('Core', 'ClassRegistry');
//App::import('Lib', 'fi_layout/FiLayout');
//
//# Configure Mailer
//
//App::import('Lib', 'fi_messenger/CakeMailer');
//App::import('Component', 'Email');
//$Mailer = new CakeMailer();
//$Mailer->init(new Controller, new EmailComponent);
//$smtp = array(
//	'port'=> Configure::read('Mail.port'),
//	'timeout'=>'60',
//	'auth' => true,
//	'host' => Configure::read('Mail.host'),
//	'username'=> Configure::read('Mail.username'),
//	'password'=> Configure::read('Mail.password'),
//);
//$Mailer->smtp($smtp);
//
//if (!defined('CAKE_TEST_EXECUTION')) {
//	include_once('events.php');
//} else {
//	Configure::write('Config.language', 'eng');
//}

?>
