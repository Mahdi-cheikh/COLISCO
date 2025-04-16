<?php
// filepath: c:\xampp\htdocs\salma\messages.php
session_start();
$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's username
$loggedInUser = $_SESSION['user_name']; // Assuming the username is stored in the session

// Fetch distinct conversations (unique sender/receiver pairs) with last message and timestamp
$sql = "SELECT 
            CASE 
                WHEN sender = ? THEN receiver 
                ELSE sender 
            END AS conversation_partner,
            MAX(timestamp) AS last_message_time,
            (SELECT message 
             FROM messages 
             WHERE (sender = conversation_partner AND receiver = ?) 
                OR (sender = ? AND receiver = conversation_partner)
             ORDER BY timestamp DESC LIMIT 1) AS last_message
        FROM messages
        WHERE sender = ? OR receiver = ?
        GROUP BY conversation_partner
        ORDER BY last_message_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $loggedInUser, $loggedInUser, $loggedInUser, $loggedInUser, $loggedInUser);
$stmt->execute();
$result = $stmt->get_result();
$conversations = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .conversation {
            display: flex;
            flex-direction: column;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
            border-radius:30px;
            background-color:rgb(225, 221, 221);
    
        }
        .conversation:last-child {
            border-bottom: none;
        }
        .conversation:hover {
            background-color: #f9f9f9;
        }
        .conversation a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }
        .conversation a:hover {
            color: #0056b3;
        }
        .last-message {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            line-height: 1.4;
        }
        .timestamp {
            font-size: 12px;
            color: #999;
            text-align: right;
        }
        p {
            text-align: center;
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Messages</h1>
        <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conversation): ?>
                <div class="conversation">
                    <a href="discussion.php?user_name=<?php echo urlencode($conversation['conversation_partner']); ?>">
                        Discuter avec <?php echo htmlspecialchars($conversation['conversation_partner']); ?>
                    </a>
                    <div class="last-message">
                        <?php echo htmlspecialchars($conversation['last_message']); ?>
                    </div>
                    <div class="timestamp">
                        <?php echo htmlspecialchars($conversation['last_message_time']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune conversation trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>