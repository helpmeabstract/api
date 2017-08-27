<?php


namespace HelpMeAbstract\Middleware;

use HelpMeAbstract\Controller\Behavior\Sortable;
use function HelpMeAbstract\next;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SortParser implements Middleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null): ResponseInterface
    {
        if (!$handler = $request->getAttribute('handler-class')) {
            return next($request, $response, $next);
        }

        if (!in_array(Sortable::class, class_implements($handler))) {
            return $request;
        }

        $query = $request->getQueryParams();

        $requestedSort = array_key_exists('sort', $query)
            ? $query['sort']
            : call_user_func([$handler, 'getDefaultSort']);

        if (!is_string($requestedSort)) {
            throw new BadRequestException("Invalid Sort Provided");
        }

        $sortDirection = (substr($requestedSort, 0, 1) === '-')
            ? "DESC"
            : "ASC";

        $requestedSort = trim($requestedSort, '-');

        $sortableFields = call_user_func([$handler, 'getSortableFields']);
        if (!array_key_exists($requestedSort, $sortableFields)) {
            throw new BadRequestException("Invalid Sort Field Requested");
        }

        $request = $request->withAttribute('sort', [$requestedSort, $sortDirection]);

        return next($request, $response, $next);
    }
}