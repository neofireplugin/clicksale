<?php

namespace LenandoCatalogExport;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router as WebRouter;

class LenandoCatalogExportRouteServiceProvider extends RouteServiceProvider
{
    public function map(ApiRouter $api, WebRouter $webRouter) {

        $router->get('migration', 'LenandoCatalogExport\Migrations\CreateSettings@run');
        
        $api->version(['v1'], ['middleware' => ['oauth']], function ($router) {
            $router->get('example/export', ['uses' => 'LenandoCatalogExport\Controllers\VariationExportController@export']);
        });
    }
}
