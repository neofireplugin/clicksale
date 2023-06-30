<?php

namespace LenandoCatalogExport\Mutators;

use LenandoCatalogExport\Helpers\LogHelper;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;

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

        if(is_array($item["Bilder"])) {
        $item["Bilder"] = implode(",", $item["Bilder"]);
        }

        $item["Produktlink"] = $item["Produktlink"]."?referrerId=".$this->settings->get("referrerId");

        return $item;
    }
}

?>
