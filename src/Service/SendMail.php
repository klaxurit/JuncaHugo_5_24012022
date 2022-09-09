<?php

namespace App\Service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Exceptions\ConfigNotFound;

class SendMail {

  private array $config;

  public function __construct()
  {
    $this->config = $this->getConfig();
  }

  /**
   * get mail config file if exist, if not throw new ConfigNotFound exception
   *
   * @return void
   */
  private function getConfig()
  {
    $dir = CONF_DIR . "/mail.yml";
    if (!file_exists($dir)) {
      throw new ConfigNotFound("No database config found");
    }
    $config = yaml_parse_file($dir);
    return $config;
  }
  
  /**
   * set up mail and send it
   *
   * @param  mixed $mailDatas
   * @return void
   */
  public function newMail($mailDatas) {
    $mail = new PHPMailer(true);

    try {
      // Configuration
      $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Je veux des infos de debug
      
      // On configure le SMTP
      $mail->isSMTP();
      $mail->Host = $this->config['mail_host'];
      $mail->Port = $this->config['mail_port'];
      
      // CharSet
      $mail->CharSet = "utf-8";
      
      // Destinataire
      $mail->addAddress($this->config['mail_to']);
      
      // Expediteur
      $mail->setFrom($mailDatas["email"]);
      
      // Contenu
      $mail->isHTML(true);
      $mail->Subject = "Nouveau message du Blog Axurit";
      $mail->Body = ("<h3>Nouveau message de " . $mailDatas["nom"] . " " . $mailDatas["prenom"] . "</h3> </br>" . "<p>" . $mailDatas["message"] . "</p>");
      $mail->send();
      
    }catch(Exception $e){
    }
  }
}
