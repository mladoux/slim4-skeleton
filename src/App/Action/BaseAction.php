<?php
declare(strict_types=1);

namespace App\Action;

use Slim\Views\Twig;

class BaseAction
{
    /**
     * @var \Slim\Views\Twig
     */
    protected $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }
}
