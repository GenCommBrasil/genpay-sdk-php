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

namespace Rakuten\Connector\Enum;

use Rakuten\Connector\Helper\StringFormat;

/**
 * Class Address
 * @package Rakuten\Connector\Enum
 */
class Address extends Enum
{
    /**
     * Address Kind.
     *
     * @const string
     */
    const ADDRESS_BILLING = 'billing';

    /**
     * Address Kind.
     *
     * @const string
     */
    const ADDRESS_SHIPPING = 'shipping';

    /**
     * Standard country .
     *
     * @const string
     */
    const ADDRESS_COUNTRY = 'BRA';

    /**
     * Acronym for Acre
     */
    const AC = 'ACRE';

    /**
     * Acronym for Alagoas
     */
    const AL = 'ALAGOAS';

    /**
     * Acronym for Amazonas
     */
    const AM = 'AMAZONAS';

    /**
     * Acronym for Amapá
     */
    const AP = 'AMAPA';

    /**
     * Acronym for Bahia
     */
    const BA = 'BAHIA';

    /**
     * Acronym for Ceará
     */
    const CE = 'CEARA';

    /**
     * Acronym for Espírito Santo
     */
    const ES = 'ESPIRITO SANTO';

    /**
     * Acronym for Goiás
     */
    const GO = 'GOIAS';

    /**
     * Acronym for Maranhão
     */
    const MA = 'MARANHAO';

    /**
     * Acronym for Mato Grosso
     */
    const MT = 'MATO GROSSO';

    /**
     * Acronym for Mato Grosso do Sul
     */
    const MS = 'MATO GROSSO DO SUL';

    /**
     * Acronym for Minas Gerais
     */
    const MG = 'MINAS GERAIS';

    /**
     * Acronym for Pará
     */
    const PA = 'PARA';

    /**
     * Acronym for Paraíba
     */
    const PB = 'PARAIBA';

    /**
     * Acronym for Paraná
     */
    const PR = 'PARANA';

    /**
     * Acronym for Pernambuco
     */
    const PE = 'PERNAMBUCO';

    /**
     * Acronym for Piauí
     */
    const PI = 'PIAUI';

    /**
     * Acronym for Rio de Janeiro
     */
    const RJ = 'RIO DE JANEIRO';

    /**
     * Acronym for Rio Grande do Norte
     */
    const RN = 'RIO GRANDE DO NORTE';

    /**
     * Acronym for Rondônia
     */
    const RO = 'RONDONIA';

    /**
     * Acronym for Rio Grande do Sul
     */
    const RS = 'RIO GRANDE DO SUL';

    /**
     * Acronym for Roraima
     */
    const RR = 'RORAIMA';

    /**
     *  Acronym for Santa Catarina
     */
    const SC = 'SANTA CATARINA';

    /**
     *  Acronym for Sergipe
     */
    const SE = 'SERGIPE';

    /**
     *  Acronym for São Paulo
     */
    const SP = 'SAO PAULO';

    /**
     *  Acronym for Tocantins
     */
    const TO = 'TOCANTINS';

    /**
     *  Acronym for Distrito Federal
     */
    const DF = 'DISTRITO FEDERAL';

    /**
     * @param $state
     * @return string
     * @throws \ReflectionException
     */
    public static function convertUf($state)
    {
        if (!is_null($state) && strlen($state) == 2) {
            return strtoupper($state);
        }

        $state = strtoupper(StringFormat::removeAccents($state));
        return (is_string(parent::getType($state))) ?
            strtoupper(parent::getType($state)) :
            strtoupper($state);
    }
}