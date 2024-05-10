<?php

namespace ClicksaleExport;

use ClicksaleExport\Providers\ExampleTemplateProvider;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ClicksaleExportServiceProvider
 * @package ClicksaleExport\Providers
 */
class ClicksaleExportServiceProvider extends ServiceProvider
{
    const PLUGIN_NAME = "clicksale";

    public function register()
    {
        $this->getApplication()->register(ClicksaleExportRouteServiceProvider::class);

        /** @var TemplateContainerContract $templateContainer */
        $templateContainer = pluginApp(TemplateContainerContract::class);

        $templateContainer->register("clicksale", self::PLUGIN_NAME, ExampleTemplateProvider::class, "vdi");
    }
}
