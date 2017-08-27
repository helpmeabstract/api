<?php


namespace HelpMeAbstract\Response;


use Zend\Diactoros\Response\JsonResponse;

class BadRequestResponse extends JsonResponse
{
    public function __construct(array $errors)
    {
        parent::__construct(
            ['errors' => $errors],
            400
        );
    }
}