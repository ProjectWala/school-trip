<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
header('Content-Type: application/json');
require_once "../db/DBMySql.php";
$db = new DBMySql();
$service = new ServiceApi($db);
$data = json_decode(file_get_contents("php://input"), true);
//$data = array_combine(array_map('trim', array_keys($data)), $data);

//echo json_encode($data);
// return;

$action = $_GET["action"] ?? "";
$action = strtolower($action);
//echo $action;return;    
try {

    switch ($action) {

        case "getdb":
            $result = $service->GetDB();
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "updatedb":
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                throw new Exception("Invalid input DB JSON");
            }

            $result = $service->UpdateDB($data);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "gettable":
            $table = $_GET["table"] ?? null;

            if (!$table) {
                throw new Exception("Table name missing");
            }

            $result = $service->GetTable($table);
            echo json_encode($result);
            break;

        case "updatetable":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table name or data missing");
            }

            $result = $service->UpdateTable($table, $data);
            echo json_encode($result);
            break;

        case "insert":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or data missing");
            }

            $obj = (object) $data;
            $result = $service->Insert($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "bulkinsert":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data || !is_array($data)) {
                throw new Exception("Table or array of objects missing");
            }

            $objects = array_map(function ($d) {
                return (object) $d;
            }, $data);

            $success = $service->BulkInsert($table, $objects);
            echo json_encode(["success" => $success]);
            break;

        case "update":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or data missing");
            }

            $obj = (object) $data;
            $result = $service->Update($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "bulkupdate":
            $table = $_GET["table"] ?? null;
            $input = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$input) {
                throw new Exception("Table or input missing");
            }

            $data = $input["data"] ?? null;
            $conditions = $input["conditions"] ?? null;

            if (!$data || !$conditions) {
                throw new Exception("Update data or conditions missing");
            }

            $obj = (object) $data;

            $result = $service->BulkUpdate($table, $obj, $conditions);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "bulkupsert":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data || !is_array($data)) {
                throw new Exception("Table or array of objects missing");
            }

            $objects = array_map(function ($d) {
                return (object) $d;
            }, $data);

            $result = $service->BulkUpsert($table, $objects);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "save":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or data missing");
            }

            $obj = (object) $data;
            $result = $service->Save($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "bulksave":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data || !is_array($data)) {
                throw new Exception("Table or array of objects missing");
            }

            // convert to objects
            $objects = array_map(function ($d) {
                return (object) $d;
            }, $data);

            $result = $service->BulkSave($table, $objects);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;


        case "deletebyid":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);
            $data = array_change_key_case($data, CASE_LOWER);
            $id = $data['id'] ?? null;

            if (!$table || !$id) {
                throw new Exception("Table or ID missing");
            }

            $success = $service->DeleteById($table, $id);
            echo json_encode(["success" => $success]);
            break;

        case "getbyid":
            $table = $_GET["table"] ?? null;
            $id = $_GET["id"] ?? null;

            if (!$table || !$id) {
                throw new Exception("Table or ID missing");
            }

            $result = $service->GetById($table, $id);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "getlist":
            $table = $_GET["table"] ?? null;
            $where = $_GET["where"] ?? "";
            $order = $_GET["order"] ?? "";
            $limit = $_GET["limit"] ?? "";

            if (!$table) {
                throw new Exception("Table missing");
            }

            $result = $service->GetList($table, $where, $order, $limit);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "find":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or search data missing");
            }

            $obj = (object) $data;
            $result = $service->Find($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "filterbyand":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or filter data missing");
            }

            $obj = (object) $data;
            $result = $service->FilterByAnd($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "filterbyor":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or filter data missing");
            }

            $obj = (object) $data;
            $result = $service->FilterByOr($table, $obj);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "execute":
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data || !isset($data["sql"])) {
                throw new Exception("SQL query missing");
            }

            $sql = $data["sql"];

            $result = $service->Execute($sql);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "savenesteddeep":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or data missing");
            }

            $obj = (object) $data;
            $result = $service->SaveNestedDeep($table, $obj);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "syncnesteddeep":
            $table = $_GET["table"] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$table || !$data) {
                throw new Exception("Table or data missing");
            }

            $obj = (object) $data;
            $result = $service->SyncNestedDeep($table, $obj);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case "getnesteddeep":
            $table = $_GET["table"] ?? null;
            $id = $_GET["id"] ?? null;

            if (!$table || !$id) {
                throw new Exception("Table or ID missing");
            }

            $result = $service->GetNestedDeep($table, $id);

            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

