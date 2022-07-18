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

  public function getFunctions(): array
  {
    return [
      new \Twig\TwigFunction('flash', [$this, 'getFlash'])
    ];
  }

  public function getFlash($type): ?string
  {
    return $this->flashMessage->get($type);
  }
}
