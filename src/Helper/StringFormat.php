<?php
/**
 ************************************************************************
 * Copyright [2019] [GenComm]
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

namespace GenComm\Helper;

/**
 * Class StringFormat
 * @package GenComm\Helper
 */
class StringFormat
{
    /***
     * Remove all non digit character from string
     * @param string $value
     * @return string
     */
    public static function getOnlyNumbers($value)
    {
        return preg_replace('/\D/', '', $value);
    }

    /**
     * @param $string
     * @return string
     */
    public static function removeAccents($string)
    {
        return preg_replace([
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/",
            "/(Ñ)/"],
            explode(" ","a A e E i I o O u U n N"), $string);
    }
}
