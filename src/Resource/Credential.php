<?php

namespace Rakuten\Connector\Resource;

/**
 * Interface Credential
 * @package Rakuten\Connector\Resource
 */
interface Credential
{
    /**
     * @return string
     */
    public function getApiKey();
    /**
     * @return string
     */
    public function getSignature();

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return mixed
     */
    public function getDocument();
}