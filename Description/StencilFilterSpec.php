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
        $this->stencilFilter->setInput('..');
        $this->stencilFilter->runRowFilter();
        $this->stencilFilter->getOutput()->should->equal('00');
    }
}

class stencilFilter
{
    protected $stencilCellIn = null;
    protected $stencilRowIn = null;
    protected $stencilGridIn = null;

    //public $filterCell = null;
    //public $filterRow = null;
    //public $filterGrid = null;

    protected $stencilProcessed = null;

    public function __construct() {
        //$self = $this;
        //$this->filterCell = function($value) use ($self) { return ($value == '.') ? '0':'*'; };
        //$this->filterRow = function($row) use ($self) { return array_map($self->filterCell, $row); };
        //$this->filterGrid = function($grid) use ($self){ return array_map($self->filterRow, $grid); };
    }

    public function setInput($str) {
        $this->stencilCellIn = $str;
        $this->stencilRowIn = str_split($str);
        $this->stencilGridIn = $str;
    }

    public function runCellFilter() {
        $this->stencilProcessed = $this->filterCell($this->getStencilCellIn());
    }

    public function runRowFilter() {
        $this->stencilProcessed = implode($this->filterRow($this->getStencilRowIn()));
    }

    public function runGridFilter() {
        $this->stencilProcessed = $this->filterGrid($this->getStencilGridIn());
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

    public function filterCell($value){ return ($value == '.') ? '0':'*'; }

    public function filterRow($row){ return array_map(array($this, 'filterCell'), $row); }

    public function filterGrid($grid){ return array_map($this->filterRow, $grid); }
}