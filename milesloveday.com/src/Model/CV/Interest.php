<?php

namespace App\Model\CV;

class Interest {
    /** @var string */
    public $title;
    /** @var string */
    public $description;

    public function __construct(string $title, string $description) {
        $this->title = $title;
        $this->description = $description;
    }
}