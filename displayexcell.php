<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>


<?php
global $wpdb;


// Table name
$tablename = $wpdb->prefix . "excellplugin";

?>
<?php
if (isset($_POST["import"])) {

   
     $filename = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {

        $file = fopen($filename, "r");

        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

            //It wiil insert a row to our subject table from our csv file`
            $sql = "INSERT INTO wp_excellplugin (`hospital_code`, `hospital_name`, `hospital_address`) 
	            	values('$emapData[0]','$emapData[1]','$emapData[2]')";
            //we are using mysql_query function. it returns a resource on true else False on error
            $wpdb->query($sql);
        }
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file

        //close of connection
    }
}

?>


<h2>All entries</h2>

<div class="container">
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" class="form" method="POST" enctype='multipart/form-data'>
        <div class="row g-3 row-cols-1">
            <div class="col-md-4">
                <label class="form-label"> Upload File</label>
                <input type="file" class="form-control" name="file">
            </div>
            <div class="col">
                <input type="submit" value="import" class="btn btn-primary " name="import">
            </div>
        </div>
    </form>


</div>

<div class="container">

    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Hospital Code</th>
                <th scope="col">Hospital Name</th>
                <th scope="col">Hospital Address</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $skip_row_number = array("1");
            $row = 0;
            // Fetch records
            $entriesList = $wpdb->get_results("SELECT * FROM " . $tablename . " order by id asc");
            if (count($entriesList) > 0) {
                $count = 0;
                foreach ($entriesList as $entry) {
                    $row++;
                    if (in_array($row, $skip_row_number)) {
                        continue;
                        // skip row of csv
                    } else {
                        $id = $entry->id;
                        $h_code = $entry->hospital_code;
                        $h_name = $entry->hospital_name;
                        $h_address = $entry->hospital_address;

                        echo "<tr>
                            <th class= 'row'>" . $id . "</th>
                            <td>" . $h_code . "</td>
                            <td>" . $h_name . "</td>
                            <td>" . $h_address . "</td>
                        </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='5'>No record found</td></tr>";
            }
            ?>

        </tbody>
    </table>
</div>