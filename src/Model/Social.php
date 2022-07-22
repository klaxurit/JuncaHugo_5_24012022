<?php

namespace App\Model;

use App\Core\Entity;


class Social extends Entity
{
    private $icon_name;
    private $url;
    private $name;

    /**
     * Get the value of url
     * 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     * 
     *  @return  self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     * 
     *  @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of icon_name
     * 
     *  @return  self
     */
    public function getIconName()
    {
        return $this->icon_name;
    }

    /**
     * Set the value of icon_name
     */
    public function setIconName($icon_name)
    {
        $this->icon_name = $icon_name;

        return $this;
    }
}
