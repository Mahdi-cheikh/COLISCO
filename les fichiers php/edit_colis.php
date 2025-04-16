<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'colisco');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the colis details
    $stmt = $conn->prepare("SELECT * FROM colis WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $colis = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $user_name = $_POST['user_name'];
    $photos = $_POST['photos'];
    $quantity = $_POST['quantity'];
    $object = $_POST['object'];
    $exact_dimensions = $_POST['exact_dimensions'];
    $format = $_POST['format'];
    $weight = $_POST['weight'];
    $additional_info = $_POST['additional_info'];
    $ville_dep = $_POST['ville_dep'];
    $pickup_type_dep = $_POST['pickup_type_dep'];
    $has_coordinates_dep = isset($_POST['has_coordinates_dep']) ? 1 : 0;
    $ville_arr = $_POST['ville_arr'];
    $pickup_type_arr = $_POST['pickup_type_arr'];
    $has_coordinates_arr = isset($_POST['has_coordinates_arr']) ? 1 : 0;
    $price = $_POST['price'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'colisco');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the colis details
    $stmt = $conn->prepare("UPDATE colis SET user_name = ?, photos = ?, quantity = ?, object = ?, exact_dimensions = ?, format = ?, weight = ?, additional_info = ?, ville_dep = ?, pickup_type_dep = ?, has_coordinates_dep = ?, ville_arr = ?, pickup_type_arr = ?, has_coordinates_arr = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssisssdi", $user_name, $photos, $quantity, $object, $exact_dimensions, $format, $weight, $additional_info, $ville_dep, $pickup_type_dep, $has_coordinates_dep, $ville_arr, $pickup_type_arr, $has_coordinates_arr, $price, $id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating colis: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Colis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            width: auto;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Colis</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="user_name">User Name:</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($colis['user_name']); ?>" required>

        <label for="photos">Photos:</label>
        <input type="text" name="photos" id="photos" value="<?php echo htmlspecialchars($colis['photos']); ?>">

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($colis['quantity']); ?>" required>

        <label for="object">Object:</label>
        <input type="text" name="object" id="object" value="<?php echo htmlspecialchars($colis['object']); ?>" required>

        <label for="exact_dimensions">Exact Dimensions:</label>
        <input type="text" name="exact_dimensions" id="exact_dimensions" value="<?php echo htmlspecialchars($colis['exact_dimensions']); ?>">

        <label for="format">Format:</label>
        <input type="text" name="format" id="format" value="<?php echo htmlspecialchars($colis['format']); ?>">

        <label for="weight">Weight:</label>
        <input type="text" name="weight" id="weight" value="<?php echo htmlspecialchars($colis['weight']); ?>">

        <label for="additional_info">Additional Info:</label>
        <input type="text" name="additional_info" id="additional_info" value="<?php echo htmlspecialchars($colis['additional_info']); ?>">

        <label for="ville_dep">Ville Dep:</label>
        <input type="text" name="ville_dep" id="ville_dep" value="<?php echo htmlspecialchars($colis['ville_dep']); ?>">

        <label for="pickup_type_dep">Pickup Type Dep:</label>
        <input type="text" name="pickup_type_dep" id="pickup_type_dep" value="<?php echo htmlspecialchars($colis['pickup_type_dep']); ?>">

        <label for="has_coordinates_dep">Has Coordinates Dep:</label>
        <input type="checkbox" name="has_coordinates_dep" id="has_coordinates_dep" <?php echo $colis['has_coordinates_dep'] ? 'checked' : ''; ?>>

        <label for="ville_arr">Ville Arr:</label>
        <input type="text" name="ville_arr" id="ville_arr" value="<?php echo htmlspecialchars($colis['ville_arr']); ?>">

        <label for="pickup_type_arr">Pickup Type Arr:</label>
        <input type="text" name="pickup_type_arr" id="pickup_type_arr" value="<?php echo htmlspecialchars($colis['pickup_type_arr']); ?>">

        <label for="has_coordinates_arr">Has Coordinates Arr:</label>
        <input type="checkbox" name="has_coordinates_arr" id="has_coordinates_arr" <?php echo $colis['has_coordinates_arr'] ? 'checked' : ''; ?>>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($colis['price']); ?>" required>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>