
<!DOCTYPE html>
<html>
<head>
    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
</head>
<body>
<?php

include 'need.php';

// sql to create table DataPoints
$sql = "CREATE TABLE IF NOT EXISTS DataPoints (
page VARCHAR(30) NOT NULL,
data_module VARCHAR(30) NOT NULL,
data_point VARCHAR(50) NOT NULL,
ongoing_definition_owner VARCHAR(50),
definition_stakeholder VARCHAR(50),
primary key (page, data_module, data_point)
)";

// sql to create table DataDefinitions
$sql2 = "CREATE TABLE IF NOT EXISTS DataDefinitions  (
page VARCHAR(30) NOT NULL,
data_module VARCHAR(30) NOT NULL,
data_point VARCHAR(50) NOT NULL,
lookup_value VARCHAR(50) NOT NULL,
lookup_value_definition VARCHAR(150),
ongoing_definition_owner VARCHAR(50),
data_point_definition VARCHAR(50),
primary key (page, data_module, data_point, lookup_value)
)";

//execute query if success
if ($conn->query($sql2) === TRUE) {
    echo "Table DataDefinitions created successfully";
    echo "<br>";
    } else {
    echo "Error creating DataDefinitions: " . $conn->error;
    echo "<br>";
}

//execute query if success
if ($conn->query($sql) === TRUE) {
    echo "Table DataPoints created successfully";
    echo "<br>";
    } else {
    echo "<h2>Error creating DataPoints:</h2>" . $conn->error ;
    echo "<br>";
}

// require php file to access excel_reader plugins.
require_once('plugin/php-excel-reader/excel_reader2.php');
require_once('plugin/SpreadsheetReader.php');

$Reader = new SpreadsheetReader("assets/ART Data.xlsx");
$sheetCount = count($Reader->sheets());
// looping for sheet count
for($i=0;$i<$sheetCount;$i++) {

    $Reader->ChangeSheet($i);
    // looping every single row of excel data
    foreach ($Reader as $Row) {

        $page = "";
        if(isset($Row[11])) { $page = mysqli_real_escape_string($conn,$Row[11]); }

        $data_module = "";
        if(isset($Row[10])) { $data_module = mysqli_real_escape_string($conn,$Row[10]); }

        $datapoint = "";
        if(isset($Row[0])) { $datapoint = mysqli_real_escape_string($conn,$Row[0]); }

        $lookup_value = "";
        if(isset($Row[2])) { $lookup_value = mysqli_real_escape_string($conn,$Row[2]); }

        $ongoing_definition_owner = "";
        if(isset($Row[14])) { $ongoing_definition_owner = mysqli_real_escape_string($conn,$Row[14]); }

        $definition_stakeholder = "";
        if(isset($Row[13])) { $definition_stakeholder = mysqli_real_escape_string($conn,$Row[13]); }

        $lookup_value_definition = "";
        if(isset($Row[13])) { $lookup_value_definition = mysqli_real_escape_string($conn,$Row[13]); }

        $data_point_definition = "";
        if(isset($Row[1])) { $data_point_definition = mysqli_real_escape_string($conn,$Row[1]); }

        if (!empty($page) && !empty($data_module) && !empty($datapoint) && !empty($lookup_value)) {
            $query = null;
            $query2 = null;
            $result = null;
            $result2 = null;
            
            // retriving data so that primary keys are not dublicate. 
            $dub = $conn->query("Select * from datapoints where page='$page' and data_module='$data_module' and data_point='$datapoint'");
            if(mysqli_num_rows($dub)==0){
                $query = "insert into datapoints(page,data_module,data_point, definition_stakeholder, ongoing_definition_owner) values('".$page."','".$data_module."','".$datapoint."','".$definition_stakeholder."','".$ongoing_definition_owner."')";
                $result = $conn->query($query);
            }

            $dub2 = $conn->query("Select * from datadefinitions where page='$page' and data_module='$data_module' and data_point='$datapoint' and lookup_value='$lookup_value'");
            if(mysqli_num_rows($dub2)==0){
                $query2 = "insert into DataDefinitions(page,data_module,data_point,lookup_value,lookup_value_definition, ongoing_definition_owner, data_point_definition) values('".$page."','".$data_module."','".$datapoint."','".$lookup_value."','".$lookup_value_definition."',' ".$ongoing_definition_owner."','".$data_point_definition." ')";
                $result2 = mysqli_query($conn, $query2);
            }

            if ($result) {
                $type = "success 1";
                $message = "Excel Data Imported into the Database";
                echo "<br>";
            } else {
                $type = "error";
                $message = "Problem in Importing Excel Data";
                echo "<br>";
            }
            if ($result2) {
                $type = "success 2";
                $message = "Excel Data Imported into the Database";
                echo "<br>";
            } else {
                $type = "error";
                $message = "Problem in Importing Excel Data";
                echo "<br>";
            }
        }
    } // end foreach
} // end for
echo "<script>alert('done')</script>";
?>
</body>
</html>