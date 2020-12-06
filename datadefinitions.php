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
$select_sql = "SELECT * FROM datadefinitions";
$result = $conn->query($select_sql);
if ($result->num_rows > 0) {
    ?>
    <div id="myGrid"style="height: 600px; width:100%;" class="ag-theme-alpine"></div>
    <script type="text/javascript" charset="utf-8">
        // specify the columns
        var columnDefs = [
            {headerName: "page", field: "page"},
            {headerName: "module", field: "module"},
            {headerName: "data_point", field: "data_point"},
            {headerName: "lookup_value", field: "lookup_value"}
        ];
        // specify the data
        var rowData = [
            <?php while($row = $result->fetch_assoc()) { ?>
            {page: "<?php echo $row['page']; ?>", module: "<?php echo $row['data_module']; ?>" , data_point: "<?php echo $row['data_point']; ?>", lookup_value: "<?php echo $row['lookup_value']; ?>"},
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