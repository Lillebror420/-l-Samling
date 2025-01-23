<?php
require('db.php');

// Get brand count
$brandCountQuery = "SELECT Brand, COUNT(*) AS Count FROM samler_vanvid GROUP BY Brand";
$brandCountResult = $conn->query($brandCountQuery);

$brandCountData = array();
while ($row = $brandCountResult->fetch_assoc()) {
    $brandCountData[] = $row;
}

// Get date range
$dateRangeQuery = "SELECT MIN(Udlob) AS MinDate, MAX(Udlob) AS MaxDate FROM samler_vanvid";
$dateRangeResult = $conn->query($dateRangeQuery);
$dateRangeData = $dateRangeResult->fetch_assoc();

// Calculate the time difference in years, months, and days
$minDate = new DateTime($dateRangeData['MinDate']);
$maxDate = new DateTime($dateRangeData['MaxDate']);
$dateInterval = $minDate->diff($maxDate);

// Format the date interval
$formattedDateRange = $dateInterval->format('%y år, %m måneder og %d dage');

// Create an array to hold the statistics data
$statistics = array(
    'brandCount' => $brandCountData,
    'dateRange' => $formattedDateRange
);

// Return the statistics data as JSON
header('Content-Type: application/json');
echo json_encode($statistics);

$conn->close();
?>
