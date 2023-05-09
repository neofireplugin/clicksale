<?php

namespace LenandoCatalogExport\Mutators;

use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;

class ExamplePostMutator implements CatalogMutatorContract
{
    public function mutate($item)
    {
      

        return $item;
    }
}
