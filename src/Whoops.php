<?php
declare(strict_types=1);

namespace Hyperf\Whoops;

use Whoops\Run;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler as BasePrettyPageHandler;
use Hyperf\Whoops\Hander\PrettyPageHandler;
use Psr\Container\ContainerInterface;

class Whoops
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Whoops\Run
     */
    private $run;

    /**
     * Whoops constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->run = $this->container->make(Run::class);
        $this->run->allowQuit(false);
        $this->run->writeToOutput(false);
        $this->run->register();
    }

    /**
     * @param \Throwable $throwable
     * @return string
     */
    public function getJsonOutput(\Throwable $throwable): string
    {
        $this->run->prependHandler($this->container->make(JsonResponseHandler::class));
        return $this->run->handleException($throwable);
    }

    /**
     * @param \Throwable $throwable
     * @return string
     */
    public function getHtmlOutput(\Throwable $throwable): string
    {
        $prettyPageHandler = $this->container->make(PrettyPageHandler::class);
        $basePrettyPageHandler = $this->container->make(BasePrettyPageHandler::class);
        $prettyPageHandler->setResourcesPath($basePrettyPageHandler->getResourcesPath());
        $this->run->prependHandler($prettyPageHandler);
        return $this->run->handleException($throwable);
    }

    /**
     * @param \Throwable $throwable
     * @return string
     */
    public function getPlainTextOutput(\Throwable $throwable): string
    {
        $this->run->prependHandler($this->container->make(PlainTextHandler::class));
        return $this->run->handleException($throwable);
    }
}
