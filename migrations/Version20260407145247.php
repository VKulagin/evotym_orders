<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407145247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id UUID NOT NULL, product_id UUID NOT NULL, customer_name VARCHAR(255) NOT NULL, quantity_ordered INT NOT NULL, order_status VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE4584665A ON orders (product_id)');
        $this->addSql('COMMENT ON COLUMN orders.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, name VARCHAR(255) NOT NULL, price_amount INT NOT NULL, price_currency VARCHAR(3) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEE4584665A');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE products');
    }
}
