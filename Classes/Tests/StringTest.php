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
    }

    /**
     * Run test and populate data
     *
     * @return AbstractTest
     */
    public function run()
    {
        $this->data = array_merge($this->data, $this->testEmptyStringDetection());
        $this->data = array_merge($this->data, $this->testStringStartWithDetection());

        return $this;
    }


    /**
     * Test if string is empty
     *
     * @return array
     */
    protected function testEmptyStringDetection()
    {
        $data = array();
        $references = array(
            '',
            str_repeat('=', 10),
            str_repeat('=', 100),
            str_repeat('=', 1000)
        );

        // Test against empty()
        $currentData = array('if(empty($string))');
        foreach ($references as $reference) {
            $start = microtime(true);
            for ($i = 0; $i < $this->iterations; $i++) {
                if (empty($reference)) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ===
        $currentData = array('if($string === \'\')');
        foreach ($references as $reference) {
            $start = microtime(true);
            for ($i = 0; $i < $this->iterations; $i++) {
                if ($reference === '') {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ==
        $currentData = array('if($string == \'\')');
        foreach ($references as $reference) {
            $start = microtime(true);
            for ($i = 0; $i < $this->iterations; $i++) {
                if ($reference == '') {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against (bool)
        $currentData = array('if((bool)$string)');
        foreach ($references as $reference) {
            $start = microtime(true);
            for ($i = 0; $i < $this->iterations; $i++) {
                if ((bool)$reference) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        // Test against ($string)
        $currentData = array('if($string)');
        foreach ($references as $reference) {
            $start = microtime(true);
            for ($i = 0; $i < $this->iterations; $i++) {
                if ($reference) {
                }
            }
            $currentData[] = microtime(true) - $start;
        }
        $data[] = $currentData;

        $this->setTotalAndPercentage($data);
        $this->addSectionLine($data, 'Empty String Detection');

        return array(
            array(
                'header' => array('Function', 'Empty String', 'Small string (10)', 'Medium string (100)', 'Large string (1000)', 'Total', 'Percentage'),
                'rows' => $data
            )
        );
    }

    protected function testStringStartWithDetection()
    {
        $data = array(
            array(
                'header' => array('Function', 'Empty haystack & Empty needle', 'Empty haystack & Small string (8)', 'Empty haystack & Small string (8)', 'Total', 'Percentage'),
                'rows' => array()
            ),
            array(
                'header' => array('Function', 'Small haystack(10) & Empty needle', 'Small haystack(10) & Needle present(8)', 'Small haystack(10) & Needle absent (8)', 'Total', 'Percentage'),
                'rows' => array()
            ),
            array(
                'header' => array('Function', 'Medium haystack(100) & Empty needle', 'Medium haystack(100) & Needle present(8)', 'Medium haystack(100) & Needle absent (8)', 'Total', 'Percentage'),
                'rows' => array()
            ),
            array(
                'header' => array('Function', 'Large haystack(1000) & Empty needle', 'Large haystack(1000) & Needle present(8)', 'Large haystack(1000) & Needle absent (8)', 'Total', 'Percentage'),
                'rows' => array()
            )
        );

        $haystacks = array(
            '',
            str_repeat('=', 10),
            str_repeat('=', 100),
            str_repeat('=', 1000)
        );
        $needles = array(
            '',
            str_repeat('=', 8),
            str_repeat('-', 8)
        );

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if(strncmp($haystack, $needle, strlen($needle)) === 0)');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if (strncmp($haystack, $needle, strlen($needle)) === 0) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if(strncasecmp($haystack, $needle, strlen($needle)) === 0)');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if (strncasecmp($haystack, $needle, strlen($needle)) === 0) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if($needle === \'\' || strpos($haystack, $needle) === 0)');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if ($needle === '' || strpos($haystack, $needle) === 0) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if(substr($haystack, 0, strlen($needle)) === $needle)');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if (substr($haystack, 0, strlen($needle)) === $needle) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if(strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0)');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }

        foreach ($haystacks as $hKey => $haystack) {
            $currentRow = array('if(preg_match("/^" . preg_quote($needle, "/") . "/", $haystack))');
            foreach ($needles as $needle) {
                $start = microtime(true);
                for ($i = 0; $i < $this->iterations; $i++) {
                    if (preg_match("/^" . preg_quote($needle, "/") . "/", $haystack)) {
                    }
                }
                $currentRow[] = microtime(true) - $start;
            }
            $data[$hKey]['rows'][] = $currentRow;
        }
        foreach ($data as $hKey => &$rows) {
            $this->setTotalAndPercentage($rows['rows']);
            $this->addSectionLine($rows['rows'], 'String Start With Detection');
        }

        return $data;
    }
}