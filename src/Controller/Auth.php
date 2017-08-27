<?php

namespace HelpMeAbstract\Controller;

use const HelpMeAbstract\HELP_ME_ABSTRACT_COOKIE;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Entity\User;
use HelpMeAbstract\OAuthSource\Github;
use HelpMeAbstract\Repository\UserRepository;
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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManager  $db
     * @param UserRepository $userRepository
     */
    public function __construct(EntityManager $db, UserRepository $userRepository)
    {
        $this->db = $db;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $code = $request->getQueryParams()['code'] ?? null;

        if (!$code) {
            throw new \Exception('BAD CODE, FRIEND');
        }

        $userInfo = (new Github())->getUser($code);

        $user = $this->userRepository->findOneBy(['email' => $userInfo['email']]);

        if (!$user) {
            $user = new User();
            $user->setEmail($userInfo['email']);
            $user->setAuthSource('Github');
            $user->setAuthToken($userInfo['token']);
            $user->setFirstName($userInfo['first_name']);
            $user->setLastName($userInfo['last_name']);
            $user->setLocation($userInfo['location']);
            $user->setGithubHandle($userInfo['login']);

            $this->db->persist($user);
            $this->db->flush();
        }

        $response = (new RedirectResponse('/', 301));

        return FigResponseCookies::set($response, SetCookie::create(HELP_ME_ABSTRACT_COOKIE)
            ->withValue($user->getId()->toString())
            ->withExpires((new \DateTimeImmutable('now'))->modify('+1 week'))
            ->withDomain('0.0.0.0')
        );
    }
}
