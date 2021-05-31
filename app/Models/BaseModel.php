<?php

namespace App\Models;

abstract class BaseModel
{
    protected $table;

    protected $app;
    protected $db;

    public function __construct()
    {
        $this->app = new \Bootstrap();
        $this->db = $this->app->getDatabaseConnection();
    }

    /**
     * This function finds and returns object by id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $sqlQuery = "SELECT * from {$this->table} where `id` = {$id}";
        $statement = $this->db->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchObject();
    }

    /**
     * This function inserts data in table and return true/false
     * @param array $data
     * @return bool
     */
    public function insert(array $data)
    {
        $columnsString = implode(', ', array_keys($data));
        $questionMarkString = prepareStatementQuestionMarks(count($data));

        $statement = $this->db->prepare(
            "INSERT INTO {$this->table} ({$columnsString})
              VALUES ({$questionMarkString})");

        return $statement->execute(array_values($data));
    }

    /**
     * This function inserts data in table and returns inserted object
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            $this->db->beginTransaction();
            $this->insert($data);
            $insertedDataId = $this->db->lastInsertId();
            $this->db->commit();
        } catch(\Exception $e) {
            $this->db->rollback();
            throw new \Exception("Error!: " . $e->getMessage() . "</br>");
        }
        return $this->find($insertedDataId);
    }
}