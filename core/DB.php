<?php

class DB
{
    public static $instance = null;
    public $pdo;
    public $table;
    private $query;
    private $results;
    private $conditions = [];
    const PRIMARY_KEY = 'id';

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=mvctest', 'root', 123);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if ( ! isset(self::$instance)) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    /**
     * Creates an sql query based on $columns.
     * If $columns is empty function will select everything by default.
     * "SELECT * FROM $table"
     * If $columns is provided: "SELECT `fname`, `lname` FROM $table"
     *
     * @param string $table
     * @param array $columns A list where each elements is a column name
     *
     *
     * @return object $this
     */
    public function select($table, $columns = [])
    {
        $this->query = "SELECT ";
        if (empty($columns)) {
            $this->query .= "*";
        } else {
            $this->query = "SELECT ";
            foreach ($columns as $column) {
                $column      = htmlspecialchars($column);
                $this->query .= "`{$column}`,";
            }

            $this->query = rtrim($this->query, ',');
        }
        $this->query .= " FROM {$table}";

        return $this;
    }

    /**
     * Adds where clause to existing query based on $conditions.
     * Adds "AND" between conditions.
     * "SELECT * FROM table_name WHERE `id` < ? AND `lname` = ?
     *
     * @param array $conditions List of lists where each inside list
     * has 3 elements. First element is column name, second is operator,
     * third is value. example: [['id', '<', '4'], ['lname', '=', 'Mitic']]
     * Values will be but in $this->>conditions to be bound later.
     *
     * @return $this
     */
    public function where($conditions = [])
    {
        $this->conditions = $conditions;
        $this->query      .= " WHERE ";

        $this->addClause(' AND ');

        $this->query = rtrim($this->query, ' AND ');

        return $this;
    }

    /**
     * Adds "OR" condition to existing query.
     * Example: "SELECT * FROM table_name WHERE `id` < ? OR `lname` = ?"
     *
     * @param array $conditions Same as for where() method.
     *
     * @return object $this
     */
    public function orWhere($conditions = [])
    {
        $this->setConditions($conditions);
        $this->query .= " OR `{$conditions[0]}` {$conditions[1]} ?";

        return $this;
    }

    /**
     * Adds "ORDER BY to existing query"
     * Example: "SELECT * FROM table_name ORDER BY `id` ASC
     *
     * @param string $column Column you want to order by.
     * @param string $direction Direction you want to order in ASC/DESC ...
     *
     * @return object $this
     */
    public function orderBy($column = 'id', $direction = 'DESC')
    {
        $direction   = htmlspecialchars($direction);
        $this->query .= " ORDER BY `{$column}` {$direction}";

        return $this;
    }

    /**
     * Adds "LIMIT value" to existing query;
     * Example; "SELECT * FROM table_name LIMIT 4"
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $limit       = esc($limit);
        $this->query .= " LIMIT {$limit}";

        return $this;
    }

    /**
     * Adds search by id to existing query.
     * Example: "SELECT * FROM table_name WHERE `id` = 5"
     *
     * @param $id
     *
     * @return object $this
     */
    public function find($id)
    {
        $this->query .= " WHERE ";
        $this->setConditions([self::PRIMARY_KEY, '=', $id]);

        $this->addClause();


        return $this;
    }

    public function first($limit = 1)
    {
        $this->orderBy()->limit($limit);

        return $this;
    }

    /**
     * Prepares the query and binds params.
     *
     * @return bool
     */
    public function query()
    {
        $stmt = $this->pdo->prepare($this->query);

        if ( ! empty($this->conditions)) {
            for ($i = 0; $i < sizeof($this->conditions); $i++) {
                $stmt->bindValue($i + 1, $this->conditions[$i][2]);
            }
        }

        if ($flag = $stmt->execute()) {
            $this->results = $stmt->fetchAll(PDO::FETCH_OBJ);

            return true;
        }

        return false;
    }

    /**
     * Runs delete query based on id.
     *
     * @param string $table
     * @param string $id
     *
     * @return bool
     */
    public function delete($table, $id = '')
    {
        $this->query = "DELETE FROM {$table} WHERE ";
        $this->setConditions([self::PRIMARY_KEY, '=', esc($id)]);
        $this->addClause();

        return $this->query();
    }

    /**
     * Creates and executes CREATE query.
     *
     * @param $table
     * @param array $data Associative array where
     * key is the columns and and value is input value.
     */
    public function create($table, $data)
    {
        $columns = '';
        $values  = '';

        if ($data) {
            foreach ($data as $column => $value) {
                $columns .= $column . ', ';
                $values  .= '?, ';
                $this->setConditions([null, null, esc($value)]);
            }
            $columns = rtrim($columns, ', ');
            $values  = rtrim($values, ', ');
        }

        $this->query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        $this->query();
    }

    /**
     * Creates and executes UPDATE query based od primary key (id) column
     *
     * @param $table
     * @param $columns_and_values
     * @param $id
     */
    public function update($table, $columns_and_values, $id)
    {
        $set         = '';
        $this->query = "UPDATE {$table} SET ";

        foreach ($columns_and_values as $column => $value) {
            $set .= $column . ' = ?, ';
            $this->setConditions([null, null, esc($value)]);
        }
        $set = rtrim($set, ', ');

        $this->setConditions([self::PRIMARY_KEY, '=', $id]);
        $this->query .= $set . " WHERE `" . self::PRIMARY_KEY . "` = ?";

        $this->query();
    }

    public function get()
    {
        $this->query();
        $this->conditions = [];

        return $this->results;
    }

    private function addClause($extendConditions = '')
    {
        foreach ($this->conditions as $condition) {
            $this->query .= "`{$condition[0]}` {$condition[1]} ?{$extendConditions}";
        }
    }

    private function setConditions($conditions = [])
    {
        array_push($this->conditions, $conditions);
    }
}