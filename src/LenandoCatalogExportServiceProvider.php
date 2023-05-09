<?php

namespace LenandoCatalogExport;

use BasicCatalogExport\Providers\ExampleTemplateProvider;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class LenandoCatalogExportServiceProvider
 * @package LenandoCatalogExport\Providers
 */
class LenandoCatalogExportServiceProvider extends ServiceProvider
{
    const PLUGIN_NAME = "LenandoCatalogExport";

    public function register()
    {
        $this->getApplication()->register(LenandoCatalogExportRouteServiceProvider::class);

        /** @var TemplateContainerContract $templateContainer */
        $templateContainer = pluginApp(TemplateContainerContract::class);

        $templateContainer->register("variationExport", self::PLUGIN_NAME, ExampleTemplateProvider::class);
    }
}
