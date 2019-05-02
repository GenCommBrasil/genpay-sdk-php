<?php
/**
 ************************************************************************
 * Copyright [2019] [RakutenConnector]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

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
            case Status::FORBIDDEN:
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
