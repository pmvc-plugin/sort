<?php
namespace PMVC\PlugIn\sort;

use PMVC\TestCase;

class SortTest extends TestCase
{
    private $_plug = 'sort';

    function pmvc_setup()
    {
        \PMVC\unplug($this->_plug);
    }

    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
    }

    function testUsortByColumn()
    {
        $array = [
            [0,1,2],
            [0,3,2],
            [0,2,2],
        ];
        
        $expected = [
            [0,1,2],
            [0,2,2],
            [0,3,2],
        ];
        $plug = \PMVC\plug($this->_plug, ['sort'=>'usort']);
        $plug->byColumn([&$array,1]);
        $this->assertEquals($expected, $array);
    }

    function testDefaultUasortByColumn()
    {
        $array = [
            [0,1,2],
            [0,3,2],
            [0,2,2],
        ];
        
        $expected = [
            0=>[0,1,2],
            2=>[0,2,2],
            1=>[0,3,2],
        ];
        $plug = \PMVC\plug($this->_plug);
        $plug->byColumn([&$array,1]);
        $this->assertEquals($expected, $array);
    }

    function testSortByObject()
    {
        $array = [
            'a'=>(object)[
                'a'=>1,
                'b'=>2,
            ],
            'b'=>(object)[
                'a'=>3,
            ],
            'c'=>(object)[
                'a'=>4,
                'b'=>5,
            ],
        ];
        $plug = \PMVC\plug($this->_plug);
        $plug->byColumn([&$array,['b']], true);
        $this->assertEquals(['c', 'a', 'b'], array_keys($array));
    }
}
