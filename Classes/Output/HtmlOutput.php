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

class HtmlOutput extends AbstractOutput
{
    /**
     * Render a test as HTML
     *
     * @param \CDSRC\PhpBenchmark\Core\AbstractTest $test
     *
     * @return void
     */
    public function render(AbstractTest $test)
    {
        $content = '<h2>' . $test->getName() . '</h2>';
        if ($test->getDescription() !== '') {
            $content .= '<h3>' . $test->getDescription() . '</h3>';
        }
        $data = $test->getData();
        if (empty($data) || !is_array($data['header']) || !is_array($data['rows'])) {
            $content .= '<strong style="color:red">Test has no data</strong>';
        } else {
            $content .= '<table><thead><tr>';
            $headersCount = count($data['header']);
            for ($i = 0; $i < $headersCount; $i++) {
                $content .= '<th>' . $data['header'][$i] . '</th>';
            }
            $content .= '</tr></thead><tbody>';
            for ($i = 0, $ni = count($data['rows']); $i < $ni; $i++) {
                if (is_array($data['rows'][$i])) {
                    $content .= '<tr>';
                    for ($j = 0; $j < $headersCount; $j++) {
                        $content .= '<td>' . $data['rows'][$i][$j] . '</td>';
                    }
                    $content .= '</tr>';
                }
            }
            $content .= '</tbody></table><br/><br/>';
        }

        echo $content;
    }

    /**
     * Open HTML content
     *
     * @return string
     */
    public function open(){
        echo '<!DOCTYPE html><html><head><title>PHP Benchmarks</title></head><body>';
    }

    /**
     * Close HTML content
     *
     * @return string
     */
    public function close(){
        echo '</body></html>';
    }
}