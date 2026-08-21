<?php
header("Access-Control-Allow-Origin: *");
include_once('../db/DBMySql.php');
$db = new DBMySql;



$action = strtolower($_GET['action'] ?? '');
switch ($action) {

    case 'getuserbyid':
        if (isset($_GET['id'])) {
            GetUserByID($_GET['id']);
        } else {
            echo json_encode(["status"=>false,"message"=>"User ID required"]);
        }
        break;

    case 'getallusers':
        GetAllUsers();
        break;

    case 'adduser':
        addUser();
        break;

    case 'updateuser':
        updateUser();
        break;
    case 'login':
        loginUser();
        break;
    default:
        echo json_encode([
            "status"=>false,
            "message"=>"Invalid API request"
        ]);
        break;

        
}



function GetUserByID($id)
{
    global $db; // use the global DB instance

    if (!$id)
         $Response = [
            "Status" => "Error",
            "Message" => "Invalid User Id"
        ];

    $SQL = "SELECT * FROM users WHERE UID=" . intval($id);

    $row = $db->GetSingleRow($SQL);
    $Response = null;
    if ($row) {
        $Response = [
            "Status" => "Success",
            "Data" => $row
        ];
    } else {
        $Response = [
            "Status" => "Error",
            "Message" => "Invalid User",
            "sql" => $SQL
        ];
    }
    echo json_encode($Response);

}

function GetAllUsers()
{
    global $db; // use the global DB instance

    $SQL = "SELECT * FROM users";

    $result = $db->GetResultAsRowsArray($SQL);
    $Response = null;
    if ($result) {
        $Response = [
            "Status" => "Success",
            "Data" => $result
        ];
    } else {
        $Response = [
            "Status" => "Error",
            "Message" => "Invalid User",
            "sql" => $SQL
        ];
    }
    echo json_encode($Response);
}

function addUser()
{ 
    global $db;

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !is_array($data)) {
        http_response_code(400);
        echo json_encode([
            "Status" => "Error",
            "Message" => "Invalid input"
        ]);
    } else {

        $table = "users";

        $columns = array_keys($data);

        $values = array_map(function ($v) {
            if (is_numeric($v)) {
                return $v;
            } elseif ($v === null || $v === '') {
                return "NULL";
            } else {
                return "'" . addslashes($v) . "'";
            }
        }, array_values($data));

        $sql = "INSERT INTO `$table` (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
        $resp = $db->NonQuery($sql);
        if ($resp=='Success') {

            $result = $db->GetSingleRow("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users);");

            if ($result) {
                echo json_encode([
                    "Status" => "Success",
                    "Data" => $result
                ]);
            } else {
                echo json_encode([
                    "Status" => "Error",
                    "Message" => "Invalid User",
                    "sql" => $sql
                ]);
            }

        } else {
            echo json_encode([
                "Status" => "Error",
                "Message" => $resp,
                "sql" => $sql
            ]);
        }
    }
}

/**
 * ­ЪДа Update an existing user dynamically using UID
 */
function updateUser()
{
    global $db;

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !is_array($data) || !isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["Status" => "Error", "Message" => "Invalid input or missing UID"]);
        return;
    }

    $table = "users";
    $id = intval($data['id']);
    unset($data['id']); // remove UID from update columns

    if (empty($data)) {
        echo json_encode(["Status" => "Error", "Message" => "No fields provided for update"]);
        return;
    }

    // Build SET clause dynamically
    $columns = array_keys($data);
    $setClause = implode(' = ?, ', $columns) . ' = ?';
    $values = array_values($data);
    $values[] = $id; // add UID for WHERE clause

    // Build SQL for debugging (replace ? with actual values)
    $debugSql = "UPDATE `$table` SET $setClause WHERE id = ?";
    foreach ($values as $val) {
        $valStr = is_numeric($val) ? $val : "'" . addslashes($val) . "'";
        $debugSql = preg_replace('/\?/', $valStr, $debugSql, 1);
    }

    $resp = $db->NonQuery($debugSql);
    if ($resp=='Success') {
        $result = $db->GetSingleRow("SELECT * FROM `$table` WHERE id=$id;");
        if ($result) {
            echo json_encode([
                "Status" => "Success",
                "Data" => $result
            ]);
        } else {
            echo json_encode([
                "Status" => "Error",
                "Message" => "Invalid User",
                "sql" => $debugSql
            ]);
        }
    } else {
        echo json_encode([
            "Status" => "Error",
            "Message" => $resp,
            "sql" => $debugSql
        ]);
    }
}

function loginUser()
{
    global $db;

    // Try JSON body first
    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data['Email'] ?? $_REQUEST['Email'] ?? '';
    $pwd   = $data['PWD']   ?? $_REQUEST['PWD']   ?? '';

    if (!$email || !$pwd) {
        echo json_encode([
            "Status" => "Error",
            "Message" => "Email and Password required"
        ]);
        return;
    }

    $email = addslashes($email);
    $pwd   = addslashes($pwd);

    $SQL = "SELECT * FROM users WHERE Email='$email' AND PWD='$pwd' AND Status='Active'";

    $row = $db->GetSingleRow($SQL);

    if ($row) {
        echo json_encode([
            "Status" => "Success",
            "Message" => "Login successful",
            "Data" => $row
        ]);
    } else {
        echo json_encode([
            "Status" => "Error",
            "Message" => "Invalid Email or Password"
        ]);
    }
}
?>
