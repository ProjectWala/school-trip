<?php

header("Content-Type: application/json");

$response = [
    "status" => false,
    "message" => ""
];

/**
 * Resize image while maintaining aspect ratio
 */
function resizeImage($sourcePath, $destinationPath, $maxWidth, $maxHeight)
{
    list($width, $height, $imageType) = getimagesize($sourcePath);

    // Calculate new dimensions (maintain aspect ratio)
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = (int)($width * $ratio);
    $newHeight = (int)($height * $ratio);

    // Create source image
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $srcImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $srcImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $srcImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false; // Unsupported format
    }

    // Create new blank image
    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG & GIF
    if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
        imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
    }

    // Resize
    imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save image
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $destinationPath, 85); // quality 85
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $destinationPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $destinationPath);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($newImage);

    return true;
}

try {

    if (!isset($_POST['folder']) || !isset($_POST['filename'])) {
        throw new Exception("Folder or filename not provided.");
    }

    if (!isset($_FILES['file'])) {
        throw new Exception("No file uploaded.");
    }

    $folder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['folder']);
    $finalName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $_POST['filename']);

    $uploadDir = "../../" . $folder;

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmp = $_FILES['file']['tmp_name'];
    $fileExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    $destination = $uploadDir . "/" . $finalName;

    // Define max dimensions
    $maxWidth = 800;
    $maxHeight = 800;

    // Check if file is an image
    if (getimagesize($fileTmp)) {
        // Resize and save
        if (!resizeImage($fileTmp, $destination, $maxWidth, $maxHeight)) {
            throw new Exception("Image resize failed.");
        }
    } else {
        // Non-image files (normal upload)
        if (!move_uploaded_file($fileTmp, $destination)) {
            throw new Exception("File upload failed.");
        }
    }

    $response["status"] = true;
    $response["message"] = "File uploaded successfully.";
    $response["path"] = "uploads/$folder/$finalName";

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);