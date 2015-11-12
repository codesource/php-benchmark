<?php

namespace CDSRC\PhpBenchmark\Tests;


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

class StringTest extends AbstractTest
{

    /**
     * String references
     *
     * @var array
     */
    protected $references;

    /**
     * StringTest constructor.
     *
     * @param int $iterations
     */
    public function __construct($iterations = 1000000)
    {
        parent::__construct('String comparison', '', $iterations);
        $this->references = array(
            '',
            str_repeat('=', 10),
            str_repeat('=', 100),
            str_repeat('=', 1000)
        );
    }

    /**
     * Run test and populate data
     *
     * @return AbstractTest
     */
    public function run()
    {
        $this->data = array(
            'header' => array('Function', 'Empty String' , 'Small string (10)', 'Medium string (100)', 'Large string (1000)', 'Total', 'Percentage'),
            'rows' => array()
        );
        $this->data['rows'] = array_merge($this->data['rows'], $this->testEmptyStringDetection());
        return $this;
    }


    /**
     * Test if on
     *
     * @return array
     */
    protected function testEmptyStringDetection()
    {
        $data = array();
        
        // Test against empty()
        $currentData = array('if(empty($string))');
        foreach ($this->references as $reference) {
            $start = microtime(true);
            for($i=0;$i<$this->iterations; $i++) {
                if (empty($reference)) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ===
        $currentData = array('if($string === \'\')');
        foreach ($this->references as $reference) {
            $start = microtime(true);
            for($i=0;$i<$this->iterations; $i++) {
                if ($reference === '') {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ==
        $currentData = array('if($string == \'\')');
        foreach ($this->references as $reference) {
            $start = microtime(true);
            for($i=0;$i<$this->iterations; $i++) {
                if ($reference == '') {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against (bool)
        $currentData = array('if((bool)$string)');
        foreach ($this->references as $reference) {
            $start = microtime(true);
            for($i=0;$i<$this->iterations; $i++) {
                if ((bool)$reference) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ($string)
        $currentData = array('if($string)');
        foreach ($this->references as $reference) {
            $start = microtime(true);
            for($i=0;$i<$this->iterations; $i++) {
                if ($reference) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        $this->setTotalAndPercentage($data);
        $this->addSectionLine($data, 'Empty String Detection');

        return $data;
    }
}