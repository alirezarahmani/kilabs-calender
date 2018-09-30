<?php
declare(strict_types=1);
namespace App\Infrastructure\Request;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiRequest extends ParameterBag implements ApiRequestInterface
{
    /**
     * @var Request $request
     */
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    public function getRequest():Request
    {
        return $this->request;
    }
}
