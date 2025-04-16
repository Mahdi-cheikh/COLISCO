const express = require('express');
const mysql = require('mysql2');
const app = express();

// Database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'colisco'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Connected to MySQL');
});

// API to search for matching routes
app.get('/search-routes', (req, res) => {
    const { departureCity, arrivalCity } = req.query;

    // Query to find matching routes
    const query = `
        SELECT * FROM PredefinedRoutes
        WHERE 
            (departure_city = exp2.adress AND arrival_city = exp3.adress) OR
            (departure_city = exp2.adress OR arrival_city = exp3.adress)
    `;

    db.query(query, [departureCity, arrivalCity, departureCity, arrivalCity], (err, results) => {
        if (err) throw err;

        if (results.length > 0) {
            res.json({ success: true, routes: results });
        } else {
            res.json({ success: false, message: 'No matching routes found' });
        }
    });
});

// Start the server
app.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});