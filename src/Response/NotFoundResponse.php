<?php


namespace HelpMeAbstract\Response;


use Zend\Diactoros\Response\JsonResponse;

class NotFoundResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([], 404);
    }
}