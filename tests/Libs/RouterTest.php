<?php

namespace Test\Libs;

use Libs\RouterInterface;
use Libs\Test\TestCase;

class RouterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testSetupRoutes(string $uri, string $expectedRoute): void
    {
        $router = $this->getRouter();
        $router->setRoutes($this->getFixtures());
        $resolved = $router->resolve($uri);

        $this->assertEquals($resolved['key'], $expectedRoute);
    }

    public function dataProvider(): array
    {
        return [
            ['/valami','sajt'],
            ['/test/xxx', 'index2'],
            ['/test/xxxyyy', 'index2'],
            ['/dsds', 'error404'],
            ['/index.php', 'default'],
            ['/', 'default'],
        ];
    }

    protected function getFixtures(): array
    {
        return require __DIR__. '/fixtures/routerFixture.php';
    }

    public function getRouter(): RouterInterface
    {
        return clone $this->getContainer()->get('libs.router');
    }
}