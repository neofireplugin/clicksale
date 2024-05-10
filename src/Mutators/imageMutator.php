<?php

namespace ClicksaleExport\Mutators;

use ClicksaleExport\Helpers\LogHelper;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;
use ClicksaleExport\Services\SettingsService;

class imageMutator implements CatalogMutatorContract
{

    private $settings;

    public function __construct(SettingsService $settingsService) {

        $this->settings = $settingsService;

    }

    public function mutate($item)
    {

        /** @var LogHelper $logHelper */
        $logHelper = pluginApp(LogHelper::class);

        $item["Bildlink"] = str_replace(' ','|',$item["Bildlink"]);

        $item["Produktlink"] = $item["Produktlink"]."?ReferrerID=".$this->settings->getSetting("referrerId");
        
        return $item;
    }
}

?>
