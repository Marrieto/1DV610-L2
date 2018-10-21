<?php

class LayoutView
{
    private $DateTimeView;

    public function __construct($dtv)
    {
        $this->DateTimeView = $dtv;
    }

    public function render(StatusMessage $msg, string $htmlFromViews): void
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($msg->getMessageState()) . '
              ' . $htmlFromViews . '

              ' . $this->DateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderIsLoggedIn($isLoggedIn): string
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
