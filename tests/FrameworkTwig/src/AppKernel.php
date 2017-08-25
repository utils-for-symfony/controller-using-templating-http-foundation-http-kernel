<?php

/*
 * This file is part of the Symfony-Util package.
 *
 * (c) Jean-Bernard Addor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/', SymfonyUtil\Controller\EngineAsArgumentController::class, 'index');
        $routes->add('/argument', SymfonyUtil\Controller\EngineAsArgumentController::class, 'argument');
        $routes->add('/constructor', SymfonyUtil\Controller\EngineInConstructorController::class, 'constructor');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        //Controllers
        $c->autowire(SymfonyUtil\Controller\EngineAsArgumentController::class)
            ->setAutoconfigured(true)
            ->addTag('controller.service_arguments')
            ->setPublic(false);

        $c->autowire(SymfonyUtil\Controller\EngineInConstructorController::class)
            ->setAutoconfigured(true)
            ->addTag('controller.service_arguments')
            ->setPublic(true);

        // Extensions
        $c->loadFromExtension('framework', [
            'secret' => 'NotSecret', // What about use $ uuid -v4  or $ uuidgen
            'test' => in_array($this->getEnvironment(), ['test'], true), // test.client service for eg. PHPUnit
            'templating' => ['engines' => 'twig'],
        ]);
        $c->loadFromExtension('twig', [
            'debug' => true,
            'paths' => ['%kernel.project_dir%/tests/templates'],
        ]);
    }
}
