<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211005254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            INSERT INTO `users` (
    `id`, 
    `email`, 
    `roles`, 
    `password`, 
    `last_login`
) VALUES (
    NULL, 
    \'admin@reports.com\', 
    \'[]\', 
    \'$argon2id$v=19$m=65536,t=4,p=1$TckZWHVXQdqvf7r187KwsA$Gc1IESNjAIfQUCLgr7IGELQD7ZfyX0nx66C/tqVq0XY\',
    NULL
),
(
    NULL, 
    \'user@reports.com\', 
    \'[]\', 
    \'$argon2id$v=19$m=65536,t=4,p=1$UwiRyFsSZfQwmY5cwyfHOw$/9XObUZmsB8GUpBWA9x2y9FWXWicU7sjDrYhQsEW0Lc\',
    NULL
);
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
