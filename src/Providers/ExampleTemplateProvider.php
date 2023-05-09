<?php

namespace LenandoCatalogExport\Providers;

use LenandoCatalogExport\Callbacks\ExampleSkuCallback;
use LenandoCatalogExport\Mutators\ExamplePostMutator;
use Plenty\Modules\Catalog\Containers\CatalogTemplateFieldContainer;
use Plenty\Modules\Catalog\Containers\Filters\CatalogFilterBuilderContainer;
use Plenty\Modules\Catalog\Containers\TemplateGroupContainer;
use Plenty\Modules\Catalog\Contracts\CatalogMutatorContract;
use Plenty\Modules\Catalog\Models\CombinedTemplateField;
use Plenty\Modules\Catalog\Models\ComplexTemplateField;
use Plenty\Modules\Catalog\Models\SimpleTemplateField;
use Plenty\Modules\Catalog\Models\TemplateGroup;
use Plenty\Modules\Catalog\Templates\Providers\AbstractGroupedTemplateProvider;
use Plenty\Modules\Item\Catalog\ExportTypes\Variation\Filters\Builders\Item\ItemHasIds;
use Plenty\Modules\Item\Catalog\ExportTypes\Variation\Filters\Builders\VariationBase\VariationIsActive;
use Plenty\Modules\Item\Catalog\ExportTypes\Variation\Filters\Builders\VariationFilterBuilderFactory;

/**
 * Class ExampleTemplateProvider
 * @package LenandoCatalogExport\Providers
 */
class ExampleTemplateProvider extends AbstractGroupedTemplateProvider
{
    public function getTemplateGroupContainer(): TemplateGroupContainer
    {
        /** @var TemplateGroupContainer $templateGroupContainer */
        $templateGroupContainer = pluginApp(TemplateGroupContainer::class);

        // Simple fields

        /** @var TemplateGroup $simpleGroup */
        $simpleGroup = pluginApp(TemplateGroup::class,
            [
                "identifier" => "groupOne",
                "label" => "Simple fields" // In a productive plugin this should be translated
            ]);

        /** @var SimpleTemplateField $name */
        $name = pluginApp(SimpleTemplateField::class, [
            'variationName',
            'name',
            'Produktname', // In a productive plugin this should be translated
            true
        ]);

        /** @var SimpleTemplateField $price */
        $price = pluginApp(SimpleTemplateField::class, [
            'price',
            'price',
            'Preis', // In a productive plugin this should be translated
            true
        ]);

        /** @var SimpleTemplateField $sku */
        $sku = pluginApp(SimpleTemplateField::class, [
            'barcode',
            'barcode',
            'EAN', // In a productive plugin this should be translated
            true
        ]);
    
        /** @var SimpleTemplateField $stock */
        $stock = pluginApp(SimpleTemplateField::class, [
            'stock',
            'stock',
            'Bestand', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'stock-0',
                    'id' => 0,
                    'isCombined' => false,
                    'key' => null,
                    'type' => "stock",
                    'value' => null
                ]
            ]
        ]);

        $simpleGroup->addGroupField($name);
        $simpleGroup->addGroupField($price);
        $simpleGroup->addGroupField($sku);
        $simpleGroup->addGroupField($stock);

        $templateGroupContainer->addGroup($simpleGroup);

        return $templateGroupContainer;
    }

    public function getFilterContainer(): CatalogFilterBuilderContainer
    {
        /** @var CatalogFilterBuilderContainer $container */
        $container = pluginApp(CatalogFilterBuilderContainer::class);
        /** @var VariationFilterBuilderFactory $filterBuilderFactory */
        $filterBuilderFactory = pluginApp(VariationFilterBuilderFactory::class);

        $variationIsActiveFilter = $filterBuilderFactory->variationIsActive();
        $variationIsActiveFilter->setShouldBeActive(true);
        $container->addFilterBuilder($variationIsActiveFilter);

        return $container;
    }

    public function getCustomFilterContainer(): CatalogFilterBuilderContainer
    {
        /** @var CatalogFilterBuilderContainer $container */
        $container = pluginApp(CatalogFilterBuilderContainer::class);
        /** @var VariationFilterBuilderFactory $filterBuilderFactory */
        $filterBuilderFactory = pluginApp(VariationFilterBuilderFactory::class);

        $itemHasIdsFilter = $filterBuilderFactory->itemHasIds();
        $container->addFilterBuilder($itemHasIdsFilter);

        return $container;
    }

    public function isPreviewable(): bool
    {
        // If you are not sure what this does please check the guide for DynamicConfig before setting this to true
        // In your productive plugin
        return true;
    }

    public function getPostMutator(): CatalogMutatorContract
    {
        return pluginApp(ExamplePostMutator::class);
    }
}
