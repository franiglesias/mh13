<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/cv', array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	//Router::connect('/grimm', array('plugin' => 'contents', 'controller' => 'items', 'action' => 'feed', 'extension' => 'rss'));
	
	// App::import('Lib', 'routes/LegacyRoute');
	// Router::connect('/:id', array('plugin' => 'contents', 'controller' => 'items', 'action' => 'view'), array('routeClass' => 'LegacyRoute', 'pass' => array('id'),'id' => '\d+'));

	App::import('Lib', 'routes/SlugRoute');
	Router::connect('/:slug', array('plugin' => 'contents', 'controller' => 'items', 'action' => 'view'), array('routeClass' => 'SlugRoute', 'pass' => array('slug')));
	
	Router::connect('/planet/*', array('plugin' => 'aggregator', 'controller' => 'entries', 'action' => 'planet'));
	Router::connect('/site/*', array('plugin' => 'contents', 'controller' => 'sites', 'action' => 'view'));
	Router::connect('/blog/*', array('plugin' => 'contents', 'controller' => 'channels', 'action' => 'view'));
	Router::connect('/static/*', array('plugin' => 'contents', 'controller' => 'static_pages', 'action' => 'view'));
	Router::connect('/project/*', array('plugin' => 'contents', 'controller' => 'static_pages', 'action' => 'home'));
	Router::connect('/circular/*', array('plugin' => 'circulars', 'controller' => 'circulars', 'action' => 'view'));
	
	Router::parseExtensions('rss', 'html', 'csv');
?>