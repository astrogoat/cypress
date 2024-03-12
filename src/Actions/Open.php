<?php

namespace Astrogoat\Cypress\Actions;

use Astrogoat\Cypress\Jobs\OpenCypress;
use Helix\Fabrick\Notification;
use Helix\Lego\Apps\Actions\Action;

class Open extends Action
{
    public function actionName(): string
    {
        return 'Open Cypress';
    }

    public function beforeRun()
    {
        return Notification::info('Please wait', 'Opening Cypress...')->autoDismiss(5000);
    }

    public function run(): mixed
    {
        OpenCypress::dispatch()->onConnection('cypress');

        return null;
    }
}
