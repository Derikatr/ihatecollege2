<?php
function load_hash_data($file) {
    $data = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    
    foreach ($lines as $line) {
        list($string, $hash) = explode(":", $line);
        $data[$hash] = $string;
    }
    
    return $data;
}

// Load given list
$sha1_data = load_hash_data('sha1_list.txt');
$sha224_data = load_hash_data('sha224_list.txt');
$sha256_data = load_hash_data('sha256_list.txt');

// Merge all data into a single associative array
$hash_data = array_merge($sha1_data, $sha224_data, $sha256_data);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shaHash'])) {
    $searched_hash = trim($_POST['shaHash']);
    $found_string = "Hash not found in records.";
    
    // Search for the hash in the data
    if (array_key_exists($searched_hash, $hash_data)) {
        $found_string = $hash_data[$searched_hash];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hash</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .result {
            margin-top: 20px;
            font-size: 16px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 5px;
            font-size: 16px;
            width: 300px;
        }
        input[type="submit"] {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>sha search</h1>

    <div class="result">
        <p><strong>Searched Hash:</strong> <?php echo htmlspecialchars($searched_hash); ?></p>
        <p><strong>Result:</strong> <?php echo htmlspecialchars($found_string); ?></p>
    </div>

    <hr>

    <form action="sha.php" method="post">
        <label for="shaHash">Enter another SHA hash value:</label><br><br>
        <input type="text" id="shaHash" name="shaHash" required><br><br>
        <input type="submit" value="Lookup">
    </form>
</body>
</html>
