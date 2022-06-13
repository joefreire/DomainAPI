<?php

//TODO: Implement ACL 
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');


$router->group(['prefix' => 'me', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'AuthController@me');
    $router->post('/refresh', 'AuthController@refresh');
});   

$router->group(['prefix' => 'domain', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/',  ['uses' => 'DomainController@index']);
    $router->get('/{domain}', ['uses' => 'DomainController@show']);
    $router->get('/export/all', ['uses' => 'DomainController@export']);
    $router->post('/', ['uses' => 'DomainController@store']);
    $router->post('/bulk', ['uses' => 'DomainController@bulk']);
    $router->delete('/{domain}', ['uses' => 'DomainController@destroy']);
    $router->patch('/{domain}', ['uses' => 'DomainController@update']);
});
