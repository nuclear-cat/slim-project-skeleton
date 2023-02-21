<?php declare(strict_types=1);

namespace App\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221211175226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE video_meetings (id uuid NOT NULL, title VARCHAR(255) DEFAULT NULL, created_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN video_meetings.id IS \'(DC2Type:video_meeting_id)\'');
        $this->addSql('COMMENT ON COLUMN video_meetings.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE video_meetings');
    }
}
