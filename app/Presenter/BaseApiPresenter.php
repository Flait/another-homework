<?php

namespace App\Presenter;

use Nette\Application\UI\Presenter;

abstract class BaseApiPresenter extends Presenter
{
    protected function startup(): void
    {
        parent::startup();

        $this->getHttpResponse()->setHeader('Access-Control-Allow-Origin', '*');
        $this->getHttpResponse()->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->getHttpResponse()->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
