# hyperf-whoops

让hyperf支持whoops显示异常信息

# Features

* 开箱即用

# How to use

```shell
composer require soooldier/hyperf-whoops
```

# Api
- [hyperf-whoops](#hyperf-whoops)
- [Features](#Features)
- [How to use](#How-to-use)
- [Api](#Api)
- [Contents](#Contents)
  - [getHtmlOutput](#getHtmlOutput)
  - [getPlainTextOutput](#getPlainTextOutput)
  - [getJsonOutput](#getJsonOutput)
- [Example](#Example)
- [ChangeLog](#ChangeLog)

# Contents

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
        $whoops = $this->container->get('whoops');
        $content = $whoops->getHtmlOutput($throwable); // 获取html格式输出，日志最详细
        // $content = $whoops->getJsonOutput($throwable); // 获取json格式输出，通常配合ajax使用
        // $content = $whoops->getPlainTextOutput($throwable); // 文本格式输出，通常记日志
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
* v1.0.1 修复相同协程内数据污染问题