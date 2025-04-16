<?php
// filepath: c:\xampp\htdocs\salma\discussion.php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sender and receiver
$sender = $_SESSION['user_name']; // Logged-in user
$receiver = isset($_GET['user_name']) ? $_GET['user_name'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sender, $receiver, $message);
    $stmt->execute();
    $stmt->close();
}

// Fetch messages between the two users
$stmt = $conn->prepare("SELECT * FROM messages WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) ORDER BY timestamp ASC");
$stmt->bind_param("ssss", $sender, $receiver, $receiver, $sender);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($receiver); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .chat-header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .chat-header h2 {
            font-size: 18px;
            margin: 0;
        }
        .messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .message {
            display: flex;
            align-items: flex-end;
            margin: 10px 0;
        }
        .message.sent {
            justify-content: flex-end;
        }
        .message.received {
            justify-content: flex-start;
        }
        .message-content {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .message.sent .message-content {
            background-color: #007bff;
            color: #fff;
            border-bottom-right-radius: 5px;
        }
        .message.received .message-content {
            background-color: #f1f1f1;
            color: #333;
            border-bottom-left-radius: 5px;
        }
        .timestamp {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        form {
            display: flex;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <h2>
                <a href="user_profile.php?user_name=<?php echo urlencode($receiver); ?>" style="text-decoration: none; color: inherit;">
                    <?php echo htmlspecialchars($receiver); ?>
                </a>
            </h2>
        </div>

        <!-- Messages -->
        <div class="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?php echo $msg['sender'] === $sender ? 'sent' : 'received'; ?>">
                    <div class="message-content">
                        <?php echo htmlspecialchars($msg['message']); ?>
                        <div class="timestamp"><?php echo $msg['timestamp']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Message Input -->
        <form method="POST">
            <input type="text" name="message" placeholder="Votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>