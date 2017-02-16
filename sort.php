<?php
namespace PMVC\PlugIn\sort;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\sort';

class sort extends \PMVC\PlugIn
{
    /**
     * usort($arr, _byColumn('key'));
     */
    private function _byColumn($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        }; 
    }

    /**
     * Need assign with array, due to plugin can't pass by ref
     * @params array $params[0] The sort array
     * @params string $params[1] Key which you want sorted
     * Usage:
     * $arr = [[0,3], [0,1]];
     * \PMVC\plug('sort')->byColumn([&$arr, '1']); //sort with key 1
     */
    public function byColumn(array $params)
    {
        usort($params[0], $this->_byColumn($params[1]));
    }
}
