const express = require('express');
const mongoose = require('mongoose');
const Parcel = require('./models/parcel'); // Adjust the path as needed

const app = express();
app.use(express.json());

// MongoDB connection
mongoose.connect('mongodb://localhost:27017/COLISCO', {
  useNewUrlParser: true,
  useUnifiedTopology: true,
});

// Route to handle form submission
app.post('/submit-parcel', async (req, res) => {
  try {
    const parcelData = req.body;
    const parcel = new Parcel(parcelData);
    await parcel.save();
    res.status(201).send({ message: 'Parcel data saved successfully!', parcel });
  } catch (error) {
    res.status(400).send({ error: error.message });
  }
});

// Start the server
app.listen(3000, () => {
  console.log('Server is running on http://localhost:27017');
});

const parcelSchema = new mongoose.Schema({
  photos: {
    type: [String], // Array of photo URLs or file paths
    validate: [arrayLimit, 'You can upload up to 7 photos only.'],
  },
  quantity: {
    type: Number,
    required: true,
    min: 1,
  },
  object: {
    type: String,
    required: true,
    trim: true,
  },
  exactDimensions: {
    type: Boolean,
    default: false,
  },
  format: {
    type: String,
    enum: ['petit', 'moyen', 'grand'],
    required: true,
  },
  weight: {
    type: String,
    enum: ['0-5', '5-10', '10-20'],
    required: true,
  },
  additionalInfo: {
    type: String,
    trim: true,
  },
  createdAt: {
    type: Date,
    default: Date.now,
  },
});

// Custom validator for photo array limit
function arrayLimit(val) {
  return val.length <= 7;
}

module.exports = mongoose.model('Parcel', parcelSchema);