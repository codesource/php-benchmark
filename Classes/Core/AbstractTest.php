<?php

namespace CDSRC\PhpBenchmark\Core;


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

abstract class AbstractTest
{
    /**
     * Number of test iteration
     *
     * @var integer
     */
    protected $iterations;

    /**
     * Name of test
     *
     * @var string
     */
    protected $name;

    /**
     * Description of the test
     *
     * @var string
     */
    protected $description;

    /**
     * Last test run data
     *
     * @var array
     */
    protected $data;

    /**
     * AbstractTest constructor.
     *
     * @param string $name
     * @param string $description
     * @param int $iterations
     */
    public function __construct($name = '', $description = '', $iterations = 10000)
    {
        $this->name = trim((string)$name);
        if ($this->name === '') {
            $this->name = 'Unnamed test';
        }
        $this->description = (string)$description;
        $this->iterations = (int)$iterations;
        if ($this->iterations < 0) {
            $this->iterations = 0;
        }
        $this->data = array();
    }

    /**
     * Run test and populate data
     *
     * @return AbstractTest
     */
    abstract public function run();

    /**
     * Get test iterations
     *
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * Get test name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get test description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Append total and percentage at end of each data row
     *
     * @param array $data
     *
     * @return void
     */
    protected function setTotalAndPercentage(array &$data)
    {
        foreach ($data as &$row) {
            $this->setTotal($row);
        }
        $minimum = $this->getMinimum($data);
        foreach ($data as &$row) {
            $this->setPercentage($row, $minimum);
        }
    }

    /**
     * Add a section to the beginning of data
     * @param array $data
     * @param string $name
     */
    protected function addSectionLine(array &$data, $name){
        array_unshift($data, array($name));
    }

    /**
     * Append total at the end of data
     *
     * @param array $data
     *
     * @return void
     */
    private function setTotal(array &$data)
    {
        $workingData = $data;
        array_shift($workingData);
        $data[] = array_sum($workingData);
    }

    /**
     * Get minimum total of a data set
     * NOTICE: Must be called after setTotal
     *
     * @param array $data
     *
     * @return integer
     */
    private function getMinimum(array $data)
    {
        $workingData = $data;
        $minimum = 1000000000000000000000; // Should never be greater than this value
        foreach ($workingData as $row) {
            $minimum = min($minimum, array_pop($row));
        }

        return $minimum;
    }

    /**
     * Append percentage at the end of data based on reference
     * NOTICE: Must be called after setTotal
     *
     * @param array $data
     * @param $reference
     *
     * @return void
     */
    private function setPercentage(array &$data, $reference)
    {
        $data[] = number_format(end($data) / $reference * 100, 2) . '%';
    }


}