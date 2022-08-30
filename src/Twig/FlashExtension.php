<?php

namespace App\Twig;

use App\Service\FlashMessage;

class FlashExtension extends \Twig\Extension\AbstractExtension
{

  /**
   * flashMessage
   *
   * @var FlashMessage
   */
  private $flashMessage;

  public function __construct(FlashMessage $flashMessage)
  {
    $this->flashMessage = $flashMessage;
  }
  
  /**
   * getFunctions
   *
   * @return array
   */
  public function getFunctions(): array
  {
    return [
      new \Twig\TwigFunction('flash', [$this, 'getFlash'])
    ];
  }
  
  /**
   * getFlash
   *
   * @param  mixed $type
   * @return string
   */
  public function getFlash($type): ?string
  {
    return $this->flashMessage->get($type);
  }
}
