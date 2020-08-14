<?php

class Model
{
    protected $pdo;

    public function __construct($table)
    {
        $this->pdo        = DB::getInstance();
        $this->pdo->table = $table;
    }

    public function select($columns = [])
    {
        return $this->pdo->select($this->pdo->table, $columns);
    }

    public function delete($id)
    {
        $this->pdo->delete($this->pdo->table, $id);
    }

    public function create($data)
    {
        $this->pdo->create($this->pdo->table, $data);
    }

    public function update($columns_and_values, $id)
    {
        $this->pdo->update($this->pdo->table, $columns_and_values, $id);
    }
}