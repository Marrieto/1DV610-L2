<?php

class LoginController {

  private static $DateTimeView;
  private static $LoginView;
  private static $LayoutView;
  private static $LoginModel;

  public function __construct ($v, $dtv, $lv, $lm) {
    self::$LoginView    = $v;
    self::$DateTimeView = $dtv;
    self::$LayoutView   = $lv;
    self::$LoginModel   = $lm;
  }

  public function render () {
    // Testa om inloggad
    // Sätt meddelande via lv->setmsg;
    // self::$LayoutView->setMessage('Benis');
    self::$LayoutView->render(false, self::$LoginView, self::$DateTimeView);
  }

  // Kolla om en post till 'login' sker ifrån main controller, isåfall -> skapa en 
  // sekvens av operationer definerat här i controllern.
  
  // Kolla om username finns
	
}