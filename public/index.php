<?php
/*
//if (defined('APPLICATION_ENV')) {
//  if (APPLICATION_ENV == 'testing') {
    if (preg_match("/-test/", $_SERVER['HTTP_HOST'])) {
      if ($_SERVER['REQUEST_URI'] != "/p404"
//        && !preg_match("!^/imgdata/!", $_SERVER['REQUEST_URI'])
//        && !preg_match("!^/favoriteajax/!", $_SERVER['REQUEST_URI'])
//        && !preg_match("!^/refererimg!", $_SERVER['REQUEST_URI'])
        ) {
        if (file_exists(dirname(__FILE__) . '/xhgui/XhguiCustom.php')) {
          require_once dirname(__FILE__) . '/xhgui/XhguiCustom.php';
          XhguiCustom::start();
          // register_shutdown_function(array('XhguiCustom', 'finish'));
        }
      }
    }
//  }
//}
*/

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

/*
// xhprof start
    if (preg_match("/-test/", $_SERVER['HTTP_HOST'])) {
      if ($_SERVER['REQUEST_URI'] != "/p404"
        ) {
        if (file_exists(dirname(__FILE__) . '/xhgui/XhguiCustom.php')) {
          XhguiCustom::finish();
          // register_shutdown_function(array('XhguiCustom', 'finish'));
        }
      }
    }
// xhprof end
*/
$response->send();

$kernel->terminate($request, $response);


