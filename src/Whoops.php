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
     * @var Throwable
     */
    private $exception;

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
     * @return $this
     */
    public function setException(\Throwable $throwable)
    {
        $this->exception = $throwable;
        return $this;
    }

    /**
     * @return string
     */
    public function getJsonOutput(): string
    {
        if (!($this->exception instanceof \Throwable)) {
            throw new \InvalidArgumentException('invalid exception');
        }
        $this->run->prependHandler($this->container->make(JsonResponseHandler::class));
        return $this->run->handleException($this->exception);
    }

    /**
     * @return string
     */
    public function getHtmlOutput(): string
    {
        if (!($this->exception instanceof \Throwable)) {
            throw new \InvalidArgumentException('invalid exception');
        }
        $prettyPageHandler = $this->container->make(PrettyPageHandler::class);
        $basePrettyPageHandler = $this->container->make(BasePrettyPageHandler::class);
        $prettyPageHandler->setResourcesPath($basePrettyPageHandler->getResourcesPath());
        $this->run->prependHandler($prettyPageHandler);
        return $this->run->handleException($this->exception);
    }

    /**
     * @return string
     */
    public function getPlainTextOutput(): string
    {
        if (!($this->exception instanceof \Throwable)) {
            throw new \InvalidArgumentException('invalid exception');
        }
        $this->run->prependHandler($this->container->make(PlainTextHandler::class));
        return $this->run->handleException($this->exception);
    }
}
