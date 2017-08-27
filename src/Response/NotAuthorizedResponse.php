<?php


namespace HelpMeAbstract\Response;


use Teapot\StatusCode;
use Zend\Diactoros\Response\JsonResponse;

class NotAuthorizedResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(null, StatusCode::FORBIDDEN);
    }
}