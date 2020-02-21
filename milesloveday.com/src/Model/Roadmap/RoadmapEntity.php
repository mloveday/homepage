<?php

namespace App\Model\Roadmap;

class RoadmapEntity {
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var RoadmapEntity[] */
    public $roadmaps;

    public function __construct(string $title, string $description, array $roadmaps = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->roadmaps = $roadmaps;
    }
}