<?php

namespace App\Model\CV;

class CV {
    /** @var string */
    public $name;
    /** @var string */
    public $email;
    /** @var string */
    public $personalStatement;
    /** @var Employer[] */
    public $employers;
    /** @var Skill[] */
    public $skills;
    /** @var Educator[] */
    public $educators;
    /** @var Interest[] */
    public $interests;

    public function __construct(string $name, string $email, string $personalStatement, array $employers, array $skills, array $educators, array $interests)
    {
        $this->name = $name;
        $this->email = $email;
        $this->personalStatement = $personalStatement;
        $this->employers = $employers;
        $this->skills = $skills;
        $this->educators = $educators;
        $this->interests = $interests;
    }

    public static function myCv(): CV {
        $employers = [
            new Employer('03/2017 - present','Self employed','PT Dev / Stay at home dad','Part time developing a custom web project in PHP/Symfony, Typescript/React for a local pub to plan/manage staff rota, store accounting data, track revenue, receipts, labour rates, etc (<a href="https://dashboard.milesloveday.com">demo</a>, <a href="/dashboard">write up</a>). Also looking after my children.'),
            new Employer('02/2018','Softwire','Part time contractor','Contractor to help with a support backlog at my previous employer'),
            new Employer('08/2014 - 06/2017','Softwire','Software Developer','Developer working on various client projects including BBC Music and David Lloyd Leisure'),
            new Employer('01/2013 - 08/2012','Walthamstow Hall, Sevenoaks','Teacher of mathematics','Teaching 11-18 year old students. Included IGCSE, A-level and Pre-U'),
            new Employer('09/2008 - 12/2012','King Edward\'s School, Birmingham','Teacher of mathematics','Teaching 11-18 year old students. Included IGCSE, A-level and IB.'),
            new Employer('09/2005 - 04/2007','Metsec Plc','Project Engineer','Designing and developing software to track issues in manufacturing, in Pascal/SQL Server'),
        ];

        $skills = [
            new Skill('React, Knockout','Using Typescript, Webpack, Grunt, Gulp, Encore for SPAs. Implementing React projects from scratch on a greenfield project (and various personal projects), updating a sizeable Knockout project to use Typescript to aid development'),
            new Skill('Cross-platform mobile with Phonegap','Developing for iOS and Android'),
            new Skill('Microservices','Developing with microservices, improving development where tickets change multiple services'),
            new Skill('Developing with and improving legacy code','Working with a large, monolithic codebase. Improving code readability through refactoring, adding and improving documentation and replacing poorly performing code. Debugging obscure bugs and applying fixes.'),
            new Skill('Performance testing and monitoring with Gatling and NewRelic','Implementing a Jenkins job and Gatling tests to get metrics for performance improvements before and after code changes; monitoring NewRelic and responding to issues; proactively looking for the next bottleneck and the next, least difficult, potential performance gains'),
            new Skill('MySQL query optimisation','Improving performance with targeted indexes and query tweaks'),
            new Skill('PHP development with Zend 1 and Symfony 3 & 4','Includes setting up new Symfony projects'),
            new Skill('Working as part of a team','Developing standards to work to (linting, code review) and improving development process (e.g. documentation, speeding up tests run locally)'),
            new Skill('Testing','Improving unit test coverage, implementing integration tests. Worked with Phockito, Cucumber, Enzyme, Jest, Mocha amongst others'),
        ];

        $educators = [
            new Educator('2007 - 2008','Birmingham University','PGCE in Secondary Mathematics',['Secondary Mathematics teaching qualification']),
            new Educator('2001 - 2005','University of Cambridge','Information Engineering',[
                'B.A., Engineering (Information Engineering), 2:2',
                'Projects: \'Production Scheduling\' & \'Image Processing\'',
                'Modules: Signals and Systems, Systems and Control, Signal and Pattern Processing, Data Transmission, Computer and Network Systems, Software Engineering and Design, Introduction to Bioscience, Physiological Systems, Business Economics, Organisational Behaviour and Change.'
            ]),
            new Educator('1994 - 2001','King Edward VI Camp Hill, Birmingham','GCSE, A-levels',[
                'AAA in Maths, Further Maths, Physics at A-level',
                '3 Grade A*, 5 Grade A, 2 Grade B at GCSE'
            ]),
        ];

        $interests = [
            new Interest('Running','Active runner, having taken it up in 2017. Member of Kings Heath Running club. Completed many half marathons, most recently completed a trail marathon (Endurancelife CTS Northumberland).'),
            new Interest('Photography','Avid photographer, particularly of people, happiest lugging around far more equipment than necessary for a good shot.'),
        ];

        return new CV('Miles Loveday','contactme@milesloveday.com','I am a full stack web developer (tending towards front end development and improving legacy code) with experience of greenfield and legacy projects in Java, PHP and JS/TS (React, Knockout), having worked for clients including the BBC and David Lloyd Leisure. Prior to becoming a developer I had a background in teaching secondary mathematics at top UK schools and studied Information Engineering at the University of Cambridge. I am currently a full time stay at home parent, with a specialty in long distance running.',$employers, $skills, $educators, $interests);
    }
}