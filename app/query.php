<?php
class Query
{
    private $params = [];
    private $query;
    private $table = "";
    private $columns = "";
    private $type = "";
    private $distinct = "";
    private $order = "";
    private $condition = "";
    private $operator = "";
    private $joins = "";
    private $limit = "";
    private $group_by = "";
    private $other = "";
    private $page = 1;
    private $con;

    function __construct()
    {
        $database = new Database();
    
        $database->setDatabaseName(config("database.database"));
        $database->setUsername(config("database.username"));
        $database->setPassword(config("database.password"));
        $database->setHostname(config("database.hostname"));
        $this->con = $database->connect();
    }

    public function space($value)
    {
        return " " . $value . " ";
    }
    public function is_null($condition, $value)
    {
        return ($condition) ? $value : "";;
    }
    public function select(...$columns)
    {
        // Assigning "select" to the query type variable
        $this->type = "select";

        // Check if columns is not a empty string then put comma before the start of the string
        $_columns = (!empty($this->columns)) ? ", " : " ";
        // Get all the columns
        foreach ($columns as $column) {
            $_columns .= $column . ", ";
        }
        // Remove last comma from the string
        $_columns = substr($_columns, 0, -2);
        $this->columns .= $_columns;
        return $this;
    }
    public function from($table)
    {
        // Assigning the table name for later use
        $this->table = $this->space($table);
        return $this;
    }
    public function distinct()
    {
        $this->distinct = " DISTINCT ";
        return $this;
    }
    public function sort($column, $type = "")
    {
        // Check if order string is not a empty string then put comma before the start of the string
        $this->order .= (!empty($this->order)) ? ", " : " ";
        // For example id DESC, id ASC
        $this->order .= "{$column} {$type}";
        return $this;
    }
    public function innerJoin($table, $column1, $column2)
    {
        $this->joins .= " INNER JOIN {$table} ON {$column1} = $column2 ";
        return $this;
    }
    public function leftJoin($table, $column1, $column2)
    {
        $this->joins .= " LEFT JOIN {$table} ON {$column1} = $column2 ";
        return $this;
    }
    public function rightJoin($table, $column1, $column2)
    {
        $this->joins .= " RIGHT JOIN {$table} ON {$column1} = $column2 ";
        return $this;
    }
    public function limit($limit)
    {
        $this->limit = " LIMIT " . $limit;
        return $this;
    }
    public function group_by($col)
    {
        // Assigning the group name for later use
        $this->group_by = " GROUP BY" . $this->space($col);
        return $this;
    }
    public function paging($page = "", $limit = "")
    {
        $limit = (empty($limit)) ? 1 : $limit;
        $page = (isset($_GET["page"])) ? $_GET["page"] : 1;
        $this->page = $page;
        $offset = ($page - 1) * $limit;
        $limit = " LIMIT {$offset} , {$limit} ";
        $this->limit = $limit;
        return $this;
    }
    public function btns($url, $arr)
    {
        $page = ($this->page == 0) ? 1 : $this->page;

        if ($page > 1) {
            echo '<a href="' . $url . '.php?page=' . $page - '1' . '" class="btn btn-dark px-4 rounded-5 mx-1">Back</a>';
        } else {
            echo '<button class="btn btn-light" disabled>Back</button>';
        }

        if (count($arr) ==  1) {
            echo '<a href="' . $url . '.php?page=' . $page + '1' . '" class="btn btn-dark px-4 rounded-5 mx-1">Next</a>';
        } else {
            echo '<button class="btn btn-light" disabled>Next</button>';
        }
    }
    public function create($table, $columns)
    {
        // Assigning "create" to the query type variable
        $this->type = "create";

        // Assigning the table name for later use
        $this->table = $this->space($table);

        // Getting all the column values by merging two arrays
        $this->params = array_merge($columns, $this->params);

        // Getting all the column names and separating them with commas
        $this->columns .= "(" . implode(", ", array_keys($columns)) . ")";

        $this->columns .= " VALUES (";

        // Getting all the values of the columns and letting them to be a ? for prepare statement
        for ($i = 0; $i < count($columns); ++$i) {
            $this->columns .= "?, ";
        }
        // Removing last comma from the string after ? 
        $this->columns = substr($this->columns, 0, -2);

        $this->columns .= ")";
        return $this;
    }
    public function update($table, $columns)
    {
        // Assigning "update" to the query type variable
        $this->type = "update";

        // Assigning the table name for later use
        $this->table = $this->space($table);

        // Getting all the column values by merging two arrays
        $this->params = array_merge($columns, $this->params);

        // Getting all the values of the columns and letting them to be a ? for prepare statement
        for ($i = 0; $i < count($columns); ++$i) {
            $this->columns  .= array_keys($columns)[$i] . " = ?, ";
        }

        // Removing last comma from the string after ? 
        $this->columns = substr($this->columns, 0, -2);

        return $this;
    }
    public function delete($table)
    {
        // Assigning "delete" to the query type variable
        $this->type = "delete";
        // Assigning the table name for later use
        $this->table = $this->space($table);
        return $this;
    }
    public function first($column = "id")
    {
        return $this->other = "ORDER BY {$column} ASC LIMIT 1";
    }
    public function last($column = "id")
    {
        return $this->other = "ORDER BY {$column} DESC LIMIT 1";
    }
    public function where($condition, $operator = "AND")
    {

        // $condition = array_filter($condition, fn($value) => !is_null($value) && $value !== '');

        // Getting all the column values by merging two arrays
        $this->params = array_merge($this->params, $condition);

        if (empty($this->condition)) {
            $this->condition .= "(";

            // Getting all the values of the columns and letting them to be a ? for prepare statement
            foreach ($condition as $key => $value) {
                $this->condition .= $key . "= ? " . $operator . " ";
            }

            // Removing last operator from the string after ? 
            $this->condition = substr($this->condition, 0,  -strlen($operator) - 1) . ")";
        } else if (!empty($condition)) {

            $this->condition .= " " . $operator . " (";

            // Getting all the values of the columns and letting them to be a ? for prepare statement
            foreach ($condition as $key => $value) {
                $this->condition .= $key . "= ? " . $operator . " ";
            }

            // Removing last operator from the string after ? 
            $this->condition = substr($this->condition, 0,  -strlen($operator) - 1) . ")";
        }
        return $this;
    }
    public function in($col, $condition, $operator = "")
    {
        // Convert string to array after spiliting comma to index
        if (!is_array($condition)) {
            $condition = explode(",", $condition);
        } else {
            $condition = $condition;
        }

        // Getting all the column values by merging two arrays
        $this->params = array_merge($this->params, $condition);

        $this->condition .= $this->space($operator);
        $this->condition .= $this->space($col . " IN");
        $this->condition .= "(";

        // Getting all the values of the columns and letting them to be a ? for prepare statement
        foreach ($condition as $option) {
            $this->condition .= "?, ";
        }

        $this->condition = substr($this->condition, 0, -2);
        $this->condition .= ") ";

        return $this;
    }
    public function search($condition, $operator = "AND")
    {
        // Getting all the column values by merging two arrays
        $this->params = array_merge($this->params, $condition);

        $this->condition .= "(";

        // Getting all the values of the columns and letting them to be a ? for prepare statement
        for ($i = 0; $i < count($condition); ++$i) {
            $this->condition .= array_keys($condition)[$i] . " LIKE '%' ? '%' " . $operator . " ";
        }

        // Removing last operator from the string after ? 
        $this->condition = substr($this->condition, 0,  -strlen($operator) - 1) . " ) ";
        return $this;
    }
    public function execute($exec = "")
    {
        $query = "";
        // Making a query string
        if ($this->type == "select") {
            $query .= $this->space("SELECT");
            $query .= $this->distinct;
            $query .= $this->columns;
            $query .= $this->space("FROM");
            $query .= $this->table;
            $query .= $this->joins;
            $query .= $this->is_null($this->condition, " WHERE ");
            $query .= $this->condition;
            $query .= $this->group_by;
            $query .= $this->is_null($this->order, " ORDER BY ");
            $query .= $this->order;
            $query .= $this->limit;
            $query .= $this->other;
        } else if ($this->type == "create") {
            $query .= $this->space("INSERT INTO");
            $query .= $this->table;
            $query .= $this->columns;
        } else if ($this->type == "update") {
            $query .= $this->space("UPDATE");
            $query .= $this->table;
            $query .= $this->space("SET");
            $query .= $this->columns;
            $query .= $this->is_null($this->condition, " WHERE ");
            $query .= $this->condition;
        } else if ($this->type == "delete") {
            $query .= $this->space("DELETE FROM");
            $query .= $this->table;
            $query .= $this->is_null($this->condition, " WHERE ");
            $query .= $this->condition;
        }

        $this->query = $query;

        // Spliting the assoc array and getting all the values
        $params = urldecode(http_build_query($this->params, ' ', '<br><br>'));

        // Display the query 
        if ($exec == "query") {
            $template = "<div style='font-size:14px;font-family:arial;position:fixed;left:20%;right:20%;top:20%;z-inded:999;background:#222;color:white;border-radius:15px;padding:20px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;'>";
            $template .= "<h1 style='color:orange;'>SQL QUERY</h1>";
            $template .= "<p style='font-size:14px;'><q>" . $this->query . "</q></p>";
            if (count(array_values($this->params)) !== 0) {
                $template .= "<h3 style='color:yellow;'>Binding params</h3>";
                $template .= "<p style='background:#fff;color:#000;border-radius:5px;padding:10px;'>" . $params . "</p>";
            }
            $template .= "</div>";
            echo $template;
        }

        // Execute the query 
        try {
            // Preparing the sql query 
            $result = $this->con->prepare($this->query);
            $result->execute(array_values($this->params));


            // Reseting all the values
            $this->table = "";
            $this->distinct = "";
            $this->columns = "";
            $this->joins = "";
            $this->condition = "";
            $this->operator = "";
            $this->order = "";
            $this->limit = "";
            $this->other = "";
            array_splice($this->params, 0);

            // Returning the main result after execution
            $this->query = $result;
        } catch (Exception $e) {
            $template = "<div style='font-size:14px;font-family:arial;position:fixed;left:20%;right:20%;top:20%;z-inded:9999;background:#222;color:white;border-radius:15px;padding:20px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;'>";
            $template .= "<h1 style='color:red;font-family:arial;margin:10px 0;'>Query error occured</h1>";
            $template .= "<p><b>Line number :</b> {$e->getLine()}</p>";
            $template .= "<p><b>Filename</b> :</b> {$e->getFile()}</p>";
            $template .= "<p><b>Message</b> :</b> {$e->getMessage()}</p>";
            $template .= "<hr>";
            $template .= "<h3 style='color:orange;'>SQL QUERY</h3>";
            $template .= "<p style='font-size:14px;'><q>" . $this->query . "</q></p>";
            if (count(array_values($this->params)) !== 0) {
                $template .= "<h3 style='color:yellow;'>Binding params</h3>";
                $template .= "<p style='background:#fff;color:#000;border-radius:5px;padding:10px;'>" . $params . "</p>";
            }
            $template .= "</div>";
            echo $template;
        }

        if ($this->type == "select") {
            return $this;
        } else {
            return true;
        }
    }

    public function fetch($type = "all")
    {
        try {
            $result = $this->query->setFetchMode(PDO::FETCH_ASSOC);

            if ($type == "all") {
                $result = $this->query->fetchall();
            }
            if ($type == "one") {
                $result = $this->query->fetch();
            }
            return $result;
        } catch (Error $e) {
            return "Can't fetch records";
        }
    }

    public function lastid()
    {
        return $this->con->lastInsertId();
    }

    /*** Connection End ***/
    function __destruct()
    {
        $this->con = NULL;
        if ($this->con == null) {
            return true;
        }
    }
}
function query()
{
    return new Query();
}
