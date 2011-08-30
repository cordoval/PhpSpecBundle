<?php
namespace Cordova\Bundle\PhpSpecBundle\Description;

require "Bowling.php"; 

class DescribeNewBowlingGame extends \PHPSpec\Context
{

    private $bowling = null;

    public function before()
    {
        $this->bowling = $this->spec(new Bowling);
    }

    public function itShouldScore0ForGutterGame()
    {
        for ($i=1; $i<=20; $i++) {
            // someone is really bad at bowling!
            $this->bowling->hit(0);
        }
        $this->bowling->score->should->equal(0);
    }

}