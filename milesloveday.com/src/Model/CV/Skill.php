<?php

namespace App\Model\CV;

class Skill {
    /** @var string */
    public $title;
    /** @var string */
    public $description;

    public function __construct(string $title, string $description) {
        $this->title = $title;
        $this->description = $description;
    }
}