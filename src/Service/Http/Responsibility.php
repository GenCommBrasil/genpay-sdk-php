<?php

namespace Rakuten\Connector\Service\Http;

use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Service\Http\Response\Response;

/**
 * Class Responsibility
 * @package Rakuten\Connector\Service\Http
 */
class Responsibility
{
    public static function http(Response $http, $class)
    {
        switch ($http->getStatus()) {
            case Status::OK:
                return $class::success($http);
            case Status::UNPROCESSABLE:
                /** returns success because only a few parameters  */
                return $class::error($http);
            case Status::BAD_REQUEST:
                /** returns success because only a few parameters  */
                return $class::error($http);
            case Status::NOT_FOUND:
                $error = $class::error($http);
                throw new RakutenException($error->getMessage(), $error->getCode());
            case Status::UNAUTHORIZED:
                $error = $class::error($http);
                throw new RakutenException($error->getMessage(), $error->getCode());
            case Status::BAD_GATEWAY:
                $error = $class::error($http);
                throw new RakutenException($error->getMessage(), $error->getCode());
            default:
                unset($class);
                throw new RakutenException(sprintf("Unknown Error in Responsibility: %s - Status: %s", $http->getResponse(), $http->getStatus()));
        }
    }
}
