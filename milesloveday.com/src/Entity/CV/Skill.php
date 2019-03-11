<?php

namespace App\Entity\CV;

class Skill {
    /** @var string */
    public $title;
    /** @var string */
    public $description;

    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(string $title, string $description) {
        $this->title = $title;
        $this->description = $description;
    }
}