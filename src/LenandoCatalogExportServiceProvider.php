<?php

namespace LenandoExport;

use LenandoExport\Providers\ExampleTemplateProvider;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class LenandoExportServiceProvider
 * @package LenandoExport\Providers
 */
class LenandoExportServiceProvider extends ServiceProvider
{
    const PLUGIN_NAME = "lenando";

    public function register()
    {
        $this->getApplication()->register(LenandoExportRouteServiceProvider::class);

        /** @var TemplateContainerContract $templateContainer */
        $templateContainer = pluginApp(TemplateContainerContract::class);

        $templateContainer->register("lenando", self::PLUGIN_NAME, ExampleTemplateProvider::class, "vdi");
    }
}
