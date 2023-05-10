<?php

namespace LenandoCatalogExport;

use LenandoCatalogExport\Providers\ExampleTemplateProvider;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class LenandoCatalogExportServiceProvider
 * @package LenandoCatalogExport\Providers
 */
class LenandoCatalogExportServiceProvider extends ServiceProvider
{
    const PLUGIN_NAME = "lenando";

    public function register()
    {
        $this->getApplication()->register(LenandoCatalogExportRouteServiceProvider::class);

        /** @var TemplateContainerContract $templateContainer */
        $templateContainer = pluginApp(TemplateContainerContract::class);
        $templateContainer->register("lenando", self::PLUGIN_NAME, ExampleTemplateProvider::class,"vdi");
    }
}
