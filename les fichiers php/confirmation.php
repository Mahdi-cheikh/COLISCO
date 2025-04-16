<!-- filepath: c:\xampp\htdocs\salma\confirmation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .photos {
            width: 300px;
            height: 300px;
            background: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: #555;
        }
        .details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .details div {
            background: #eaeaea;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="photos">photos</div>
        <div class="details">
            <div>object</div>
            <div>adress</div>
            <div>adress</div>
            <div>price</div>
        </div>
    </div>
</body>
</html>