class ServiceApi
{
    private $db;

    public function __construct(DBMySql $db)
    {
        $this->db = $db;
    }



    public function BeginTransaction($conn)
    {
        $conn->begin_transaction();
    }

    public function Commit($conn)
    {
        $conn->commit();
    }

    public function Rollback($conn)
    {
        $conn->rollback();
    }

    public function Insert($table, $obj, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            $mapped = $this->MapObjectToColumns($obj, $columns, $pk);

            $cols = [];
            $vals = [];

            foreach ($mapped as $col => $val) {
                $cols[] = "`$col`";

                if (is_null($val)) {
                    $vals[] = "NULL";   // ✅ FIX
                } else {
                    $vals[] = "'" . $conn->real_escape_string($val) . "'";
                }
            }

            $sql = "INSERT INTO `$table`(" . implode(",", $cols) . ")
                VALUES(" . implode(",", $vals) . ")";

            $conn->query($sql);

            $id = $conn->insert_id;

            return $this->GetById($table, $id, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function BulkInsert($table, $objects, $DBConnection = null)
    {
        if (!$objects || count($objects) == 0)
            return false;

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            $first = get_object_vars($objects[0]);

            // normalize keys
            $firstLower = [];
            foreach ($first as $k => $v) {
                $firstLower[strtolower($k)] = $v;
            }

            $cols = [];

            foreach ($columns as $col) {
                if ($col == $pk)
                    continue;

                if (array_key_exists(strtolower($col), $firstLower))
                    $cols[] = $col;
            }

            $rows = [];

            foreach ($objects as $obj) {

                $props = get_object_vars($obj);

                $propsLower = [];
                foreach ($props as $k => $v) {
                    $propsLower[strtolower($k)] = $v;
                }

                $vals = [];

                foreach ($cols as $col) {
                    $val = $propsLower[strtolower($col)] ?? null;

                    if (is_null($val)) {
                        $vals[] = "NULL";   // ✅ FIX
                    } else {
                        $vals[] = "'" . $conn->real_escape_string($val) . "'";
                    }
                }

                $rows[] = "(" . implode(",", $vals) . ")";
            }

            $escapedCols = array_map(fn($c) => "`$c`", $cols);

            $sql = "INSERT INTO `$table`(" . implode(",", $escapedCols) . ")
                VALUES " . implode(",", $rows);

            return $conn->query($sql);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function Update($table, $obj, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            $props = get_object_vars($obj);

            // normalize keys
            $propsLower = [];
            foreach ($props as $key => $value) {
                $propsLower[strtolower($key)] = $value;
            }

            $pkLower = strtolower($pk);

            if (!isset($propsLower[$pkLower])) {
                return null;
            }

            $id = $conn->real_escape_string($propsLower[$pkLower]);

            $mapped = [];

            foreach ($columns as $col) {
                $colLower = strtolower($col);

                if ($colLower === $pkLower)
                    continue;

                if (array_key_exists($colLower, $propsLower)) {
                    $mapped[$col] = $propsLower[$colLower];
                }
            }

            if (empty($mapped)) {
                return $this->GetById($table, $id, $conn);
            }

            $updates = [];

            foreach ($mapped as $col => $val) {

                if (is_null($val)) {
                    $updates[] = "`$col`=NULL";   // ✅ FIX
                } else {
                    $updates[] = "`$col`='" . $conn->real_escape_string($val) . "'";
                }
            }

            $sql = "UPDATE `$table`
                SET " . implode(",", $updates) . "
                WHERE `$pk`=$id";

            $conn->query($sql);

            return $this->GetById($table, $id, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function BulkUpdate($table, $obj, $conditions, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            if (!$obj || !$conditions) {
                throw new Exception("Update data or conditions missing");
            }

            $columns = $this->GetColumns($table, $conn);

            // map DB columns (case-insensitive)
            $colMap = [];
            foreach ($columns as $col) {
                $colMap[strtolower($col)] = $col;
            }

            $props = get_object_vars($obj);

            if (count($props) === 0) {
                throw new Exception("No fields to update");
            }

            $propsLower = [];
            foreach ($props as $key => $value) {
                $propsLower[strtolower($key)] = $value;
            }

            $updates = [];

            foreach ($propsLower as $key => $val) {

                if (isset($colMap[$key])) {
                    $colName = $colMap[$key];

                    if (is_null($val)) {
                        $updates[] = "`$colName`=NULL";   // ✅ FIX
                    } else {
                        $escapedVal = $conn->real_escape_string($val);
                        $updates[] = "`$colName`='$escapedVal'";
                    }
                }
            }

            if (empty($updates)) {
                throw new Exception("No valid columns found to update");
            }

            // build WHERE clause
            $where = $this->BuildWhere($conditions, "AND", $conn);

            if (empty($where)) {
                throw new Exception("Invalid conditions for update");
            }

            $sql = "UPDATE `$table`
                SET " . implode(",", $updates) . "
                WHERE $where";

            $result = $conn->query($sql);

            return [
                "success" => $result,
                "affected_rows" => $conn->affected_rows
            ];

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }
    public function BulkUpsert($table, $objects, $DBConnection = null)
    {
        if (!$objects || count($objects) == 0)
            return false;

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            // normalize first object
            $first = get_object_vars($objects[0]);
            $firstLower = [];

            foreach ($first as $k => $v) {
                $firstLower[strtolower($k)] = $v;
            }

            // valid columns
            $cols = [];
            foreach ($columns as $col) {
                if (array_key_exists(strtolower($col), $firstLower)) {
                    $cols[] = $col;
                }
            }

            $rows = [];

            foreach ($objects as $obj) {

                $props = get_object_vars($obj);

                $propsLower = [];
                foreach ($props as $k => $v) {
                    $propsLower[strtolower($k)] = $v;
                }

                $vals = [];

                foreach ($cols as $col) {
                    $val = $propsLower[strtolower($col)] ?? null;

                    if (is_null($val)) {
                        $vals[] = "NULL";
                    } else {
                        $vals[] = "'" . $conn->real_escape_string($val) . "'";
                    }
                }

                $rows[] = "(" . implode(",", $vals) . ")";
            }

            // columns
            $escapedCols = array_map(fn($c) => "`$c`", $cols);

            // update clause (exclude PK)
            $updates = [];
            foreach ($cols as $col) {
                if ($col == $pk)
                    continue;

                $updates[] = "`$col` = VALUES(`$col`)";
            }

            $sql = "INSERT INTO `$table` (" . implode(",", $escapedCols) . ")
                VALUES " . implode(",", $rows) . "
                ON DUPLICATE KEY UPDATE " . implode(",", $updates);

            $result = $conn->query($sql);

            return [
                "success" => $result,
                "affected_rows" => $conn->affected_rows
            ];

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }
    public function Save($table, $obj, $DBConnection = null)
    {

        $props = get_object_vars($obj);

        // Find the 'id' property case-insensitively
        $idKey = null;
        foreach ($props as $key => $value) {
            if (strcasecmp($key, 'id') === 0) {
                $idKey = $key;
                break;
            }
        }

        // If an ID exists and is not null/empty, update; otherwise, insert
        if ($idKey !== null && $props[$idKey] !== null && $props[$idKey] !== '') {
            return $this->Update($table, $obj, $DBConnection);
        }

        return $this->Insert($table, $obj, $DBConnection);
    }

    public function BulkSave($table, $objects, $DBConnection = null)
    {
        if (!$objects || count($objects) == 0)
            return [];

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        $results = [];

        try {

            foreach ($objects as $obj) {

                // ensure object format
                if (is_array($obj)) {
                    $obj = (object) $obj;
                }

                // use existing Save() logic (handles insert/update)
                $saved = $this->Save($table, $obj, $conn);

                $results[] = $saved;
            }

            return $results;

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }
    public function GetNestedDeep($table, $id, $parent = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {

            // 🔹 Get primary key
            $pk = $this->GetPrimaryKey($table, $conn);

            // 🔹 Fetch main record
            $row = $this->GetById($table, $id, $conn);

            if (!$row)
                return null;

            // 🔥 Find all child tables dynamically
            $childTables = $this->FindChildTables($table, $conn);

            foreach ($childTables as $childInfo) {

                $childTable = $childInfo["table"];
                $fkColumn = $childInfo["fk"];

                // 🔹 Get child rows
                $children = $this->GetList(
                    $childTable,
                    "`$fkColumn`='" . $conn->real_escape_string($id) . "'",
                    "",
                    "",
                    $conn
                );

                // 🔁 Recursively fetch nested children
                $nestedChildren = [];

                foreach ($children as $childRow) {

                    $childId = $childRow[$this->GetPrimaryKey($childTable, $conn)];

                    $nestedChildren[] = $this->GetNestedDeep(
                        $childTable,
                        $childId,
                        ["table" => $table],
                        $conn
                    );
                }

                // 🔹 Attach using clean key (remove parent prefix)
                $keyName = $this->NormalizeChildKey($childTable, $table);

                $row[$keyName] = $nestedChildren;
            }

            return $row;

        } finally {

            if ($parent === null) {
                $this->closeConnection($conn, $closeConnection);
            }
        }
    }
    public function SaveNestedDeep($table, $obj, $parent = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            if ($parent === null) {
                $this->BeginTransaction($conn);
            }

            // 🔹 Table metadata
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            // 🔹 Convert object → clean array
            $props = json_decode(json_encode($obj), true);

            $mainData = [];
            $childCollections = [];

            // 🔹 Separate fields and child arrays
            foreach ($props as $key => $value) {
                if (is_array($value)) {
                    $childCollections[$key] = $value;
                } else {
                    $mainData[$key] = $value;
                }
            }

            // 🔥 REMOVE FK from incoming payload
            if ($parent) {
                $parentTable = strtolower($parent['table']);

                foreach ($mainData as $k => $v) {
                    $kLower = strtolower($k);

                    if (
                        $kLower === $parentTable . "id" ||
                        $kLower === $parentTable . "_id" ||
                        $kLower === rtrim($parentTable, 's') . "id" ||
                        $kLower === rtrim($parentTable, 's') . "_id"
                    ) {
                        unset($mainData[$k]);
                    }
                }
            }

            // 🔹 Inject FK using DB column names
            if ($parent) {
                $parentTable = strtolower($parent['table']);
                $parentId = $parent['id'];

                foreach ($columns as $col) {
                    $colLower = strtolower($col);

                    if (
                        $colLower === $parentTable . "id" ||
                        $colLower === $parentTable . "_id" ||
                        $colLower === rtrim($parentTable, 's') . "id" ||
                        $colLower === rtrim($parentTable, 's') . "_id"
                    ) {
                        $mainData[$col] = $parentId;
                    }
                }
            }

            // 🔹 Keep only valid DB columns
            $clean = [];
            foreach ($columns as $col) {
                foreach ($mainData as $k => $v) {
                    if (strtolower($k) === strtolower($col)) {
                        $clean[$col] = $v;
                    }
                }
            }

            // 🔹 Save main record (Insert/Update)
            $saved = $this->Save($table, (object) $clean, $conn);
            if (!$saved) {
                throw new Exception("Failed to save $table");
            }

            $currentId = $saved[$pk];

            // 🔁 Process child collections
            foreach ($childCollections as $childKey => $rows) {

                if (!is_array($rows))
                    continue;

                $childTable = $this->ResolveChildTable($childKey, $table, $conn);
                if (!$childTable)
                    continue;

                // 🔹 Detect FK column in child table
                $fkColumn = null;
                $childColumns = $this->GetColumns($childTable, $conn);

                $parentLower = strtolower($table);
                $parentSingular = rtrim($parentLower, 's');

                foreach ($childColumns as $col) {
                    $colLower = strtolower($col);

                    if (
                        $colLower === $parentLower . "id" ||
                        $colLower === $parentLower . "_id" ||
                        $colLower === $parentSingular . "id" ||
                        $colLower === $parentSingular . "_id"
                    ) {
                        $fkColumn = $col;
                        break;
                    }
                }

                if (!$fkColumn)
                    continue;

                // 🔁 Loop through incoming child rows (NO DELETE LOGIC)
                foreach ($rows as $row) {

                    if (!is_array($row))
                        continue;

                    $rowCopy = json_decode(json_encode($row), true);

                    // 🔥 remove FK from child payload
                    foreach ($rowCopy as $k => $v) {
                        if (strtolower($k) === strtolower($fkColumn)) {
                            unset($rowCopy[$k]);
                        }
                    }

                    $parentContext = [
                        "table" => $table,
                        "id" => $currentId
                    ];

                    // 🔁 recursive save
                    $this->SaveNestedDeep(
                        $childTable,
                        (object) $rowCopy,
                        $parentContext,
                        $conn
                    );
                }
            }

            if ($parent === null) {
                $this->Commit($conn);
            }

            return $saved;

        } catch (Exception $e) {

            if ($parent === null) {
                $this->Rollback($conn);
            }

            throw $e;

        } finally {
            if ($parent === null) {
                $this->closeConnection($conn, $closeConnection);
            }
        }
    }
    public function SyncNestedDeep($table, $obj, $parent = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            if ($parent === null) {
                $this->BeginTransaction($conn);
            }

            // 🔹 Table metadata
            $columns = $this->GetColumns($table, $conn);
            $pk = $this->GetPrimaryKey($table, $conn);

            // 🔹 Convert object → clean array (prevents reference bugs)
            $props = json_decode(json_encode($obj), true);

            $mainData = [];
            $childCollections = [];

            // 🔹 Separate fields and child arrays
            foreach ($props as $key => $value) {
                if (is_array($value)) {
                    $childCollections[$key] = $value;
                } else {
                    $mainData[$key] = $value;
                }
            }

            // 🔥 REMOVE FK from incoming payload (critical)
            if ($parent) {
                $parentTable = strtolower($parent['table']);

                foreach ($mainData as $k => $v) {
                    $kLower = strtolower($k);

                    if (
                        $kLower === $parentTable . "id" ||
                        $kLower === $parentTable . "_id" ||
                        $kLower === rtrim($parentTable, 's') . "id" ||
                        $kLower === rtrim($parentTable, 's') . "_id"
                    ) {
                        unset($mainData[$k]);
                    }
                }
            }

            // 🔹 Inject FK using REAL DB column names
            if ($parent) {
                $parentTable = strtolower($parent['table']);
                $parentId = $parent['id'];

                foreach ($columns as $col) {
                    $colLower = strtolower($col);

                    if (
                        $colLower === $parentTable . "id" ||
                        $colLower === $parentTable . "_id" ||
                        $colLower === rtrim($parentTable, 's') . "id" ||
                        $colLower === rtrim($parentTable, 's') . "_id"
                    ) {
                        $mainData[$col] = $parentId; // ✅ correct casing
                    }
                }
            }

            // 🔹 Keep only valid DB columns
            $clean = [];
            foreach ($columns as $col) {
                foreach ($mainData as $k => $v) {
                    if (strtolower($k) === strtolower($col)) {
                        $clean[$col] = $v;
                    }
                }
            }

            // 🔹 Save main record
            $saved = $this->Save($table, (object) $clean, $conn);
            if (!$saved) {
                throw new Exception("Failed to save $table");
            }

            $currentId = $saved[$pk];

            // 🔁 Process child collections
            foreach ($childCollections as $childKey => $rows) {

                if (!is_array($rows))
                    continue;

                $childTable = $this->ResolveChildTable($childKey, $table, $conn);
                if (!$childTable)
                    continue;

                // 🔹 Detect FK column in child table
                $fkColumn = null;
                $childColumns = $this->GetColumns($childTable, $conn);

                $parentLower = strtolower($table);
                $parentSingular = rtrim($parentLower, 's');

                foreach ($childColumns as $col) {
                    $colLower = strtolower($col);

                    if (
                        $colLower === $parentLower . "id" ||
                        $colLower === $parentLower . "_id" ||
                        $colLower === $parentSingular . "id" ||
                        $colLower === $parentSingular . "_id"
                    ) {
                        $fkColumn = $col;
                        break;
                    }
                }

                if (!$fkColumn)
                    continue;

                // 🔹 Get existing child rows
                $existingRows = $this->GetList(
                    $childTable,
                    "`$fkColumn`='" . $conn->real_escape_string($currentId) . "'",
                    "",
                    "",
                    $conn
                );

                $childPk = $this->GetPrimaryKey($childTable, $conn);
                $existingIds = array_column($existingRows, $childPk);

                $incomingIds = [];

                foreach ($rows as $row) {

                    if (!is_array($row))
                        continue;

                    // 🔥 clone row (avoid mutation bugs)
                    $rowCopy = json_decode(json_encode($row), true);

                    // 🔥 remove FK from child payload
                    foreach ($rowCopy as $k => $v) {
                        if (strtolower($k) === strtolower($fkColumn)) {
                            unset($rowCopy[$k]);
                        }
                    }

                    // 🔥 fresh parent context (critical fix)
                    $parentContext = [
                        "table" => $table,
                        "id" => $currentId
                    ];

                    // 🔁 recursive save
                    $savedChild = $this->SaveNestedDeep(
                        $childTable,
                        (object) $rowCopy,
                        $parentContext,
                        $conn
                    );

                    if (isset($savedChild[$childPk])) {
                        $incomingIds[] = $savedChild[$childPk];
                    }
                }

                // 🔹 Delete removed children
                $toDelete = array_diff($existingIds, $incomingIds);

                foreach ($toDelete as $delId) {
                    $this->DeleteById($childTable, $delId, $conn);
                }
            }

            if ($parent === null) {
                $this->Commit($conn);
            }

            return $saved;

        } catch (Exception $e) {

            if ($parent === null) {
                $this->Rollback($conn);
            }

            throw $e;

        } finally {
            if ($parent === null) {
                $this->closeConnection($conn, $closeConnection);
            }
        }
    }

    public function DeleteById($table, $id, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $pk = $this->GetPrimaryKey($table, $conn);

            $id = $conn->real_escape_string($id);

            // Case-insensitive deletion using LOWER() function
            $sql = "DELETE FROM `$table` WHERE LOWER(`$pk`) = LOWER('$id')";

            return $conn->query($sql);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function GetById($table, $id, $DBConnection = null)
    {
        if (empty($table) || empty($id)) {
            throw new InvalidArgumentException("Both table and id must be provided");
        }

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $pk = $this->GetPrimaryKey($table, $conn);
            $id = $conn->real_escape_string($id);

            return $this->db->GetSingleRow(
                "SELECT * FROM `$table` WHERE `$pk`=$id",
                $conn
            );

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function GetList($table, $where = "", $order = "", $limit = "", $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $sql = "SELECT * FROM `$table`";

            if ($where)
                $sql .= " WHERE $where";

            if ($order)
                $sql .= " ORDER BY $order";

            if ($limit)
                $sql .= " LIMIT $limit";

            return $this->db->GetResultAsRowsArray($sql, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function GetPaged($table, $page = 1, $pageSize = null, $where = "", $order = "", $DBConnection = null)
    {
        if (!$table)
            return [];

        // Build column map for case-insensitive matching
        list($conn, $closeConnection) = $this->openConnection($DBConnection);
        try {
            $columns = $this->GetColumns($table, $conn);
            $colMap = [];
            foreach ($columns as $col) {
                $colMap[strtolower($col)] = $col;
            }

            // Fix WHERE clause
            if ($where) {
                foreach ($colMap as $lower => $actual) {
                    $where = preg_replace("/\b$lower\b/i", "`$actual`", $where);
                }
            }

            // Fix ORDER BY clause
            if ($order) {
                foreach ($colMap as $lower => $actual) {
                    $order = preg_replace("/\b$lower\b/i", "`$actual`", $order);
                }
            }

            // Compute LIMIT for pagination
            $limit = "";
            if ($pageSize !== null && $pageSize > 0) {
                $offset = max(0, ($page - 1) * $pageSize);
                $limit = "$offset,$pageSize";
            }

            // Call GetList instead of duplicating SQL logic
            return $this->GetList($table, $where, $order, $limit, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }



    public function BuildWhere($conditions, $operator = "AND", $conn)
    {
        $parts = [];

        foreach ($conditions as $col => $val) {
            if ($val === null)
                continue;

            $col = strtolower($col);
            $val = $conn->real_escape_string($val);

            $parts[] = "`$col`='$val'";
        }

        return implode(" $operator ", $parts);
    }

    public function Execute($sql, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $sql = trim($sql);
            $sql = rtrim($sql, ';');

            // 🔒 Block dangerous queries
            $forbidden = ['DELETE', 'DROP', 'TRUNCATE', 'ALTER'];

            foreach ($forbidden as $word) {
                if (stripos($sql, $word) !== false) {
                    throw new Exception("Query not allowed: $word");
                }
            }

            // 🔒 Prevent multiple queries
            if (preg_match('/;.+/', $sql)) {
                throw new Exception("Multiple queries are not allowed");
            }

            // 🔍 Detect query type
            $queryType = strtoupper(strtok($sql, " "));

            // ✅ SELECT → return rows
            if ($queryType === "SELECT") {
                return $this->db->GetResultAsRowsArray($sql, $conn);
            }

            // ✅ UPDATE / INSERT → execute only
            if (in_array($queryType, ["UPDATE", "INSERT"])) {

                $result = $conn->query($sql);

                return [
                    "success" => $result,
                    "affected_rows" => $conn->affected_rows
                ];
            }

            // ❌ Anything else blocked
            throw new Exception("Only SELECT, UPDATE, INSERT allowed");

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function Find($tableName, $obj = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {

            if ($obj === null) {
                $sql = "SELECT * FROM `$tableName`";
                return $this->db->GetResultAsRowsArray($sql, $conn);
            }

            $props = get_object_vars($obj);

            if (count($props) === 0)
                return [];

            $whereParts = [];

            foreach ($props as $col => $val) {
                if ($val === null)
                    continue;

                // make column name case-insensitive
                $col = strtolower($col);

                $escapedVal = $conn->real_escape_string($val);
                $whereParts[] = "`$col`='$escapedVal'";
            }

            if (count($whereParts) === 0) {
                $sql = "SELECT * FROM `$tableName`";
                return $this->db->GetResultAsRowsArray($sql, $conn);
            }

            $where = implode(" AND ", $whereParts);
            $sql = "SELECT * FROM `$tableName` WHERE $where";

            return $this->db->GetResultAsRowsArray($sql, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function FilterByAnd($tableName, $obj = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            if ($obj === null) {
                return $this->db->GetResultAsRowsArray("SELECT * FROM `$tableName`", $conn);
            }

            $props = get_object_vars($obj);

            if (count($props) === 0)
                return [];

            $where = $this->BuildWhere($props, "AND", $conn);

            if (empty($where)) {
                $sql = "SELECT * FROM `$tableName`";
            } else {
                $sql = "SELECT * FROM `$tableName` WHERE $where";
            }

            return $this->db->GetResultAsRowsArray($sql, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function FilterByOr($tableName, $obj = null, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            if ($obj === null) {
                return $this->db->GetResultAsRowsArray("SELECT * FROM `$tableName`", $conn);
            }

            $props = get_object_vars($obj);

            if (count($props) === 0)
                return [];

            $where = $this->BuildWhere($props, "OR", $conn);

            if (empty($where)) {
                $sql = "SELECT * FROM `$tableName`";
            } else {
                $sql = "SELECT * FROM `$tableName` WHERE $where";
            }

            return $this->db->GetResultAsRowsArray($sql, $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function GetDB($DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $result = [];

            // 1. Get all tables
            $tables = $this->db->GetResultAsRowsArray("SHOW TABLES", $conn);
            if (!$tables || count($tables) === 0)
                return [];

            foreach ($tables as $row) {
                $tableName = array_values($row)[0];

                // 2. Reuse GetTable
                $result[$tableName] = $this->GetTable($tableName, $conn);
            }

            return $result;

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function UpdateDB($dbData, $DBConnection = null)
    {
        if (!$dbData || !is_array($dbData)) {
            throw new Exception("Invalid DB data");
        }

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            $this->BeginTransaction($conn);

            foreach ($dbData as $table => $records) {
                $this->UpdateTable($table, $records, $conn);
            }

            $this->Commit($conn);

            return $this->GetDB($conn);

        } catch (Exception $e) {
            $this->Rollback($conn);
            throw $e;
        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function GetTable($tableName, $DBConnection = null)
    {
        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            // Validate table exists
            $tables = array_map(
                function ($t) {
                    return array_values($t)[0];
                },
                $this->db->GetResultAsRowsArray("SHOW TABLES", $conn)
            );

            if (!in_array($tableName, $tables)) {
                return [];
            }

            return $this->db->GetResultAsRowsArray("SELECT * FROM `$tableName`", $conn);

        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    public function UpdateTable($tableName, $records, $DBConnection = null)
    {
        if (!is_array($records))
            return [];

        list($conn, $closeConnection) = $this->openConnection($DBConnection);

        try {
            // Start transaction
            $this->BeginTransaction($conn);

            // Get table columns
            $columns = $this->GetColumns($tableName, $conn);
            $columnsLower = array_map('strtolower', $columns);

            foreach ($records as $row) {
                if (!is_array($row))
                    continue;

                // Filter valid columns
                $clean = [];
                foreach ($row as $key => $val) {
                    if (in_array(strtolower($key), $columnsLower)) {
                        $clean[$key] = $val;
                    }
                }

                if (empty($clean))
                    continue;

                $obj = (object) $clean;

                // Insert/Update using Save()
                $this->Save($tableName, $obj, $conn);
            }

            $this->Commit($conn);

            return $this->GetTable($tableName, $conn);

        } catch (Exception $e) {
            $this->Rollback($conn);
            throw $e;
        } finally {
            $this->closeConnection($conn, $closeConnection);
        }
    }

    // Helper method for case-insensitive mapping
    private function MapObjectToColumns($obj, $columns, $primaryKey = null)
    {
        $props = get_object_vars($obj);

        // Lowercase keys for case-insensitive comparison
        $propsLower = [];
        foreach ($props as $key => $value) {
            $propsLower[strtolower($key)] = $value;
        }

        $pkLower = $primaryKey ? strtolower($primaryKey) : null;

        $mapped = [];
        foreach ($columns as $col) {
            $colLower = strtolower($col);
            if ($colLower === $pkLower) {
                continue; // skip primary key
            }
            if (array_key_exists($colLower, $propsLower)) {
                $mapped[$col] = $propsLower[$colLower]; // keep original column casing
            }
        }

        return $mapped;
    }

    private function FindChildTables($parentTable, $conn)
    {
        $tables = array_map(
            fn($t) => array_values($t)[0],
            $this->db->GetResultAsRowsArray("SHOW TABLES", $conn)
        );

        $result = [];

        $parentLower = strtolower($parentTable);

        // 🔥 singular form (simple trim 's')
        $parentSingular = rtrim($parentLower, 's');

        foreach ($tables as $table) {

            $columns = $this->GetColumns($table, $conn);

            foreach ($columns as $col) {

                $colLower = strtolower($col);

                // 🔥 all possible FK patterns
                $possibleMatches = [
                    $parentLower . "id",     // logsid
                    $parentLower . "_id",    // logs_id
                    $parentSingular . "id",  // logid ✅
                    $parentSingular . "_id"  // log_id ✅
                ];

                if (in_array($colLower, $possibleMatches)) {

                    $result[] = [
                        "table" => $table,
                        "fk" => $col
                    ];
                    break;
                }
            }
        }

        return $result;
    }
    private function ResolveChildTable($childKey, $parentTable, $conn)
    {
        $tables = array_map(
            fn($t) => array_values($t)[0],
            $this->db->GetResultAsRowsArray("SHOW TABLES", $conn)
        );

        $childKeyLower = strtolower($childKey);
        $parentTableLower = strtolower($parentTable);

        foreach ($tables as $tbl) {
            $tblLower = strtolower($tbl);

            // Exact match
            if ($tblLower === $childKeyLower)
                return $tbl;

            // Pattern: parent_child (e.g., tests_logs)
            if ($tblLower === $parentTableLower . "_" . $childKeyLower)
                return $tbl;

            // Pattern: singular child name matches table (e.g., log → logs)
            if (rtrim($tblLower, "s") === rtrim($childKeyLower, "s"))
                return $tbl;
        }

        return null; // not found
    }
    private function DetectFKWhere($childTable, $parentTable, $parentId, $conn)
    {
        $columns = $this->GetColumns($childTable, $conn);
        $parentLower = strtolower($parentTable);
        $parentSingular = rtrim($parentLower, "s");

        $possibleFKs = [
            $parentLower . "id",     // testsid
            $parentLower . "_id",    // tests_id
            $parentSingular . "id",  // testid
            $parentSingular . "_id"  // test_id
        ];

        foreach ($columns as $col) {
            if (in_array(strtolower($col), $possibleFKs)) {
                return "`$col`='" . $conn->real_escape_string($parentId) . "'";
            }
        }

        return null; // no FK found
    }
    private function NormalizeChildKey($childTable, $parentTable)
    {
        $child = strtolower($childTable);
        $parent = strtolower($parentTable);

        // remove parent prefix if exists
        if (strpos($child, $parent . "_") === 0) {
            return substr($child, strlen($parent) + 1);
        }

        return $child;
    }
    private function openConnection($DBConnection)
    {
        $conn = $DBConnection ?? $this->db->GetActiveConnection();
        $closeConnection = ($DBConnection === null);

        return [$conn, $closeConnection];
    }

    private function closeConnection($conn, $closeConnection)
    {
        if ($closeConnection && $conn)
            $conn->close();
    }

    private function GetColumns($table, $conn)
    {
        return $this->db->GetSingleColumnArray("SHOW COLUMNS FROM `$table`", $conn);
    }

    private function GetPrimaryKey($table, $conn)
    {
        $row = $this->db->GetSingleRow("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'", $conn);
        return $row["Column_name"] ?? "id";
    }
}
?>