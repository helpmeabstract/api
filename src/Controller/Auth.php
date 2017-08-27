<?php

namespace HelpMeAbstract\Controller;

use Doctrine\ORM\EntityManager;
use HelpMeAbstract\OAuthSource\Github;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
class Auth
{
    /**
     * @var EntityManager
     */
    private $db;

    /**
     * @param EntityManager $db
     */
    public function __construct(EntityManager $db )
    {
        $this->db = $db;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $code = $request->getQueryParams()['code'] ?? null;

        if (!$code){
            throw new \Exception("BAD CODE, FRIEND");
        }

        $user = (new Github())->getUser($code);

        $this->db->persist($user);
        $this->db->flush();

        return (new RedirectResponse('/', 301));

    }
}
