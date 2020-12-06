<!DOCTYPE html>
<html>
<head>
    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
</head>
<body>
<h5>Hello from ag-grid!</h5>
<?php
    include "need.php";
    $select_sql = "SELECT * FROM datapoints";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
?>
        <div id="myGrid"style="height: 600px; width:100%;" class="ag-theme-alpine"></div>
        <script type="text/javascript" charset="utf-8">
            // specify the columns
            var columnDefs = [
                {headerName: "page", field: "page"},
                {headerName: "data_module", field: "data_module"},
                {headerName: "data_point", field: "data_point"}
                {headerName: "ongoing_definition_owner", field: "ongoing_definition_owner"}
                {headerName: "definition_stakeholder", field: "definition_stakeholder"}
            ];
            // specify the data
            var rowData = [
                <?php echo "sfsdf"; while($row = $result->fetch_assoc()) { ?>
                {page: "<?php echo $row['page']; ?>", data_module: "<?php echo $row['data_module']; ?>", ongoing_definition_owner: "<?php echo $row['ongoing_definition_owner']; ?>" , definition_stakeholder: "<?php echo $row['definition_stakeholder']; ?>"},
                <?php } ?>
            ];

            // let the grid know which columns and what data to use
            var gridOptions = {
                columnDefs: columnDefs,
                rowData: rowData
            };

            // lookup the container we want the Grid to use
            var eGridDiv = document.querySelector('#myGrid');

            // create the grid passing in the div to use together with the columns & data we want to use
            new agGrid.Grid(eGridDiv, gridOptions);

        </script>
<?php
    } else {
        echo "0 results";
    }
$conn->close();
?>
</body>
</html>