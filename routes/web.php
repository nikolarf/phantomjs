<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use JonnyW\PhantomJs\Client;

Route::get('/', function () {
    
    $client = Client::getInstance();
    if (PHP_OS == 'WINNT') {
        $client->getEngine()->setPath(base_path() . '\\bin\\phantomjs.exe');
    } else {
        $client->getEngine()->setPath(base_path() . '/bin/phantomjs');
    }
    
    $width  = 800;
    $height = 600;
    $top    = 0;
    $left   = 0;
    
    /** 
     * @see JonnyW\PhantomJs\Http\CaptureRequest
     **/
    $request = $client->getMessageFactory()->createCaptureRequest('https://google.com', 'GET');
    $file = 'screenshots/file.jpg';
    $request->setOutputFile($file);
    $request->setViewportSize($width, $height);
    $request->setCaptureDimensions($width, $height, $top, $left);

    /** 
     * @see JonnyW\PhantomJs\Http\Response 
     **/
    $response = $client->getMessageFactory()->createResponse();

    // Send the request
    $client->send($request, $response);

    echo ('<img src="screenshots/file.jpg">');

});
