<?php
declare(strict_types=1);

namespace Hyperf\Whoops;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'whoops' => Whoops::class,
            ],
            'scan' => [
            ],
            'commands' => [
            ],
            'listeners' => [
            ],
            'publish' => [
            ],
        ];
    }
}
