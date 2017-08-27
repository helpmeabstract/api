<?php

namespace HelpMeAbstract\Controller\Behavior;

interface Sortable
{
    public static function getSortableFields(): array;

    public static function getDefaultSort();
}
