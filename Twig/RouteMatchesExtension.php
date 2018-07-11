<?php
declare(strict_types=1);

namespace Felds\RouteMatchesBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig_Extension;
use Twig_Function;

class RouteMatchesExtension extends Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('route_matches', [$this, 'routeMatches']),
        ];
    }

    public function routeMatches(string $pattern): bool
    {
        $request = $this->requestStack->getCurrentRequest();

        $route = $request->attributes->get('_route');
        if (!$route) {
            return false;
        }

        return (bool)preg_match($pattern, $route);
    }
}
