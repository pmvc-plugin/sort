<?php
namespace PMVC\PlugIn\sort;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\sort';

class sort extends \PMVC\PlugIn
{

    public function init()
    {
        if (!isset($this['sort'])) {
            $this['sort'] = 'uasort';
        }

        if (!isset($this['comparison'])) {
            $this['comparison'] = 'strnatcmp';
        }
    }

    public function reset()
    {
        unset($this['sort']);
        unset($this['comparison']);
        $this->init();
    }

    /**
     * usort($arr, _byColumn('key'));
     */
    private function _byColumn($key, $descending)
    {
        if ($descending) { 
            return function ($a, $b) use ($key) {
                return $this['comparison']( $b[$key], $a[$key] );
            };
        } else {
            return function ($a, $b) use ($key) {
                return $this['comparison']( $a[$key], $b[$key] );
            };
        }
    }

    /**
     * usort($arr, _byColumn(key[]));
     */
    private function _byPath(array $path, $descending)
    {
        if ($descending) { 
            return function ($a, $b) use ($path) {
                return $this['comparison']( \PMVC\value($b, $path, 0), \PMVC\value($a, $path, 0) );
            };
        } else {
            return function ($a, $b) use ($path) {
                return $this['comparison']( \PMVC\value($a, $path, 0), \PMVC\value($b, $path, 0) );
            };
        }
    }

    /**
     * Need assign with array, due to plugin can't pass by ref
     * @params array $params[0] The sort array
     * @params string $params[1] Key which you want sorted
     * Usage:
     * $arr = [[0,3], [0,1]];
     * \PMVC\plug('sort')->byColumn([&$arr, '1']); //sort with key 1
     */
    public function byColumn(array $params, $descending = null)
    {
        if (is_array($params[1])) {
            $callback = $this->_byPath(
                $params[1],
                $descending
            );
        } else {
            $callback = $this->_byColumn(
                $params[1],
                $descending
            );
        }
        $this['sort'](
            $params[0],
            $callback
        );
        return $this[\PMVC\THIS]; // for call reset directly
    }
}
