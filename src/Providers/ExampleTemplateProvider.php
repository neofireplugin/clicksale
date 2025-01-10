<?php

namespace ClicksaleExport\Providers;

use ClicksaleExport\Mutators\imageMutator;
use ClicksaleExport\Callbacks\ExampleSkuCallback;
use ClicksaleExport\Converters\CSVResultConverter;
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
use ClicksaleExport\DynamicConfig\ExampleDynamicConfig;
use Plenty\Modules\Catalog\Services\Converter\Containers\ResultConverterContainer;

/**
 * Class ExampleTemplateProvider
 * @package ClicksaleExport\Providers
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
                    'key' => "name",
                    'type' => "text",
                    'lang' => "de",
                    'value' => null
                ]
            ]
        ]);
        
        /** @var SimpleTemplateField $description */
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


        /** @var SimpleTemplateField $tax */
       $tax = pluginApp(SimpleTemplateField::class, [
           'Steuersatz',
           'tax',
           'Steuersatz', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'variation-vat',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "vat",
                    'type' => "vat",
                    'fieldType' => "float",
                    'value' => null
                ]
            ]
        ]);

        /** @var SimpleTemplateField $price */
       $purchaseprice = pluginApp(SimpleTemplateField::class, [
           'Einkaufspreis',
           'partnerprice',
           'Einkaufspreis', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            []
        ]);

        /** @var SimpleTemplateField $id */
        $id = pluginApp(SimpleTemplateField::class, [
            'ID',
            'id',
            'ID', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'variation-id',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "id",
                    'type' => "variation",
                    'fieldType' => "float",
                    'value' => null
                ]
            ]
        ]);

       
        /** @var SimpleTemplateField $number */
        $number = pluginApp(SimpleTemplateField::class, [
            'Artikelnummer',
            'number',
            'Artikelnummer', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'variation-number',
                    'id' => null,
                    'isCombined' => false,
                    'key' => "number",
                    'type' => "variation",
                    'fieldType' => "string",
                    'value' => null
                ]
            ]
        ]);
        
        /** @var SimpleTemplateField $images */
       $images = pluginApp(SimpleTemplateField::class, [
           'Bildlink',
           'produktUrl',
           'Bildlink', // In a productive plugin this should be translated
            true,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'image-variationImages-list',
                    'id' => "variationImages",
                    'isCombined' => true,
                    'key' => "list",
                    'type' => "variation-images",
                    'value' => null,
                    'imageEntity' => "url",
                    'imageCount' => "10",
                    'additionalSources' => [
                        [
                            'type' => 'own-value',
                            'value' => '|'
                        ],
                        [
                            'fieldId' => 'image-itemImages-list',
                            'id' => "itemImages",
                            'key' => "list",
                            'type' => "item-images",
                            'value' => null,
                            'imageEntity' => "url",
                            'imageCount' => "10"
                        ]
                    ]     
                ]
            ]
        ]);

        
        /** @var SimpleTemplateField $manufacturer */
       $manufacturer = pluginApp(SimpleTemplateField::class, [
           'Hersteller',
           'manufacturer',
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

        /** @var SimpleTemplateField $manufactureraddress */
        $manufactureraddress = pluginApp(SimpleTemplateField::class, [
            'Herstelleradresse', // Feldname
            'manufactureraddress',  // Key
            'Herstelleradresse', // Beschriftung (sollte im produktiven Plugin übersetzt werden)
            true,                // Aktiv
            false,               // Deaktivierbar
            false,               // Sortierbar
            [],                  // Additional Data
            [
                [
                    'fieldId' => 'item-manufacturerLegalName',
                    'id' => null,
                    'isCombined' => true,
                    'key' => "legalName",
                    'type' => "manufacturer",
                    'value' => '',
                    'fieldType' => "string",
                    'additionalSources' => [
                        [
                            'type' => 'own-value',
                            'value' => '<br>'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'item-manufacturerStreet',
                            'type' => 'manufacturer',
                            'key' => 'street',
                            'id' => null,
                            'fieldType' => 'string'
                        ],
                        [
                            'type' => 'own-value',
                            'value' => '&nbsp;'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'item-manufacturerHouseNo',
                            'type' => 'manufacturer',
                            'key' => 'houseNo',
                            'id' => null,
                            'fieldType' => 'string'
                        ],
                        [
                            'type' => 'own-value',
                            'value' => '<br>'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'item-manufacturerPostcode',
                            'type' => 'manufacturer',
                            'key' => 'postcode',
                            'id' => null,
                            'fieldType' => 'string'
                        ],
                        [
                            'type' => 'own-value',
                            'value' => '&nbsp;'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'item-manufacturerTown',
                            'type' => 'manufacturer',
                            'key' => 'town',
                            'id' => null,
                            'fieldType' => "string"
                        ],
                        [
                            'type' => 'own-value',
                            'value' => '&nbsp;'
                        ],
                        [
                            'value' => '',
                            'fieldId' => 'item-manufacturerCountryName',
                            'type' => 'manufacturer',
                            'key' => 'manufacturerCountryName',
                            'id' => null,
                            'fieldType' => 'string'
                        ]
                    ]
                ]
            ]
        ]);

        /** @var SimpleTemplateField $price */
       $notice = pluginApp(SimpleTemplateField::class, [
           'Sicherheitshinweis',
           'notice',
           'Sicherheitshinweis', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            []
        ]);

        /** @var SimpleTemplateField $energyclass */
       $energyclass = pluginApp(SimpleTemplateField::class, [
           'Energieklasse',
           'energyclass',
           'Energieklasse', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            []
        ]);

        /** @var SimpleTemplateField $energylable */
       $energylable = pluginApp(SimpleTemplateField::class, [
           'Energielabel',
           'energylable',
           'Energielabel', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            []
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
                    'id' => '',
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
        
        /** @var SimpleTemplateField $ean */
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
        
        /** @var SimpleTemplateField $shipping */
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


      
        /** @var SimpleTemplateField $baseprice */
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
                    'fieldId' => 'stock-0-netto',
                    'id' => '0',
                    'isCombined' => false,
                    'key' => 'stockNet',
                    'type' => 'stock',
                    'value' => '0'
                ]
            ]
        ]);

        /** @var SimpleTemplateField $energyclass */
       $property = pluginApp(SimpleTemplateField::class, [
           'Eigenschaften',
           'property',
           'Eigenschaften', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'attribute-combinationExternalName',
                    'id' => null,
                    'isCombined' => false,
                    'key' => 'combinationExternalName',
                    'type' => 'variationAttributeName',
                    'value' => null,
                    'lang' => 'de'
                ]
            ]
        ]);        
        /** @var SimpleTemplateField $energyclass */
       $group = pluginApp(SimpleTemplateField::class, [
           'Gruppe',
           'group',
           'Gruppe', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'item-id',
                    'id' => null,
                    'isCombined' => false,
                    'key' => 'id',
                    'type' => 'item',
                    'value' => null,
                    'lang' => 'de',
                    'client' => 'de'
                ]
            ]
        ]);

        /** @var SimpleTemplateField $energyclass */
       $categories = pluginApp(SimpleTemplateField::class, [
           'Kategorien',
           'categories',
           'Kategorien', // In a productive plugin this should be translated
            false,
            false,
            false,
            [],
            [
                [
                    'fieldId' => 'variationCategory-path',
                    'id' => null,
                    'isCombined' => false,
                    'key' => 'path',
                    'type' => 'variationCategory',
                    'value' => null,
                    'lang' => 'de',
                    'client' => 'de'
                ]
            ]
        ]);

        

        $simpleGroup->addGroupField($name);
        $simpleGroup->addGroupField($description);
        $simpleGroup->addGroupField($price);
        $simpleGroup->addGroupField($tax);
        $simpleGroup->addGroupField($purchaseprice);
        $simpleGroup->addGroupField($id);
        $simpleGroup->addGroupField($number);
        $simpleGroup->addGroupField($images);
        $simpleGroup->addGroupField($energyclass);
        $simpleGroup->addGroupField($energylable);
        $simpleGroup->addGroupField($manufacturer);
        $simpleGroup->addGroupField($manufactureraddress);
        $simpleGroup->addGroupField($notice);
        $simpleGroup->addGroupField($link);
        $simpleGroup->addGroupField($ean);
        $simpleGroup->addGroupField($shipping);
        $simpleGroup->addGroupField($baseprice);
        $simpleGroup->addGroupField($shipping);
        $simpleGroup->addGroupField($stock);
        $simpleGroup->addGroupField($property);
        $simpleGroup->addGroupField($group);
        $simpleGroup->addGroupField($categories);

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

        $container->addFilterBuilder($filterBuilderFactory->VariationHasAtLeastOneAvailability());
        $container->addFilterBuilder($filterBuilderFactory->variationHasAtLeastOneBundleType());
        $container->addFilterBuilder($filterBuilderFactory->variationIsInAtLeastOneCategory());
        $container->addFilterBuilder($filterBuilderFactory->variationIsInCategories());
        $container->addFilterBuilder($filterBuilderFactory->variationHasAtLeastOneClient());
        $container->addFilterBuilder($filterBuilderFactory->variationHasClients());
        $container->addFilterBuilder($filterBuilderFactory->variationHasImage());
        $container->addFilterBuilder($filterBuilderFactory->itemBelongsToAtLeastOneAmazonFlatFile());
        $container->addFilterBuilder($filterBuilderFactory->itemCreatedAt());
        $container->addFilterBuilder($filterBuilderFactory->itemHasAtLeastOneFlagOne());
        $container->addFilterBuilder($filterBuilderFactory->itemHasAtLeastOneFlagTwo());
        $container->addFilterBuilder($filterBuilderFactory->itemHasAtLeastOneId());
        $container->addFilterBuilder($filterBuilderFactory->itemIsType());
        $container->addFilterBuilder($filterBuilderFactory->itemUpdatedAt());
        $container->addFilterBuilder($filterBuilderFactory->itemHasAtLeastOneManufacturer());
        $container->addFilterBuilder($filterBuilderFactory->variationIsVisibleForAtLeastOneMarket());
        $container->addFilterBuilder($filterBuilderFactory->variationIsVisibleForMarkets());
        $container->addFilterBuilder($filterBuilderFactory->variationHasAtLeastOnePropertySelection());
        $container->addFilterBuilder($filterBuilderFactory->variationHasPropertySelections());
        $container->addFilterBuilder($filterBuilderFactory->variationHasSku());
        $container->addFilterBuilder($filterBuilderFactory->variationHasAtLeastOneTag());
        $container->addFilterBuilder($filterBuilderFactory->variationHasTags());
        $container->addFilterBuilder($filterBuilderFactory->variationCreatedAt());
        $container->addFilterBuilder($filterBuilderFactory->variationIsActive());
        $container->addFilterBuilder($filterBuilderFactory->variationIsMain());
        $container->addFilterBuilder($filterBuilderFactory->variationUpdatedAt());
        $container->addFilterBuilder($filterBuilderFactory->variationRelatedUpdatedAt());
        $container->addFilterBuilder($filterBuilderFactory->salesPriceUpdatedAt());
        $container->addFilterBuilder($filterBuilderFactory->stockUpdatedAt());
        
        
    
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

        return pluginApp(imageMutator::class);

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
