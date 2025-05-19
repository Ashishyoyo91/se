
<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "test");

// Get salary and employee info
$salaryData = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = (int)$_POST['employee'];
    $month = (int)$_POST['month'];
    $year = (int)$_POST['year'];

    // ⚠️ Direct query (sanitize inputs properly in real apps)
    $salarySql = "SELECT * FROM employee_salary WHERE emp_id = $empId AND month = $month AND year = $year";
    $salaryResult = $conn->query($salarySql);

    if ($salaryResult->num_rows > 0) {
        $salaryData = $salaryResult->fetch_assoc();
    }

    // Fetch employee name if not in salary table
    $empResult = $conn->query("SELECT emp_name FROM employee_salary WHERE emp_id = $empId");
    if ($empResult->num_rows > 0) {
        $employeeInfo = $empResult->fetch_assoc();
        $salaryData['emp_name'] = $employeeInfo['emp_name'];
    }
}
// print_r($salaryData);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shree Enterprise</title>
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap'); */
        
        :root {
            --primary: #5d5fef;
            --secondary: #6c757d;
            --accent: #ff6b6b;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --border-radius: 8px;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
            margin: 0;
            padding: 40px 20px;
        }
        
        .payslip-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .payslip-header {
            background: linear-gradient(135deg, var(--primary), #7476ed);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .payslip-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), #ff8e8e);
        }
        
        .company-name {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .company-address {
            font-weight: 300;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .payslip-title {
            font-size: 24px;
            margin: 20px 0 10px;
            letter-spacing: 1px;
        }
        
        .payslip-period {
            font-weight: 300;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .employee-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background-color: var(--light);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-weight: 600;
            font-size: 15px;
        }
        
        .salary-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px;
        }
        
        @media (max-width: 768px) {
            .salary-details {
                grid-template-columns: 1fr;
            }
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .salary-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .salary-table th {
            text-align: left;
            padding: 12px 10px;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .salary-table td {
            padding: 12px 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .highlight-row {
            background-color: rgba(93, 95, 239, 0.03);
        }
        
        .total-row {
            font-weight: 700;
            background-color: rgba(93, 95, 239, 0.05);
        }
        
        .net-pay-section {
            background-color: var(--light);
            padding: 30px;
            text-align: right;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .net-pay-label {
            font-size: 14px;
            color: var(--secondary);
            margin-bottom: 5px;
        }
        
        .net-pay-amount {
            font-size: 28px;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 5px;
        }
        
        .net-pay-words {
            font-style: italic;
            color: var(--secondary);
            font-size: 14px;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            border-top: 1px dashed rgba(0, 0, 0, 0.1);
        }
        
        .signature {
            width: 200px;
            text-align: center;
        }
        
        .signature-line {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            margin-bottom: 10px;
        }
        
        .signature-label {
            font-size: 12px;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .payslip-footer {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            opacity: 0.8;
        }
        
        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .payslip-container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="payslip-container">
        <div class="payslip-header">
            <div class="company-name">SHREE ENTERPRISE</div>
            <div class="company-address">123 Business Avenue, Financial District, 100001</div>
            <div class="payslip-title">EMPLOYEE PAYSLIP</div>
            <div class="payslip-period"><?= $month.'-'. $year ?></div>
        </div>
        
        <div class="employee-info">
            <div class="info-item">
                <div class="info-label">Employee ID</div>
                <div class="info-value"><?= $salaryData['emp_id'] ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Employee Name</div>
                <div class="info-value"><?= $salaryData['emp_name'] ?></div>
            </div><br/>
            <div class="info-item">
                <div class="info-label">Department</div>
                <div class="info-value"><?= $salaryData['department'] ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Payable Days</div>
                <div class="info-value"><?= $salaryData['payable_days'] ?></div>
            </div>
        </div>
        
        <div class="salary-details">
            <div class="earnings-section">
                <h3 class="section-title">Earnings</h3>
                <table class="salary-table">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="highlight-row">
                            <td>Basic Salary</td>
                            <td><?= $salaryData['basic_salary'] ?></td>
                        </tr>
                        <tr>
                            <td>House Rent Allowance</td>
                            <td><?= $salaryData['hra'] ?></td>
                        </tr>
                        <tr class="highlight-row">
                            <td>Performance Bonus</td>
                            <td><?= $salaryData['bonus'] ?></td>
                        </tr>
                        <tr class="highlight-row">
                            <td>Overtime Pay</td>
                            <td><?= $salaryData['ot_amount'] ?></td>
                        </tr>
                        <tr class="total-row">
                            <td>Total Earnings</td>
                            <td><?= $salaryData['gross_total'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="deductions-section">
                <h3 class="section-title">Deductions</h3>
                <table class="salary-table">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Provident Fund</td>
                            <td><?= $salaryData['pf'] ?></td>
                        </tr>
                        <tr>
                            <td>ESIC</td>
                            <td><?= $salaryData['esic'] ?></td>
                        </tr>
                        <tr>
                            <td>Prof. Tax</td>
                            <td><?= $salaryData['prof_tax'] ?></td>
                        </tr>
                        <tr class="highlight-row">
                            <td>Transport Ded.</td>
                            <td><?= $salaryData['trans_ded'] ?></td>
                        </tr>
                        <tr>
                            <td>Meal Coupons</td>
                            <td><?= $salaryData['canteen'] ?></td>
                        </tr>
                        <tr class="highlight-row">
                            <td>Loan Advance</td>
                            <td><?= $salaryData['adv'] ?></td>
                        </tr>
                        <tr class="total-row">
                            <td>Total Deductions</td>
                            <td><?= $salaryData['total_deduction'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="net-pay-section">
            <div class="net-pay-label">Net Payable Amount</div>
            <div class="net-pay-amount">₹<?= $salaryData['final_amount'] ?></div>
            <div class="net-pay-words">(<?= numToWords($salaryData['final_amount']) ?>)</div>
        </div>
        
        <div class="signature-section">
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-label">Employee Signature</div>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-label">Authorized Signatory</div>
            </div>
        </div>
        
        <div class="payslip-footer">
            This is a computer generated payslip and does not require a physical signature
        </div>
    </div>
</body>
</html>
<?php
function numToWords($num) {
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($f->format($num)) . " only";
}
?>