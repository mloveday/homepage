<?php

namespace App\Entity\CV;

class Interest {
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