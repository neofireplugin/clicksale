<?php

namespace LenandoCatalogExport\Mutators;

use LenandoCatalogExport\Helpers\LogHelper;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;
use LenandoCatalogExport\Services\SettingsService;
use Plenty\Modules\Order\Referrer\Contracts\OrderReferrerRepositoryContract;

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

        $orderReferrer = pluginApp(OrderReferrerRepositoryContract::class);
        $lenandoReferrer = $orderReferrer->findWhere(['backendName' => 'lenando']);

        if (!empty($lenandoReferrers)) {
            $item["Produktlink"] = $item["Produktlink"]."?referrerId=".$lenandoReferrers[0]->id;
        }else{
            $item["Produktlink"] = '';
        }

        
        return $item;
    }
}

?>
