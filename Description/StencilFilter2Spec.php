<?php
namespace Cordova\Bundle\PhpSpecBundle\Description;

class DescribeStencilFilter extends \PHPSpec\Context
{
    private $stencilFilter = null;

    public function before()
    {
        $this->stencilFilter = $this->spec(new stencilFilter());
    }

    public function itShouldConvertADotIntoAZero()
    {
        $this->stencilFilter->setInput('.');
        $this->stencilFilter->runCellFilter();
        $this->stencilFilter->getOutput()->should->equal('0');
    }

    public function itShouldConvertAStarIntoAMine()
    {
        $this->stencilFilter->setInput('*');
        $this->stencilFilter->runCellFilter();
        $this->stencilFilter->getOutput()->should->equal('*');
    }

    public function itShouldConvertARowOfDotsIntoARowOfZeroes()
    {
        $this->stencilFilter->setInput('....');
        $this->stencilFilter->runRowFilter();
        $this->stencilFilter->getOutput()->should->equal('0000');
    }

    public function itShouldConvertAMixedRowIntoMixedZeroesAndStars()
    {
        $this->stencilFilter->setInput('.*.*');
        $this->stencilFilter->runRowFilter();
        $this->stencilFilter->getOutput()->should->equal('0*0*');
    }

    public function itShouldConvertARowOfStarsIntoARowOfStars()
    {
        $this->stencilFilter->setInput('****');
        $this->stencilFilter->runRowFilter();
        $this->stencilFilter->getOutput()->should->equal('****');
    }

    public function itShouldConvertAGridofStarsIntoAGridOfStars() {
        $this->stencilFilter->setInput(
            array(
                '1' => '****',
                '2' => '****',
                '3' => '****',
                '4' => '****'
            )
        );
        $this->stencilFilter->runGridFilter();
        $this->stencilFilter->getOutput()->should->equal(
            array(
                '1' => '****',
                '2' => '****',
                '3' => '****',
                '4' => '****'
            )
        );
    }

    public function itShouldConvertAMixedMatrixIntoAMixedMatrix() {
        $this->stencilFilter->setInput(
            array(
                '1' => '*..*',
                '2' => '..**',
                '3' => '**..',
                '4' => '...*'
            )
        );
        $this->stencilFilter->runGridFilter();
        $this->stencilFilter->getOutput()->should->equal(
            array(
                '1' => '*00*',
                '2' => '00**',
                '3' => '**00',
                '4' => '000*'
            )
        );
    }

    public function itShouldChangeDotTo0WhenNoMinesNearby() {
        $this->stencilFilter->setInput(
            array(
                '1' => '*..*',
                '2' => '..**',
                '3' => '**..',
                '4' => '...*'
            )
        );
        $this->stencilFilter->runGridFilter();
        $this->stencilFilter->getOutput()->should->equal(
            array(
                '1' => '*00*',
                '2' => '00**',
                '3' => '**00',
                '4' => '000*'
            )
        );
    }

}

class stencilFilter
{
    protected $stencilCellIn = null;
    protected $stencilRowIn = null;
    protected $stencilGridIn = null;

    public $filterCell = null;
    public $filterRow = null;
    public $filterRowWrapped = null;
    public $filterGrid = null;

    protected $stencilProcessed = null;

    public function __construct() {
        $self = $this;
        $this->filterCell = function($value) use ($self) { return ($value == '.') ? '0':'*'; };
        $this->filterRow = function($row) use ($self) { return array_map($self->filterCell, $row); };
        $self->filterRowWrapped = function($row) use ($self) { return implode(array_map($self->filterCell, $row)); };
        $this->filterGrid = function($grid) use ($self){ return array_map($self->filterRowWrapped, $grid); };
    }

    public function setInput($str) {
        if(is_array($str)) {
            $this->stencilGridIn = array_map('str_split', $str);
        } elseif(strlen($str) > 1) {
            $this->stencilRowIn = str_split($str);
        } else {
            $this->stencilCellIn = $str;
        }
    }

    public function runCellFilter() {
        $this->stencilProcessed = call_user_func($this->filterCell, $this->getStencilCellIn());
    }

    public function runRowFilter() {
        $this->stencilProcessed = implode(call_user_func($this->filterRow, $this->getStencilRowIn()));
    }

    public function runGridFilter() {
        $this->stencilProcessed = call_user_func($this->filterGrid, $this->getStencilGridIn());
    }

    public function findNeighbors() {
        $coords = array();
        $coords[] = 1;
        return 1;
    }
    public function getOutput() {
        return $this->getStencilProcessed();
    }

    public function getStencilCellIn() {
        return $this->stencilCellIn;
    }

    public function getStencilRowIn() {
        return $this->stencilRowIn;
    }

    public function getStencilGridIn() {
        return $this->stencilGridIn;
    }

    public function getStencilProcessed() {
        return $this->stencilProcessed;
    }

}