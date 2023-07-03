<?php

namespace LenandoExport\Helpers;

use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

class LogHelper
{
    use Loggable;

    public function logTesting($identifikator, $message, $value)
    {
        $this->getLogger($identifikator)->error($message, $value);
    }

    public function logDebug($identifikator, $message, $value, $refType = "", $refValue = "")
    {

        if (empty($refType)) {
            $this->getLogger($identifikator)->debug($message, $value);
        } else {
            $this->getLogger($identifikator)->setReferenceType($refType)->setReferenceValue($refValue)->debug($message, $value);
        }
    }

    public function logError($identifikator, $message, $value, $refType = "", $refValue = "")
    {
        if (empty($refValue)) {
            $this->getLogger($identifikator)->error($message, $value);
        } else {
            $this->getLogger($identifikator)->setReferenceType($refType)->setReferenceValue($refValue)->error($message, $value);
        }
    }

    public function logUser($identifikator, $message, $value)
    {
        $this->getLogger($identifikator)
            ->error($message, $value);
    }

    public function logRef($identifikator, $message, $value, $level, string $refType, int $refValue)
    {
        $configRepo = pluginApp(ConfigRepository::class);
        $configLogLevel = $configRepo->get("Schuhe24.global.loglevel");
        if ($level <= $configLogLevel) {
            $this->getLogger($identifikator)
                ->addReference($refType, $refValue)
                ->error($message, $value);
        }
    }

    public function log($identifikator, $message, $value, $level)
    {
        $configRepo = pluginApp(ConfigRepository::class);
        $configLogLevel = $configRepo->get("Schuhe24.global.loglevel");
        if ($level <= $configLogLevel) {
            $this->getLogger($identifikator)
                ->error($message, $value);
        }
    }

    public function logInfo($identifikator, $message, $value, $refType = "action", $refValue = "")
    {
        if (empty($refValue)) {
            $this->getLogger($identifikator)->info($message, $value);
        } else {
            $this->getLogger($identifikator)->setReferenceType($refType)->setReferenceValue($refValue)->info($message, $value);
        }
    }


}
