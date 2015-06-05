<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'index', 'action' => 'index'));	
	Router::parseExtensions();
	/* Static Pages of the sitess */	
	
	Router::connect('/login', array('controller' => 'Index', 'action' => 'login' ));
	Router::connect('/register_specialist', array('controller' => 'Index', 'action' => 'register_specialist' ));
	Router::connect('/register_customer', array('controller' => 'Index', 'action' => 'register_customer' ));
	
	// Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));	
	Router::connect('/our-trainer', array('controller' => 'pages', 'action' => 'display' ));
	Router::connect('/our-club', array('controller' => 'pages', 'action' => 'display' ));	Router::connect('/our-corporate', array('controller' => 'pages', 'action' => 'display' ));
	
	Router::connect('/about-us', array('controller' => 'pages', 'action' => 'display' ));
	
	Router::connect('/contact-us', array('controller' => 'pages', 'action' => 'display' ));
	
	
	Router::connect('/disclaimer', array('controller' => 'pages', 'action' => 'display' ));
	Router::connect('/news-feed', array('controller' => 'pages', 'action' => 'display' ));
	Router::connect('/privacy-policy', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/faq', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/terms-of-use', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/terms-and-condition', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/how-it-works', array('controller' => 'pages', 'action' => 'display'));
	
	Router::connect('/manage-pricing', array('controller' => 'pages', 'action' => 'display' ));
		
	Router::connect('/free-trial-privacy-policy', array('controller' => 'pages', 'action' => 'display' ));
  
	
	/*** ...and connect the rest of 'Pages' controller's urls. */	
	Router::connect('/admin', array('controller' => 'users', 'action' => 'index', 'admin' => true));
	
	
	
	/*Router::connect('/helpler/registration', array('controller' => 'members', 'action' => 'registration'));
	Router::connect('/helpler/registration/:tab', array('controller' => 'members', 'action' => 'registration'));
	Router::connect('/helpler/dashboard', array('controller' => 'members', 'action' => 'dashboard'));
	Router::connect('/helpler/registration/thankyou', array('controller' => 'members', 'action' => 'registration_successsful'));
	Router::connect('/browses/tasks', array('controller' => 'browse', 'action' => 'tasks'));
	Router::connect('/browses/search', array('controller' => 'browse', 'action' => 'search'));
	Router::connect('/browse/hire_helper', array('controller' => 'browse', 'action' => 'hire_helper'));
	Router::connect('/browse/hire_helper/:category', array('controller' => 'browse', 'action' => 'hire_helper'));
	Router::connect('/browses/hire_helper', array('controller' => 'browse', 'action' => 'hire_helper'));
	*/

	
	
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
