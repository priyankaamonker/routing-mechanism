<?php
/**
 * base controller class
 */
abstract class BaseController {
	
	/**
	 * @all controllers must contain an index method
	 */
	abstract function indexAction();
}


/**
 * home controller class - default controller 
 */
class HomeController extends BaseController {

	public function indexAction(){	
		echo "Welcome! this is Home Controller - index method";
	}
}


/**
 * foo controller class
 */
class FooController extends BaseController {
	
	public function __construct() {
	}

	public function indexAction(){		
		echo "Welcome! this is Foo Controller - index method";		
	}
	
	public function barAction(){		
		echo "Welcome! this is Foo Controller - bar method";					
	}	
}

/**
 * function route
 * input $controller, $action
 * output method of the controller class to be executed
 */
function route($controller, $action = "index"){
	$flag_error = false;
	$controllerName = ucwords($controller) . "Controller";
	$actionName = $action . "Action";
	if(class_exists($controllerName)) {
		$con = new $controllerName();	
		if(method_exists($con, $actionName)) {
			$con->{ $actionName }();
		} else {
			$flag_error = true; 
		}
	} else {
		$flag_error = true; 
	}
	if($flag_error == true)
		echo "Incorrect path.";
}

/**
 * Implementation begins
 */
try {		
	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
    $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
	$uri = trim($uri);
	if(empty($uri)){
		$controller = "home";
		$action     = "index";
	} else {
		$uri_arr = explode('/', $uri);
		$controller = $uri_arr['0'];
		$action     = isset($uri_arr['1']) ? $uri_arr['1'] : "index";	
	}
	route($controller, $action);
}
catch(Exception $e) {
	// Display the error message
	echo "Exception occured.";
}
?>