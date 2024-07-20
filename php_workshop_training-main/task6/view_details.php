<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
</head>
<body>

<form action="view_details.php" method="get">
    Search: <input type="text" name="query">
    <input type="submit" value="Search">
    Sort by: 
    <select name="sort">
        <option value="name" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name') ? 'selected' : ''; ?>>Name</option>
        <option value="usn" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'usn') ? 'selected' : ''; ?>>USN</option>
        <option value="phone" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'phone') ? 'selected' : ''; ?>>Phone</option>
    </select>
    <input type="submit" value="Sort">
</form>
    <!-- Add a sort button to sort by values -->
    <h2>View Details</h2>

    <!-- Display Records -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>USN</th>
            <th>Phone Number</th>
            <th>Delete Record</th>
            <th>Update Record</th>
        </tr>

        <?php
        $conn = new mysqli('localhost', 'root', '', 'wshop');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       $search_query = isset($_GET['query']) ? $_GET['query'] : '';
            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';

            $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR usn LIKE '%$search_query%' OR phone LIKE '%$search_query%' ORDER BY $sort_by";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["usn"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td><form action='delete.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Delete'>
                            </form> </td> <td>
                            <form action='update.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Update'>
                            </form>
                            </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
