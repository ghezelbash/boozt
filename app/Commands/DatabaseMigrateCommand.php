<?php

namespace App\Commands;

class DatabaseMigrateCommand extends BaseCommand
{
    public function runner()
    {
        echo "**** Database Migration Started **** \n";

        $this->customersTableMigration();
        $this->countriesTableMigration();
        $this->ordersTableMigration();
        $this->orderItemsTableMigration();

        echo "===== Migration Done ===== \n";
    }

    private function customersTableMigration(): void
    {
        echo " Migrating customers table \n";

        $sqlQuery = "CREATE TABLE IF NOT EXISTS customers (
          id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          first_name VARCHAR(255) NOT NULL,
          last_name VARCHAR(255) NOT NULL,
          email VARCHAR(255) UNIQUE NOT NULL,
          created_at DATETIME NOT NULL,
          updated_at DATETIME NOT NULL
          )";
        $this->app->getDatabaseConnection()->exec($sqlQuery);
        echo " Migrated customers table \n";
    }

    private function countriesTableMigration(): void
    {
        echo " Migrating countries table \n";

        $sqlQuery = "CREATE TABLE IF NOT EXISTS countries (
          id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(63) NOT NULL,
          iso VARCHAR(3) UNIQUE NOT NULL
          )";
        $this->app->getDatabaseConnection()->exec($sqlQuery);
        echo " Migrated countries table \n";
    }

    private function ordersTableMigration(): void
    {
        echo " Migrating orders table \n";

        $sqlQuery = "CREATE TABLE IF NOT EXISTS orders (
          id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          customer_id INT(9) UNSIGNED,
          country_id INT(9) UNSIGNED,
          purchase_date DATETIME,
          FOREIGN KEY (customer_id) REFERENCES customers(id),
          FOREIGN KEY (country_id) REFERENCES countries(id)
          )";
        $this->app->getDatabaseConnection()->exec($sqlQuery);
        echo " Migrated orders table \n";
    }

    private function orderItemsTableMigration(): void
    {
        echo " Migrating order_items table \n";

        $sqlQuery = "CREATE TABLE IF NOT EXISTS order_items (
          id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          order_id INT(9) UNSIGNED,
          EAN VARCHAR(15),
          quantity INT(9),
          price DECIMAL(15, 2),
          FOREIGN KEY (order_id) REFERENCES orders(id)
          )";
        $this->app->getDatabaseConnection()->exec($sqlQuery);
        echo " Migrated order_items table \n";
    }
}