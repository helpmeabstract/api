<?php

namespace HelpMeAbstract\Output;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

trait CreatesFractalScope
{
    /** @var Manager */
    protected $manager;

    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function outputItem($data, TransformerAbstract $transformer, string $type) : Scope
    {
        return $this->manager->createData(new Item($data, $transformer, $type));
    }

    public function outputCollection(array $data, TransformerAbstract $transformer, string $type)  : Scope
    {
        return $this->manager->createData(new Collection($data, $transformer, $type));
    }
}
