<?php

namespace asasmoyo\yii2sentry\tests;

use asasmoyo\yii2sentry\Sentry;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Application;

class SentryTest extends TestCase
{
    private function getDummyConfig()
    {
        return [
            'id' => 'test-sentry',
            'basePath' => __DIR__,
            'components' => [
                'user' => [
                    'identityClass' => 'asasmoyo\yii2sentry\tests\DummyIdentity',
                ],
                'sentry' => [
                    'class' => 'asasmoyo\yii2sentry\Sentry',
                    'dsn' => 'DUMMY_DSN',
                    'enabled' => true,
                ],
            ],
        ];
    }

    public function testComponentNotNull()
    {
        $config = $this->getDummyConfig();
        $app = new Application($config);

        $this->assertNotNull(Yii::$app->sentry);
    }

    public function testEmptyDsn()
    {
        $this->expectException(InvalidConfigException::class);

        $sentry = new Sentry([
            'enabled' => true,
        ]);
    }
}
