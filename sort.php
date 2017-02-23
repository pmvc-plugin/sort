<?php
namespace PMVC\PlugIn\sort;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\sort';

class sort extends \PMVC\PlugIn
{

    public function init()
    {
        $this->reset();
    }

    public function reset()
    {
        if (!isset($this['sort'])) {
            $this['sort'] = 'uasort';
        }

        if (!isset($this['comparison'])) {
            $this['comparison'] = 'strnatcmp';
        }
    }

    /**
     * usort($arr, _byColumn('key'));
     */
    private function _byColumn($key, $descending)
    {
        if ($descending) { 
            return function ($a, $b) use ($key) {
                return $this['comparison']( $b[$key],$a[$key]);
            };
        } else {
            return function ($a, $b) use ($key) {
                return $this['comparison']( $a[$key],$b[$key]);
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
        $this['sort'](
            $params[0],
            $this->_byColumn(
                $params[1],
                $descending
            )
        );
        return $this;
    }
}
