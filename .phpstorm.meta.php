<?php
namespace PHPSTORM_META {
    $STATIC_METHOD_TYPES = [
        \Interop\Container\ContainerInterface::get('') => [
            "" == "@",
        ],
        \League\Container\ContainerInterface::get('') => [
            "" == "@",
        ],
        \League\Container\Container::get('') => [
            '' => '@'
        ],
    ];
}
