<?php

class DBMySql
{
    //public $servername = "localhost"; public $username = "root"; public $password = ""; public $dbname = "doctor_patient_chat";
    public $servername = "mysql8002.site4now.net";    public $username = "a88a62_hlthmon";    public $password = "Freepwd123#";    public $dbname = "db_a88a62_hlthmon";

    // Create New Database connection
    public function GetActiveConnection()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        return $conn;
    }

    public function GetResult($SqlQuery, $DBConnection = null)
    {
        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $result = $conn->query($SqlQuery);

            if ($DBConnection === null) {
                $conn->close();
            }
            return $result;
        } catch (Exception $e) {

            return null;
        }
    }

    public function GetResultAsRowsArray($SqlQuery, $DBConnection = null)
    {
        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $closeConnection = ($DBConnection === null);

            $result = $conn->query($SqlQuery);

            if (!$result)
                return [];

            $fields = $result->fetch_fields(); // 🔥 get column metadata

            $rows = [];

            while ($row = $result->fetch_assoc()) {
                $rows[] = $this->castRowTypes($row, $fields); // 🔥 cast types
            }

            $result->free();

            if ($closeConnection) {
                $conn->close();
            }

            return $rows;

        } catch (Exception $e) {
            return null;
        }
    }


    // Only for executing DML Sql Statements and returns success or DB error
    public function NonQuery($SqlQuery, $DBConnection = null)
    {
        $conn = $DBConnection ?? $this->GetActiveConnection();

        try {
            $result = $conn->query($SqlQuery);

            if ($result) {
                $response = "Success";
            } else {
                $response = $conn->error;
            }

        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        if ($DBConnection === null && isset($conn)) {
            $conn->close();
        }

        return $response;
    }
    public function ScalarQuery($SqlQuery, $DBConnection = null)
    {
        $conn = null;
        $closeConnection = false;

        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $closeConnection = ($DBConnection === null);

            $result = $conn->query($SqlQuery);

            if (!$result) {
                return null;
            }

            $row = $result->fetch_row();
            $result->free();

            return $row[0] ?? null;

        } catch (Exception $e) {
            return null;

        } finally {
            if ($closeConnection && $conn) {
                $conn->close();
            }
        }
    }


    //Returns only single Row from the database on given sql statement
    public function GetSingleRow($SqlQuery, $DBConnection = null)
    {
        $conn = null;
        $closeConnection = false;

        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $closeConnection = ($DBConnection === null);

            $result = $conn->query($SqlQuery);

            if (!$result)
                return null;

            $fields = $result->fetch_fields(); // 🔥 metadata

            $row = $result->fetch_assoc();
            $result->free();

            if (!$row)
                return null;

            return $this->castRowTypes($row, $fields); // 🔥 cast

        } catch (Exception $e) {
            return null;

        } finally {
            if ($closeConnection && $conn) {
                $conn->close();
            }
        }
    }


    //Returns only single Column as an array from the database on given sql statement
    public function GetSingleColumnArray($SqlQuery, $DBConnection = null)
    {
        $conn = null;
        $closeConnection = false;

        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $closeConnection = ($DBConnection === null);
            $result = $conn->query($SqlQuery);

            if (!$result)
                return null;

            $array = [];

            while ($row = $result->fetch_row()) {
                $array[] = $row[0];
            }

            $result->free();

            return $array;

        } catch (Exception $e) {
            return null;

        } finally {
            if ($closeConnection && $conn) {
                $conn->close();
            }
        }
    }

    public function GetDoubleColumnAssociativeArray($SqlQuery, $DBConnection = null)
    {
        $conn = null;
        $closeConnection = false;

        try {
            $conn = $DBConnection ?? $this->GetActiveConnection();
            $closeConnection = ($DBConnection === null);

            $result = $conn->query($SqlQuery);

            if (!$result) {
                return null;
            }

            $array = [];

            while ($row = $result->fetch_row()) {
                // $row[0] = key
                // $row[1] = value
                $array[$row[0]] = $row[1];
            }

            $result->free();

            return $array;

        } catch (Exception $e) {
            return null;

        } finally {
            if ($closeConnection && $conn) {
                $conn->close();
            }
        }
    }
    private function castRowTypes($row, $fields)
    {
        $typedRow = [];

        foreach ($fields as $field) {
            $name = $field->name;

            if (!array_key_exists($name, $row))
                continue;

            $value = $row[$name];

            if (is_null($value)) {
                $typedRow[$name] = null;
                continue;
            }

            switch ($field->type) {
                case MYSQLI_TYPE_TINY:
                case MYSQLI_TYPE_SHORT:
                case MYSQLI_TYPE_LONG:
                case MYSQLI_TYPE_INT24:
                case MYSQLI_TYPE_LONGLONG:
                    $typedRow[$name] = (int) $value;
                    break;

                case MYSQLI_TYPE_DECIMAL:
                case MYSQLI_TYPE_NEWDECIMAL:
                case MYSQLI_TYPE_FLOAT:
                case MYSQLI_TYPE_DOUBLE:
                    $typedRow[$name] = (float) $value;
                    break;

                default:
                    $typedRow[$name] = $value; // keep string (dates, text)
                    break;
            }
        }

        return $typedRow;
    }

    // return server Date Time in 24 hours Format
    public function GetDateTimeNow()
    {
        return date("Y-m-d H:i:s");
    }
    // return server Date Time in 12 hours Format
    public function GetMidNightDateTime()
    {
        return date("Y-m-d") . " 00:00:01";
    }
}
