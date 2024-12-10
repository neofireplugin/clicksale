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

        $item["Eigenschaften"] = str_replace(';','|',$item["Eigenschaften"]);
        $item["Bildlink"] = str_replace(' ','|',$item["Bildlink"]);

        $item["Produktlink"] = $item["Produktlink"]."?ReferrerID=".$this->settings->getSetting("referrerId");

        $item["Kategorien"] = str_replace(';',' > ',implode('|',$item["Kategorien"]));
        
        if (isset($item["baseprice"])) {
            $parts = explode('€ / ', $item["baseprice"]);
            $pricePart = trim($parts[0]); // Numerischen Teil extrahieren
            $truncatedPrice = floor((float)str_replace(',', '.', $pricePart) * 100) / 100; // Abschneiden auf 2 Dezimalstellen
            $formattedPrice = number_format($truncatedPrice, 2, ',', '.'); // Formatieren mit 2 Dezimalstellen
            $item["baseprice"] = $formattedPrice . '€ / ' . (isset($parts[1]) ? $parts[1] : '');
        }
        
        return $item;
    }
}

?>
