<?php
/**
 * Configuração de rotas
 *
 * @category Routes
 * @package  Thumburl
 * @author   Flavio Zantut  <flaviozantut@gmail.com>
 * @license  MIT License <http://www.opensource.org/licenses/mit>
 * @link     http://link.com
 */

/**
 * * Documentação do Thumburl
 * Para acessar use a url http://mysite.com/thumburl/docs
 * 
 */
Route::any('(:bundle)/docs/(:all?)', function($route = 'index.html') {
	\Config::set('application.profiler', false);
	$mime =  File::extension(Bundle::path('thumburl').'docs/' . $route);
	$response = File::get(Bundle::path('thumburl').'docs/' . $route);
	$headers = array(
            'Content-type' => Config::get("mimes.{$mime}"),
        );
	return Response::make($response, 200, $headers);   
});


/**
 * * Documentação do Thumburl
 * Para acessar use a url http://mysite.com/thumburl/docs
 * 
 */
Route::any('(:bundle)/(:all?)', function($route = '') {
    $route= explode('/', $route);
    $method = isset($route[0])?$route[0]:'false';
    array_shift($route);

    return Controller::call("thumburl::thumburl@{$method}", $route);
});
