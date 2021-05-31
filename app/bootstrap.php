<?php

use App\Controllers\DashboardControllers;
use App\Core\Database;
use App\Core\Request;
use Dotenv\Dotenv;

Class Bootstrap
{

    private $dbConnection;

    public function __construct()
    {
        $this->setEnvironmentVariable();
        $this->setDatabaseConnection();
    }

    public function getDatabaseConnection(): PDO
    {
        return $this->dbConnection;
    }

    private function setEnvironmentVariable(): void
    {
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotEnv->load();
    }

    private function setDatabaseConnection(): void
    {
        $this->dbConnection = Database::getConnection();
    }

    public function router()
    {
        $request = new Request();
        switch ($request->request_uri) {
            case '/dashboard':
                return (new DashboardControllers())->index($request);
                break;
            default:
                return '<h1 style="text-align: center;padding: 20% 0">404 - PAGE NOT FOUND</h1>';
        }
    }
}