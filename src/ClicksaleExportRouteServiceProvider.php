<?php

namespace ClicksaleExport;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router as WebRouter;

class ClicksaleExportRouteServiceProvider extends RouteServiceProvider
{
    public function map(ApiRouter $api, WebRouter $webRouter) {

        $webRouter->get('migration', 'ClicksaleExport\Migrations\CreateSettings@run');
        
        $api->version(['v1'], ['middleware' => ['oauth']], function ($router) {
            $router->get('example/export', ['uses' => 'ClicksaleExport\Controllers\VariationExportController@export']);
        });
    }
}
