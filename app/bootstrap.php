<?php

/**
 * My Application bootstrap file.
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */



// Step 1: Load Nette Framework
// this allows load Nette Framework classes automatically so that
// you don't have to litter your code with 'require' statements
require LIBS_DIR . '/Nette/Nette/loader.php';

// load extension methods
if (is_file(APP_DIR . '/extensions.php')) {
	include_once APP_DIR . '/extensions.php';
}

//Environment::setMode('production');

$loader = Environment::getRobotLoader();
$loader->addDirectory(APP_DIR);
$loader->addDirectory(LIBS_DIR);
$loader->register();

// Step 2: Configure environment
// 2a) enable Debug for better exception and error visualisation
Debug::$strictMode = TRUE;
Debug::enable();

Debug::$email = 'petr.ogurcak@gmail.com';

// 2b) load configuration from config.ini file
Environment::loadConfig();


// Step 3: Configure application
// 3a) get and setup a front controller
$application = Environment::getApplication();
$application->errorPresenter = 'Error';
$application->onStartup[] = array('BaseModel', 'initialize');
//$application->catchExceptions = TRUE;


// Step 4: Setup application router
AppRouter::initialize($application);

define("LANG", "cs");

// Step 5: Run the application!
$application->run();
