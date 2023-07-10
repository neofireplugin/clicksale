<?php

namespace LenandoExport\Mutators;

use LenandoExport\Helpers\LogHelper;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;
use LenandoExport\Services\SettingsService;

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

        $string = "";
        if(is_array($item["Bildlink"])) {
            foreach ($item["Bildlink"] as $link) {
                $string .= $link . ",";
            }
            $string = rtrim($string, ",");
        }
        $item["Bildlink"] = $string;

        $item["Produktlink"] = $item["Produktlink"]."?ReferrerID=".$this->settings->getSetting("referrerId");
        
        return $item;
    }
}

?>
