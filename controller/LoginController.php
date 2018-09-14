<?php

class LoginController {

  private static $DateTimeView;
  private static $LoginView;
  private static $LayoutView;

  public function __construct ($v, $dtv, $lv) {
    self::$LoginView    = $v;
    self::$DateTimeView = $dtv;
    self::$LayoutView   = $lv;
  }

  public function render () {
    self::$LayoutView->render(false, self::$LoginView, self::$DateTimeView);
  }

  // Kolla om en post till 'login' sker ifrån main controller, isåfall -> skapa en 
  // sekvens av operationer definerat här i controllern.
  
  // Kolla om username finns
	
}