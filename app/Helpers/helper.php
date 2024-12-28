<?php

if (!function_exists('module_path')) {
    /**
     * Get the path to a module file or directory.
     *
     * @param string $name
     * @param string $path
     * @return string
     */
    function module_path($name, $path = '')
    {
        $module = base_path('Modules/' . $name);
        return $module . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
