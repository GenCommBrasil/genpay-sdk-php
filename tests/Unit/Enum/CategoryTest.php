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

namespace GenComm\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Category;
use GenComm\Exception\GenCommException;

/**
 * Class CategoryTest
 * @package GenComm\Tests\Unit\Enum
 */
class CategoryTest extends TestCase
{
    public function testDefaultCategory()
    {
        $category = Category::getDefaultCategory();

        $this->assertCount(2, $category);
        $this->assertEquals('Outros', $category[Category::NAME]);
        $this->assertEquals('99', $category[Category::ID]);
    }

    public function testGettingCategory()
    {
        $category = Category::getCategory('01', 'Categoria Teste');

        $this->assertCount(2, $category);
        $this->assertEquals('Categoria Teste', $category[Category::NAME]);
        $this->assertEquals('01', $category[Category::ID]);
    }
}
