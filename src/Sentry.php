<?php

namespace asasmoyo\yii2sentry;

use Raven_Client;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Sentry extends Component
{
    public $enabled = false;
    public $dsn;

    /**
     * Raven_Client instance
     * @var \Raven_Client
     */
    private $client;

    public function __construct($config = [])
    {
        if (!isset($config['dsn'])) {
            throw new InvalidConfigException('You must configure Sentry DSN.');
        }

        $this->client = $this->buildClient();

        parent::__construct($config);
    }

    protected function buildClient()
    {
        $client = new Raven_Client($this->dsn);

        return $client;
    }

    public function init()
    {
        parent::init();

        if ($this->enabled) {
            $user_context = $this->getUserContext();
            $this->client->user_context($user_context);
            $this->client->install();
        }
    }

    protected function getUserContext()
    {
        return [
            'isGuest' => \Yii::$app->user->isGuest,
        ];
    }
}
