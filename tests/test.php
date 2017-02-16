<?php
namespace PMVC\PlugIn\sort;

use PHPUnit_Framework_TestCase;

class SortTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'sort';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testSortByColumn()
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
        $plug = \PMVC\plug($this->_plug);
        $plug->byColumn([&$array,1]);
        $this->assertEquals($expected, $array);
    }
}
