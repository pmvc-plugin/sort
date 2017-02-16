<?php
namespace PMVC\PlugIn\sort;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\sort';

class sort extends \PMVC\PlugIn
{
    /**
     * usort($arr, \PMVC\plug('sort')->byColumn('key'));
     */
    public function byColumn($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        }; 
    }
}
