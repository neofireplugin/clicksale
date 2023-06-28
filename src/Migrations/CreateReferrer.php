<?php

namespace Lenando\Migrations;

use Plenty\Modules\Order\Referrer\Contracts\OrderReferrerRepositoryContract;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;

/**
 * Class CreatePaymentMethod
 */
class CreateReferrer
{
    /**
     * @var SettingsService
     */
    private $settings;

    /**
     * CreatePaymentMethod constructor.
     *
     * @param SettingsService $settings
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settings = $settingsService;
    }

    /**
     * The run method will register the payment method when the migration runs.
     */
    public function run()
    {

        /** @var $orderReferrer OrderReferrerRepositoryContract */
        $orderReferrer = pluginApp(OrderReferrerRepositoryContract::class);

        $referrerId = "";

        $result = $orderReferrer->getList();
        foreach ($result as $referrer) {

            if($referrer["name"] == "Lenando") {
                $referrerId = $referrer["id"];

          
                break;
            }

        }

        if(empty($referrerId)) {

            $referrerSettings = [
                "isEditable" => true,
                "backendName" => "Lenando",
                "name" => "Lenando",
                "isFilterable" => true,
                "origin" => "Lenando",
                "showInLeads" => false
            ];
            $createdReferrer = $orderReferrer->create($referrerSettings);
            $referrerId = $createdReferrer->id;
        }

        $this->settings->saveSetting("referrerId", $referrerId);

    }

}
