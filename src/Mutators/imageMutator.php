<?php

namespace LenandoCatalogExport\Mutators;

use LenandoCatalogExport\Helpers\LogHelper;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;

class imageMutator implements CatalogMutatorContract
{

    public function mutate($item)
    {

        /** @var LogHelper $logHelper */
        $logHelper = pluginApp(LogHelper::class);

        $item["images"] = implode(",", $item["images"]);
        $item["link"] = $item["link"]."?referrerId=122";

        return $item;
    }
}

?>
