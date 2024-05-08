<?php

namespace ClicksalePLugin;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router as WebRouter;

class ClicksalePLuginRouteServiceProvider extends RouteServiceProvider
{
    public function map(ApiRouter $api, WebRouter $webRouter) {

        $webRouter->get('migration', 'ClicksalePLugin\Migrations\CreateSettings@run');
        
        $api->version(['v1'], ['middleware' => ['oauth']], function ($router) {
            $router->get('example/export', ['uses' => 'ClicksalePLugin\Controllers\VariationExportController@export']);
        });
    }
}
