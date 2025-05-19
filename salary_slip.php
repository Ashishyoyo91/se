<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "test");

// Get salary and employee info
$salaryData = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = $_POST['employee'];
    $month = (int)$_POST['month'];
    $year = (int)$_POST['year'];
    if($empId == "all"){ 
        $concate = '';
    }else{
        $concate = "emp_id = $empId AND "; 
    }
    
    $salarySql = "SELECT * FROM employee_salary WHERE ".$concate." month = $month AND year = $year";
    // print_r($salarySql);die;
    $salaryResult = $conn->query($salarySql);

    if ($salaryResult->num_rows > 0) {
        $salaryData = $salaryResult->fetch_all();
    }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shree Enterprise - Payslip</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap');
        
        :root {
            --primary: #2c3e50;
            --primary-light: #3d566e;
            --secondary: #7f8c8d;
            --accent: #e74c3c;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #27ae60;
            --border-radius: 6px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            margin: 0;
            padding: 30px;
        }
        
          .spinner {
            display: none;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
        .payslip-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            position: relative;
            border: 1px solid #e0e0e0;
        }
        
        .company-header {
            
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }
        
       
        
        .company-info {

            text-align: center;
        }
        
        .company-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        
        .company-address {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .payslip-title-section {
            text-align: center;
            padding: 20px;
            background-color: var(--light);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .payslip-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .payslip-period {
            font-size: 10px;
            color: var(--secondary);
        }
        
        .employee-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 15px;
            text-align: center;
            padding: 20px 30px;
            background-color: var(--light);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-weight: 600;
            font-size: 14px;
            color: var(--primary);
        }
        
        .salary-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 23px;
            padding: 23px;
        }
        
        @media (max-width: 768px) {
            .salary-details {
                grid-template-columns: 1fr;
            }
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid rgba(44, 62, 80, 0.1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        
        .salary-table th {
            text-align: left;
            padding: 12px 10px;
            font-weight: 500;
            font-size: 12px;
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
            background-color: rgba(44, 62, 80, 0.02);
        }
        
        .total-row {
            font-weight: 700;
            background-color: rgba(44, 62, 80, 0.05);
        }
        
        .net-pay-section {
            background-color: var(--light);
            padding: 25px 30px;
            text-align: right;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .net-pay-label {
            font-size: 14px;
            color: var(--secondary);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .net-pay-amount {
            font-size: 24px;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 5px;
        }
        
        .net-pay-words {
            font-style: italic;
            color: var(--secondary);
            font-size: 13px;
            line-height: 1.4;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            padding: 25px 30px;
            border-top: 1px dashed rgba(0, 0, 0, 0.1);
        }
        
        .signature {
            width: 200px;
            text-align: center;
        }
        
        .signature-line {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.2);
            margin-top: 40px;
            margin-bottom: 10px;
        }
        
        .signature-label {
            font-size: 11px;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .payslip-footer {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 11px;
            opacity: 0.8;
        }
        
        .watermark {
            position: absolute;
            opacity: 0.04;
            font-size: 108px;
            font-weight: bold;
            color: var(--primary);
            transform: rotate(-30deg);
            z-index: 0;
            top: 22%;
            left: 10%;
            pointer-events: none;
            user-select: none;
        }
         .pretty-button {
    background-color: #4CAF50; /* Green background */
    color: white;              /* White text */
    padding: 12px 24px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .pretty-button:hover {
    background-color: #45a049; /* Darker green */
    transform: translateY(-2px);
  }

  .pretty-button:active {
    background-color: #3e8e41;
    transform: translateY(0);
  }
   .pdf-button {
    display: flex;
    justify-content: flex-end; /* Aligns child to the right */
    padding-right: 31%; /* Adjust this to control how far from the right edge */
    margin-bottom: 20px;
  }
        
        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
                font-size: 12px;
            }
            .payslip-container {
                box-shadow: none;
                border-radius: 0;
                border: none;
                width: 100%;
            }
            .watermark {
                display: none;
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<div id="loader" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
    <div class="spinner" ></div>
</div>
<body>
    
    <div class = "pdf-button">
        <?php if($empId == 'all' )
        { ?>
              <button class="pretty-button" onclick="downloadAllPDFs()">📄 Download All Payslips as PDF</button>
       <?php } else { ?>
            <button class="pretty-button" onclick="downloadPDF()">📄 Download as PDF</button>
        <?php } ?>
    </div>
    <div id="main">
    <?php foreach($salaryData as $data){
        $i=1;
        $empResult = $conn->query("SELECT * FROM employee_salary WHERE emp_id = $data[1]");
        if ($empResult->num_rows > 0) {
            $salaryData = $empResult->fetch_assoc();
        }
         ?>
        
        <div id = "payslip-container" class="payslip-container">
            <div class="watermark">SHREE ENTERPRISE</div>
            
            <div class="company-header">
                
                <div class="company-info">
                    <div class="company-name">SHREE ENTERPRISE</div>
                    
                </div>
            </div>
            
            <div class="payslip-title-section">
                <div class="payslip-title">Employee Payslip</div>
                <div class="payslip-period"><?= date('F Y', mktime(0, 0, 0, $salaryData['month'], 1, $salaryData['year'])) ?></div>
            </div>
            
            <div class="employee-info">
                <div class="info-item">
                    <div class="info-label">Employee ID</div>
                    <div class="info-value"><?= $salaryData['emp_id'] ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Employee Name</div>
                    <div class="info-value"><?= $salaryData['emp_name'] ?></div>
                </div>
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
                                <td><?= number_format($salaryData['basic_salary'], 2) ?></td>
                            </tr>
                            <tr>
                                <td>House Rent Allowance</td>
                                <td><?= number_format($salaryData['hra'], 2) ?></td>
                            </tr>
                            <tr class="highlight-row">
                                <td>Performance Bonus</td>
                                <td><?= number_format($salaryData['bonus'], 2) ?></td>
                            </tr>
                            <tr>
                                <td>Leave Encashment</td>
                                <td><?= number_format($salaryData['leave_encash'], 2) ?></td>
                            </tr>
                            <tr class="highlight-row">
                                <td>Overtime Pay</td>
                                <td><?= number_format($salaryData['ot_amount'], 2) ?></td>
                            </tr>
                            <tr class="total-row">
                                <td>Total Earnings</td>
                                <td><?= number_format($salaryData['gross_total'], 2) ?></td>
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
                                <td><?= number_format($salaryData['pf'], 2) ?></td>
                            </tr>
                            <tr class="highlight-row">
                                <td>ESIC</td>
                                <td><?= number_format($salaryData['esic'], 2) ?></td>
                            </tr>
                            <tr>
                                <td>Professional Tax</td>
                                <td><?= number_format($salaryData['prof_tax'], 2) ?></td>
                            </tr>
                            <tr class="highlight-row">
                                <td>Transport Deduction</td>
                                <td><?= number_format($salaryData['trans_ded'], 2) ?></td>
                            </tr>
                            <tr>
                                <td>Canteen</td>
                                <td><?= number_format($salaryData['canteen'], 2) ?></td>
                            </tr>
                            <tr class="highlight-row">
                                <td>Advance</td>
                                <td><?= number_format($salaryData['adv'], 2) ?></td>
                            </tr>
                            <tr class="total-row">
                                <td>Total Deductions</td>
                                <td><?= number_format($salaryData['total_deduction'], 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="net-pay-section">
                <div class="net-pay-label">Net Payable Amount</div>
                <div class="net-pay-amount">₹<?= number_format($salaryData['final_amount'], 2) ?></div>
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
        </div><br/><br/><br/><br/>
        </div>
    <?php } ?>
</body>
<script>
  function downloadPDF() {
    // Show loader
    document.getElementById('loader').style.display = 'flex';

    const element = document.getElementById('payslip-container');
    const opt = {
        filename: 'payslip.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 4, // Higher scale = better quality (2–5 is ideal)
            useCORS: true // allows loading of external styles/images
        },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    // Start the PDF download process
    html2pdf().set(opt).from(element).save().then(() => {
        // Hide loader after download is completed
        document.getElementById('loader').style.display = 'none';
    });
}

  function downloadAllPDFs() {
    // Show loader
    document.getElementById('loader').style.display = 'flex';

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const elements = document.querySelectorAll('.payslip-container');

    for (let i = 0; i < elements.length; i++) {
        const canvas = await html2canvas(elements[i], { scale: 2 });
        const imgData = canvas.toDataURL('image/jpeg', 1.0);
        
        const imgProps = doc.getImageProperties(imgData);
        const pdfWidth = doc.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        if (i > 0) doc.addPage();
        doc.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
    }

    doc.save('all-payslips.pdf').then(() => {
        // Hide loader after download is completed
        document.getElementById('loader').style.display = 'none';
    });
}

// downloadAllPDFs();
  </script>
</html>

<?php
function numToWords($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $decimal_part = $decimal > 0 ? " and " . (convertDigit($decimal) . ' Paise') : '';
    return convertDigit($no) . " Rupees" . $decimal_part . " Only";
}

function convertDigit($number) {
    $ones = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    );
    $tens = array(
        0 => 'Zero',
        1 => 'Ten',
        2 => 'Twenty',
        3 => 'Thirty',
        4 => 'Forty',
        5 => 'Fifty',
        6 => 'Sixty',
        7 => 'Seventy',
        8 => 'Eighty',
        9 => 'Ninety'
    );
    
    if ($number < 20) {
        return $ones[$number];
    }
    elseif ($number < 100) {
        return $tens[substr($number, 0, 1)] . ' ' . $ones[substr($number, 1, 1)];
    }
    elseif ($number < 1000) {
        return $ones[substr($number, 0, 1)] . ' Hundred ' . convertDigit(substr($number, 1));
    }
    elseif ($number < 100000) {
        return convertDigit(substr($number, 0, 2)) . ' Thousand ' . convertDigit(substr($number, 2));
    }
    elseif ($number < 10000000) {
        return convertDigit(substr($number, 0, 2)) . ' Lakh ' . convertDigit(substr($number, 2));
    }
    else {
        return convertDigit(substr($number, 0, 2)) . ' Crore ' . convertDigit(substr($number, 2));
    }
}
?>
