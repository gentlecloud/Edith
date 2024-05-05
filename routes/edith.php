<?php

Edith::routes();

// 不需要登录认证的路由
Route::group([
    'namespace' => 'App\\Newly\\Controllers'
], function ($router) {
    $router->get('api/admin/captcha', 'AuthController@getCaptcha')->name('api/admin/captcha');
});
