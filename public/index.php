<?php
try {
	// include autoload method for avoiding every time include classes, using namespace like as \Ninja\EntryPoint(,,,).
	include __DIR__ . '/../includes/autoload.php';

	$route = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
	$method = $_SERVER['REQUEST_METHOD'];

	// go entry point for routing(get route), getting page respond to route, loading template, so on. into classes/Ninja/EntryPoint.php.
	$entryPoint = new \Ninja\EntryPoint($route, $method, new \Ijdb\IjdbRoutes());
	$entryPoint->run();
}
catch (PDOException $e) {
	$title = 'An error has occurred';
	$output = 'Database error: ' . $e->getMessage() . ' in ' .
	$e->getFile() . ':' . $e->getLine();

	include  __DIR__ . '/../templates/layout.html.php';
}

