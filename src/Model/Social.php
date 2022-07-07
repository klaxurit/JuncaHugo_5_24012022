<?php

namespace App\Model;

use App\Core\Entity;


class Social extends Entity
{
    private string $icon_name;
    private string $url;
    private string $name;

    /**
     * Get the value of url
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of icon_name
     */
    public function getIconName(): string
    {
        return $this->icon_name;
    }

    /**
     * Set the value of icon_name
     */
    public function setIconName(string $icon_name): self
    {
        $this->icon_name = $icon_name;

        return $this;
    }
}
