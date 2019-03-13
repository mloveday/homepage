<?php

namespace App\Entity\Roadmap;

class RoadmapEntity {
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var RoadmapEntity[] */
    public $roadmaps;

    /**
     * @param string $title
     * @param string $description
     * @param RoadmapEntity[] $roadmaps
     */
    public function __construct(string $title, string $description, array $roadmaps = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->roadmaps = $roadmaps;
    }
}