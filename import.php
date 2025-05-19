<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'test'; // Update this

$conn = new mysqli($host, $user, $pass, $dbname);

if (isset($_POST['submit'])) {
    $filename = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($filename, "r");
        $headerSkipped = false;

        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip header row
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            // Check if row has 21 columns (0 to 20)
            if (count($getData) < 21 || empty($getData[0])) {
                continue;
            }

            $emp_id        = intval($getData[0]);
            $emp_name      = $conn->real_escape_string($getData[1]);
            $month         = intval($getData[2]);
            $year          = intval($getData[3]);
            $department    = $conn->real_escape_string($getData[4]);
            $basic_salary  = floatval($getData[5]);
            $hra           = floatval($getData[6]);
            $bonus         = floatval($getData[7]);
            $leave_encash  = floatval($getData[8]);
            $ot_amount     = floatval($getData[9]);
            $gross_total   = floatval($getData[10]);
            $pf            = floatval($getData[11]);
            $esic          = floatval($getData[12]);
            $canteen       = floatval($getData[13]);
            $prof_tax      = floatval($getData[14]);
            $trans_ded     = floatval($getData[15]);
            $total_ded     = floatval($getData[16]);
            $net_amount    = floatval($getData[17]);
            $adv           = floatval($getData[18]);
            $final_amount  = floatval($getData[19]);
            $payable_days  = intval($getData[20]);

            $sql = "INSERT INTO employee_salary (
                        emp_id, emp_name, month, year, department, basic_salary, hra, bonus,
                        leave_encash, ot_amount, gross_total, pf, esic, canteen,
                        prof_tax, trans_ded, total_deduction, net_amount, adv,
                        final_amount, payable_days
                    ) VALUES (
                        '$emp_id', '$emp_name', '$month', '$year', '$department', '$basic_salary', '$hra', '$bonus',
                        '$leave_encash', '$ot_amount', '$gross_total', '$pf', '$esic', '$canteen',
                        '$prof_tax', '$trans_ded', '$total_ded', '$net_amount', '$adv',
                        '$final_amount', '$payable_days'
                    )";

            if (!$conn->query($sql)) {
                echo "MySQL Error: " . $conn->error . "<br>";
            }
        }
        fclose($file);
        echo "<p style='color:green;'>CSV import completed successfully.</p>";
    } else {
        echo "<p style='color:red;'>Uploaded file is empty.</p>";
    }
}
?>
