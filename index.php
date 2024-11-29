<?php
// index.php

require_once 'utils.php'; 

use General\Utils;

// Function to sanitize and validate inputs
function validateRange($min, $max) {
    if (!is_numeric($min) || !is_numeric($max)) {
        return 'Both "min" and "max" must be integers.';
    }
    $min = (int) $min;
    $max = (int) $max;

    // Ensure valid range
    if ($min >= $max) {
        return 'Invalid range: "min" must be less than "max".';
    }
    if ($min < 1 || $max > 10000) {  // Arbitrary range boundary
        return 'Range out of bounds: min should be at least 1, max should be no more than 10000.';
    }

    return ['min' => $min, 'max' => $max];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Default values for min and max
    $min = isset($_GET['min']) ? $_GET['min'] : 10;
    $max = isset($_GET['max']) ? $_GET['max'] : 1000;

    // Validate range
    $validationResult = validateRange($min, $max);
    if (is_string($validationResult)) {
        http_response_code(400);
        echo json_encode(['error' => $validationResult]);
        exit;
    }

    $min = $validationResult['min'];
    $max = $validationResult['max'];

    // Generate random number using the method
    $randomNumber = Utils::getSecureRandom($min, $max);

    // Return the random number as JSON
    echo json_encode(['randomNumber' => $randomNumber]);
} else {
    // Handle unsupported HTTP methods
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed.']);
}
?>
