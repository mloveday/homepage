<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200223201011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add display_order and archived fields to entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cv_interest ADD archived TINYINT(1) DEFAULT \'0\' NOT NULL, ADD display_order INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE curriculum_vitae ADD archived TINYINT(1) DEFAULT \'0\' NOT NULL, ADD display_order INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE cv_employer ADD archived TINYINT(1) DEFAULT \'0\' NOT NULL, ADD display_order INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE cv_educator ADD archived TINYINT(1) DEFAULT \'0\' NOT NULL, ADD display_order INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE cv_skill ADD archived TINYINT(1) DEFAULT \'0\' NOT NULL, ADD display_order INT DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE curriculum_vitae DROP archived, DROP display_order');
        $this->addSql('ALTER TABLE cv_educator DROP archived, DROP display_order');
        $this->addSql('ALTER TABLE cv_employer DROP archived, DROP display_order');
        $this->addSql('ALTER TABLE cv_interest DROP archived, DROP display_order');
        $this->addSql('ALTER TABLE cv_skill DROP archived, DROP display_order');
    }
}
