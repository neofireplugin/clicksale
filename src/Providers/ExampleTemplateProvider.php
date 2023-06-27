<?php

namespace LenandoCatalogExport\Providers;

use LenandoCatalogExport\Callbacks\ExampleSkuCallback;
use LenandoCatalogExport\Converters\CSVResultConverter;
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
use Plenty\Modules\Pim\Catalog\Variation\Filters\FilterBuilderFactory;
use Plenty\Modules\Catalog\Contracts\CatalogDynamicConfigContract;
use LenandoCatalogExport\DynamicConfig\ExampleDynamicConfig;
use Plenty\Modules\Catalog\Services\Converter\Containers\ResultConverterContainer;

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
            'Produktname',
            'name',
            'Produktname', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'itemText-name1',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "name1",
                    'type' => "text",
                    'lang' => "de",
                    'value' => null
                ]
            ]
        ]);
        
        /** @var SimpleTemplateField $name */
        $description = pluginApp(SimpleTemplateField::class, [
            'Beschreibung',
            'description',
            'Beschreibung', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'itemText-description',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "description",
                    'type' => "text",
                    'lang' => "de",
                    'value' => null
                ]
            ]
        ]);

        /** @var SimpleTemplateField $price */
       $price = pluginApp(SimpleTemplateField::class, [
           'Preis',
           'price',
           'Preis', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [    
                    'isCombined' => false,
                    'value' => null,
                    'fieldId' => 'salesPrice-salesPrice',
                    'type' => "sales-price",
                    'key' => "salesPrice",
                    'currency' => "EUR",
                    'id' => "1"
                    
                    
                ]
            ]
        ]);

        
        /** @var SimpleTemplateField $price */
       $image = pluginApp(SimpleTemplateField::class, [
           'Bildlink',
           'produktUrl',
           'Bildlink', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'image-variationImages-single',
                    'id' => "variationImages",
                    'isCombined' => false,
                    'key' => "single",
                    'type' => "variation-images",
                    'value' => null,
                    'imageEntity' => "url",
                    'imagePosition' => "0"
                ]
            ]
        ]);

      
        
        /** @var SimpleTemplateField $price */
       $manufacturer = pluginApp(SimpleTemplateField::class, [
           'Hersteller',
           'manufactuerer',
           'Hersteller', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'item-manufacturerName',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "name",
                    'type' => "manufacturer",
                    'value' => ''
                ]
            ]
        ]);

        /** @var SimpleTemplateField $link */
        $link = pluginApp(SimpleTemplateField::class, [
            'Produktlink',
            'link',
            'Produktlink', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'variation-webshopUrl',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "url",
                    'type' => "webshop-url",
                    'value' => null,
                    'client' => null,
                    'lang' => "de",
                    'referrer' => null
                ]
            ]
        ]);
        
        /** @var SimpleTemplateField $sku */
        $ean = pluginApp(SimpleTemplateField::class, [
            'EAN',
            'barcode',
            'EAN', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'barcode-1',
                    'id' => 1,
                    'isCombined' => false,
                    'key' => "code",
                    'type' => "barcode-code",
                    'value' => ''
                ]
            ]
        ]);
        
        /** @var SimpleTemplateField $sku */
        $shipping = pluginApp(SimpleTemplateField::class, [
            'Versandkosten',
            'shipping',
            'Versandkosten', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    
                    'type' => "own-value",
                    'value' => '0,00',
                    'isCombined' => 'true',
                    'id' => null
                ]
            ]
        ]);


      
        /** @var SimpleTemplateField $sku */
        $baseprice = pluginApp(SimpleTemplateField::class, [
            'Grundpreis',
            'baseprice',
            'Grundpreis', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'isCombined' => 'true',
                    'value' => '',
                    'fieldId' => 'basePrice-price',
                    'type' => "base-price",
                    'key' => "price",
                    'id' => '1',
                    'currency' => 'EUR',
                    'additionalSources' => [
                        [
                            'type' => "own-value",
                            'value' => ' € / '
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'basePrice-amount',
                            'type' => "base-price",
                            'key' => "amount",
                            'id' => '1'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'basePrice-unit-name',
                            'type' => "base-price",
                            'key' => "unit-name",
                            'id' => '1',
                            'lang' => 'de'
                        ]
                    ]
                ]
            ]
        ]);

        
    
        /** @var SimpleTemplateField $stock */
        $stock = pluginApp(SimpleTemplateField::class, [
            'Bestand',
            'stock',
            'Bestand', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'stock-0-physical',
                    'id' => '0',
                    'isCombined' => false,
                    'key' => 'stockPhysical',
                    'type' => 'stock',
                    'value' => '0'
                ]
            ]
        ]);

        $simpleGroup->addGroupField($name);
        $simpleGroup->addGroupField($description);
        $simpleGroup->addGroupField($price);
        $simpleGroup->addGroupField($image);
        $simpleGroup->addGroupField($manufacturer);
        $simpleGroup->addGroupField($link);
        $simpleGroup->addGroupField($ean);
        $simpleGroup->addGroupField($shipping);
        $simpleGroup->addGroupField($baseprice);
        $simpleGroup->addGroupField($shipping);
        $simpleGroup->addGroupField($stock);

        $templateGroupContainer->addGroup($simpleGroup);

        return $templateGroupContainer;
    }

    public function getFilterContainer(): CatalogFilterBuilderContainer
    {
        /** @var CatalogFilterBuilderContainer $container */
        $container = pluginApp(CatalogFilterBuilderContainer::class);
        /** @var FilterBuilderFactory $filterBuilderFactory */
        $filterBuilderFactory = pluginApp(FilterBuilderFactory::class);

        $variationIsActiveFilter = $filterBuilderFactory->variationIsActive();
        $variationIsActiveFilter->setShouldBeActive(true);
        $container->addFilterBuilder($variationIsActiveFilter);

        return $container;
    }

    public function getCustomFilterContainer(): CatalogFilterBuilderContainer
    {
        /** @var CatalogFilterBuilderContainer $container */
        $container = pluginApp(CatalogFilterBuilderContainer::class);
        /** @var FilterBuilderFactory $filterBuilderFactory */
        $filterBuilderFactory = pluginApp(FilterBuilderFactory::class);

        $itemHasIdsFilter = $filterBuilderFactory->itemHasAtLeastOneId();
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

    public function DefaultResultConverterContainer(): ResultConverterContainer
    {
        /** @var ResultConverterContainer $container */
        $container = pluginApp(ResultConverterContainer::class);
        /** @var CSVResultConverter $csvConverter */
        $csvConverter = pluginApp(CSVResultConverter::class);
        $container->addResultConverter($csvConverter);
        return $container;
    }
}
