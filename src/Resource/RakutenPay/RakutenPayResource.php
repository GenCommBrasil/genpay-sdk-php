<?php

namespace Rakuten\Connector\Resource\RakutenPay;

use Rakuten\Connector\Resource\RakutenConnector;
use stdClass;

/**
 * Class RakutenPayResource
 * @package Rakuten\Connector\Resource\RakutenPay
 */
abstract class RakutenPayResource
{
    /**
     * @var RakutenConnector
     */
    protected $rakutenConnector;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * RakutenPayResource constructor.
     * @param RakutenConnector $rakutenConnector
     */
    public function __construct(RakutenConnector $rakutenConnector)
    {
        $this->rakutenConnector = $rakutenConnector;
        $this->data = new stdClass();
        $this->initialize();
    }

    /**
     * Initialize a new instance.
     */
    abstract protected function initialize();

    /**
     * @return stdClass
     */
    public function getData()
    {
        return $this->data;
    }
}
