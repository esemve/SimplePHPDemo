<?php

namespace App\Entity;

use Libs\AbstractEntity;

class BlogPost extends AbstractEntity
{
    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $lead;

    /**
     * @var string|null
     */
    protected $content;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): BlogPost
    {
        $this->title = $title;

        return $this;
    }

    public function getLead(): ?string
    {
        return $this->lead;
    }

    public function setLead(?string $lead): BlogPost
    {
        $this->lead = $lead;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): BlogPost
    {
        $this->content = $content;

        return $this;
    }
}