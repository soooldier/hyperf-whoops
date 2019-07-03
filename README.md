# hyperf-whoops

让hyperf支持whoops显示异常信息

# Features

* 开箱即用

# How to use

```shell
composer require soooldier/hyperf-whoops
```

# Api
* [Whoops::setException](#setException)
* [Whoops::getHtmlOutput](#getHtmlOutput)
* [Whoops::getPlainTextOutput](#getPlainTextOutput)
* [Whoops::getJsonOutput](#getJsonOutput)

# Contents

## setException
`$whoops->setException()` 设置要处理的异常对象

## getHtmlOutput
`$whoops->getHtmlOutput()`

## getPlainTextOutput
`$whoops->getPlainTextOutput()`

## getJsonOutput
`$whoops->getJsonOutput()`

# Example

```php
class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var StdoutLoggerInterface
     */
    private $logger;

    public function __construct(StdoutLoggerInterface $logger, ContainerInterface $container)
    {
        $this->logger = $logger;
        $this->container = $container;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $whoops = $this->container->get('whoops')->setException($throwable);
        $content = $whoops->getHtmlOutput(); // 获取html格式输出，日志最详细
        // $content = $whoops->getJsonOutput(); // 获取json格式输出，通常配合ajax使用
        // $content = $whoops->getPlainTextOutput(); // 文本格式输出，通常记日志
        return $response->withStatus(500)->withBody(new SwooleStream($content));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
```

# ChangeLog

* v1.0.0 第一版