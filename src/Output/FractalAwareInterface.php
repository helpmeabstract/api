<?php


namespace HelpMeAbstract\Output;


use League\Fractal\Manager;

interface FractalAwareInterface
{
    public function setManager(Manager $manager);
}