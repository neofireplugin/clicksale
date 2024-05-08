<?php

namespace ClicksalePLugin;

use ClicksalePLugin\Providers\ExampleTemplateProvider;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Plugin\ServiceProvider;

/**
 * Class ClicksalePLuginServiceProvider
 * @package ClicksalePLugin\Providers
 */
class ClicksalePLuginServiceProvider extends ServiceProvider
{
    const PLUGIN_NAME = "clicksale";

    public function register()
    {
        $this->getApplication()->register(ClicksalePLuginRouteServiceProvider::class);

        /** @var TemplateContainerContract $templateContainer */
        $templateContainer = pluginApp(TemplateContainerContract::class);

        $templateContainer->register("clicksale", self::PLUGIN_NAME, ExampleTemplateProvider::class, "vdi");
    }
}
