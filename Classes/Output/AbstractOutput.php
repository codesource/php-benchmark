<?php

namespace CDSRC\PhpBenchmark\Output;


/* **********************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Matthias Toscanelli <m.toscanelli@code-source.ch>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 * ******************************************************************** */

use CDSRC\PhpBenchmark\Core\AbstractTest;

abstract class AbstractOutput
{

    /**
     * Render a test and output the content
     *
     * @param \CDSRC\PhpBenchmark\Core\AbstractTest $test
     *
     * @return void
     */
    abstract public function render(AbstractTest $test);

    /**
     * Prefix the rendering
     *
     * @return void
     */
    public function open(){}

    /**
     * Suffix the rendering
     *
     * @return void
     */
    public function close(){}
}