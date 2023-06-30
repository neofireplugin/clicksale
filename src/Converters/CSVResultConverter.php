<?php

namespace LenandoCatalogExport\Converters;

use Illuminate\Support\Arr;
use Plenty\Modules\Catalog\Contracts\UI\UIOptionsContract;
use Plenty\Modules\Catalog\Services\Collections\CatalogLazyCollection;
use Plenty\Modules\Catalog\Services\Converter\ResultConverters\BaseResultConverter;
use Plenty\Modules\Catalog\Services\FileHandlers\ResourceHandler;
use Plenty\Modules\Catalog\Services\UI\Options\UIOptions;
use LenandoCatalogExport\Helpers\LogHelper;
#use Plenty\Modules\Catalog\Services\Converter\ResultConverters\Defaults\Options\DelimiterOption;
#use Plenty\Modules\Catalog\Services\Converter\ResultConverters\Defaults\Options\EnclosureOption;
#use Plenty\Modules\Catalog\Services\Converter\ResultConverters\Defaults\Options\HeaderRowOption;
#use Plenty\Modules\Catalog\Services\Converter\ResultConverters\Defaults\Options\LineBreakOption;

/**
 * Class CSVResultConverter
 */
class CSVResultConverter extends BaseResultConverter
{
    const CHUNK_SIZE = 50;
    const MIME_TYPE = 'text/csv';
    const FILE_EXTENSION = 'csv';

    const OPTIONS_PATH = 'converter.csv';

    /**
     * Converts to the user's download file
     *
     * @param CatalogLazyCollection $collection
     * @param ResourceHandler $resourceHandler
     */
    protected function convertToDownload(CatalogLazyCollection $collection, ResourceHandler $resourceHandler)
    {

        /** @var LogHelper $logHelper */
        $logHelper = pluginApp(LogHelper::class);
        $delimiter = $this->getCSVDelimiter();
        $enclosure = $this->getCSVEnclosure();
        $hasHeader = Arr::get($this->settings, static::OPTIONS_PATH . '.headerRowIncluded', true);

        $array = $collection->toArray();
        // Add each row
        $collection->each(function ($chunk) use ($resourceHandler , $delimiter, $enclosure, &$hasHeader, $logHelper) {
            foreach ($chunk as $row) {

                if ($hasHeader) {
                    // Reminder: This will malfunction if the first row has a different number of columns
                    $hasHeader = false;
                }
                $resourceHandler->writeCSV($row, ',', '"');
            }
        });

    }


    /**
     * Gets the delimiter. Mutates it if needed.
     *
     * @return string
     */
    private function getCSVDelimiter(): string
    {
        $delimiter = Arr::get($this->settings, static::OPTIONS_PATH . '.delimiter');

        switch ($delimiter) {
            case 'semicolon':
                return ";";
            case 'pipe':
                return "|";
            case 'tab':
                return "\t";
            case 'comma':
            case null: // <-- Missing delimiter default is here
                return ";";
            default:
                return $delimiter;
        }
    }


    /**
     * Gets the enclosure. Mutates it if needed.
     *
     * @return string
     */
    private function getCSVEnclosure(): string
    {
        $enclosure = Arr::get($this->settings, static::OPTIONS_PATH . '.enclosure');

        switch ($enclosure) {
            case 'single':
                return "'"; // '
            case 'double':
            case null: // <-- Missing enclosure default is here
                return '"'; // "
            default:
                return $enclosure;
        }
    }


    /**
     * Converts to the marketplace export
     *
     * @param CatalogLazyCollection $collection
     * @return mixed
     */
    protected function convertToMarketplace(CatalogLazyCollection $collection)
    {
        $collection->each(function ($chunk) {
            // Send each chunk to the marketplace
        });

        return true;
    }

    /**
     * Will be used to identify the requested converter. Therefore it has to be unique in a specific template.
     *
     * @return string
     */
    public function getKey(): string
    {
        return 'csv_lenando';
    }

    /**
     * The string that will be visible to the user.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return 'CSV (lenando)';
    }

    /**
     * @return UIOptionsContract
     */
    public function getOptions(): UIOptionsContract
    {
        $options = pluginApp(UIOptions::class);

        /*
        $options
            ->add(pluginApp(DelimiterOption::class))
            ->add(pluginApp(EnclosureOption::class))
            ->add(pluginApp(LineBreakOption::class))
            ->add(pluginApp(HeaderRowOption::class));
        */

        return $options;
    }

}
