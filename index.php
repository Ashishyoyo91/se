<?php
$subscription = 1779216000; // timestamp
$readableDate = date('Y-m-d', $subscription);
$currentDate = date('Y-m-d');

if ($currentDate === $readableDate) {
 ?>
  <style>
    
/*======================
    404 page
=======================*/


.page_404{ padding:40px 0; background:#fff; font-family: 'Arvo', serif;
}

.page_404  img{ width:100%;}

.four_zero_four_bg{
 
 background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
    height: 768px;
    background-position: center;
 }
 
 
 .four_zero_four_bg h1{
 font-size:80px;
 }
 
  .four_zero_four_bg h3{
			 font-size:80px;
			 }
			 
			 .link_404{			 
	color: #fff!important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;}
	.contant_box_404{ margin-top:-50px;}
  </style>  
<section class="page_404">
	<div class="container">
		<div class="row">	
		<div class="col-sm-12 ">
		<div class="col-sm-10 col-sm-offset-1  text-center">
		<div class="four_zero_four_bg">
			<h1 class="text-center ">ERROR 404!...............</h1>
		
		
		</div>
		
		<div class="contant_box_404">
		<h1 class="h2">
		Contact Admin
		</h1>
		
		<p>8239239550</p>
		
		
	</div>
		</div>
		</div>
		</div>
	</div>
</section>
<?php }
else{
$conn = new mysqli("localhost", "root", "", "test");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --gray: #6b7280;
            --light-gray: #f3f4f6;
            --white: #ffffff;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .form-container {
            width: 100%;
            max-width: 500px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }
        
        .form-subtitle {
            font-size: 14px;
            color: var(--gray);
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: var(--white);
            transition: all 0.2s ease;
            appearance: none;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 1.5em;
            padding-right: 40px;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-light);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--gray);
        }
    </style>
</head>
<body>



    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Payslip Search</h1>
            <p class="form-subtitle">Select employee and period to view payslip</p>
        </div>
        
        <form id="searchForm" action="salary_slip.php" method="POST">
            <div class="form-group">
                <label for="employee" class="form-label">Employee</label>
                <select id="employee" name="employee" class="form-control" required>
                    <option value="">Select Employee</option>
                    <option value="all">Select All</option>
                    <?php
                    $res = $conn->query("SELECT DISTINCT emp_id, emp_name FROM employee_salary");
                        $rows = $res->fetch_all();
                        foreach($rows as $row){
                            echo "<option value='{$row[0]}' $selected>{$row[1]}</option>";
                        }
                    ?>
    </select>
                </select>
            </div>
            
            <div class="form-group">
                <label for="month" class="form-label">Month</label>
                <select id="month" class="form-control" name="month" required>
                    <option value="">Select Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="year" class="form-label">Year</label>
                <select id="year" name="year"class="form-control" required>
                    <option value="">Select Year</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">View Payslip</button>
        </form>
        <div style="margin-top: 15px;text-align: center;" >
               <a href ="./upload.php" ><button type="" name="" class="btn btn-primary btn-md">Upload Excel</button></a>
           </div>
       <div class="form-footer">
        Need help? Contact 8239239550
    </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const employee = document.getElementById('employee').value;
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            
            if (!employee || !month || !year) {
                alert('Please select all required fields');
                return;
            }
            
            // Here you would typically submit the form or fetch the payslip
            console.log('Searching for payslip:', {
                employee,
                month,
                year
            });
            
            // alert(Searching for payslip: Employee ${employee}, ${month}/${year});
        });
    </script>
</body>
</html>

<?php

    }
    ?>