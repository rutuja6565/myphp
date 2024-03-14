<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tr {
            background-color: #f2f2f2;
        }

         .highlight {
            background-color: yellow;
            font-weight: bold;
        }
        
    </style>
</head>
<body>

<div class="container">
<h1 class="text-center">Table</h1>
<!-- Search Form -->
<form action="" method="post">
    <label for="search">Search:</label>
    <input type="text" name="search" id="search" placeholder="Enter keyword">
    <button type="submit">Submit</button>
</form>

<?php
// Connectivity
$hostname = 'localhost';
$database = 'vector';
$username = 'root';
$password = '';


$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/////////Search Box////////////////////
$searchTerm = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search term
        $searchTerm = $_POST["search"];
    
        // Query to fetch data based on the search term
        $query = "SELECT * FROM test WHERE `Name` LIKE '%$searchTerm%' OR `Job Titles` LIKE '%$searchTerm%'  OR `Comapny Name` LIKE '%$searchTerm%' OR  `Comapny Size` LIKE '%$searchTerm%'  OR `Country` Name LIKE '%$searchTerm%'";
    } 

//////////// Query to fetch data/////////////////////
 $query = "SELECT * FROM `test` ";
$result = $conn->query($query);
$num=mysqli_num_rows($result);
$numberPages=50;
$totalPages=ceil($num/$numberPages);
//echo $totalPages;
//buttons
for($btn=1; $btn<=$totalPages;$btn++){
    echo '<button class="btn mx-1 my-3"><a href="home.php?page='.$btn.'">'.$btn.'</a></button>';
}
if(isset($_GET['page']))
{
    $page= $_GET['page'];
    echo $page;
}
else{
    $page=1;
}

$startinglimit=($page-1)*$numberPages;
$query = "SELECT * FROM `test` LIMIT " .$startinglimit. ','.$numberPages;
$result=mysqli_query($conn,$query);
//echo  $num;
// Check if the query was successful
if ($result) {
    
    echo "<table>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Job Titles</th>";
    echo "<th>Company Name</th>";
    echo "<th>Company Size</th>";
    echo "<th>Country</th>";
   
    echo "</tr>";

    // Fetch and display data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . highlightSearchTerm($row['Name'], $searchTerm) . "</td>";
        echo "<td>" . highlightSearchTerm($row['Job Titles'], $searchTerm) . "</td>";
        echo "<td>" . highlightSearchTerm($row['Company Name'], $searchTerm) . "</td>";
        echo "<td>" . highlightSearchTerm($row['Company Size'], $searchTerm) . "</td>";
        echo "<td>" . highlightSearchTerm($row['Country'], $searchTerm) . "</td>";
        
        echo "</tr>";
    }

   
    echo "</table>";
   

   // $query = "SELECT * FROM test WHERE `Name` LIKE '%$searchTerm%' OR `Job Titles` LIKE '%$searchTerm%'  OR `Comapny Name` LIKE '%$searchTerm%' OR  `Comapny Size` LIKE '%$searchTerm%'  OR `Country` Name LIKE '%$searchTerm%'";
    echo "Query: $query";  
    $result->free();
} else {
    echo "Error: " . $conn->error;
}
//searchbox code
function highlightSearchTerm($text, $searchTerm) {
    return str_ireplace($searchTerm, '<span class="highlight">' . $searchTerm . '</span>', $text);
}

 //close connection 
$conn->close();
?>
</div>
</body>
</html>
