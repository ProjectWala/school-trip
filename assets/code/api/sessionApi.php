<?php
header('Content-Type: application/json');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get action from query parameter or POST
$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : null;

$data = json_decode(file_get_contents("php://input"), true);
$data = array_combine(array_map('trim', array_keys($data)), $data);

$key = $data['key'];

$response = [];
$value = null;
if (isset($data['value'])) {
    $value = $data['value'];

}


switch ($action) {
    case 'set':
        setSession($key, $value);
        break;

    case 'get':
        getSession($key);
        break;

    case 'remove':
        removeSession($key);
        break;

    case 'showallsessions':
        showAllSessions();
        break;

    default:
        $response = ['success' => false, 'message' => 'Invalid action. Use action=set|get|remove'];
}

function showAllSessions()
{
    echo json_encode($_SESSION);
}

function setSession($key, $value)
{
    if ($key === null || $value === null || $key === '' || $value === '') {
        return ['status' => false, 'message' => 'Missing key or value for set action'];
    }

    $_SESSION[$key] = $value;

    echo json_encode([
        'status' => true,
        'message' => "Session variable '$key' set",
        'value' => $value
    ]);
}

function getSession($key)
{
    if ($key === null || $key === '') {
        return ['status' => false, 'message' => 'Missing key for get action'];
    }
    $val = $_SESSION[$key] ?? null;

    echo json_encode(['status' => true, 'value' => $val]);
}

function removeSession($key)
{
    if ($key === null || $key === '') {
        return ['success' => false, 'message' => 'Missing key for remove action'];
    }

    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
        echo json_encode([
            'status' => true,
            'message' => "Session variable '$key' removed"
        ]);
    }

    echo json_encode([
        'status' => false,
        'message' => "Session variable '$key' does not exist"
    ]);
}

function set($key, $value)
{
    $_SESSION[$key] = $value;
}

function get($key)
{
    $val = $_SESSION[$key] ?? null;
    echo json_encode($val);
}

function remove($key)
{
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}
?>