<?php

namespace App\Model\CV;

class Employer {
    /** @var string */
    public $date;
    /** @var string */
    public $name;
    /** @var string */
    public $title;
    /** @var string */
    public $description;

    public function __construct(string $date, string $name, string $title, string $description) {
        $this->date = $date;
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
    }
}