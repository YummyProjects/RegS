<?php

/**
 * Class to working with data base
 */
class DataBase {

    private PDO $dataBase;
    private PDOStatement $queryFetcher;

    /**
     * Base constructor for DataBase class
     */
    public function __construct(string $hostname, string $username, string $password, string $dataBaseName) {
        try {
            $dataBase = new PDO("mysql:dbname=".$dataBaseName.";host=".$hostname, $username, $password);
        } 
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Prepared query for subsequent execution
     */
    private function prepareQuery(string $preparedQuery): void {
        $this::$queryFetcher = $this::$dataBase->prepare($preparedQuery);

        if ($this::$queryFetcher === false) {
            die("Invalid prepared query.");
        }
    }

    /**
     * Executes current prepared query
     */
    private function executeQuery(array $queryParams): void {
        if (!isset($this::$queryFetcher)) {
            die("Invalid order of query execution. Prepare query before execute it.");
        }

        try {
            $result = $this::$queryFetcher->execute($queryParams); 

            if (!$result) {
                die("Query execution failed.");
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * 
     */
    public function query(string $preparedQuery, array $queryParams) {
        $this->prepareQuery($preparedQuery);
        $this->executeQuery($queryParams);
    }

    /**
     * Returns query executor 
     */
    public function getFetcher(): PDOStatement {
        return $this::$queryFetcher;
    }

}