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

class ClassLoader
{
    /**
     * Store singleton instance
     *
     * @var ClassLoader
     */
    protected static $_instance = null;

    /**
     * Get singleton instance
     *
     * @return \CDSRC\PhpBenchmark\Core\ClassLoader|null
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new ClassLoader();
        }

        return self::$_instance;
    }

    /**
     * Autoload class based on name
     *
     * @param string $className
     */
    public function load($className)
    {
        $parts = array_filter(explode('\\', $className));
        if (!empty($parts)) {
            $vendor = array_shift($parts);
            $package = array_shift($parts);
            if ($vendor === 'CDSRC' && $package === 'PhpBenchmark') {
                include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
            }
        }
    }
}