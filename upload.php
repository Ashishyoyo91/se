
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
else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS (Animate on Scroll) CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .upload-card {
            max-width: 500px;
            margin: 80px auto;
            padding: 40px;
            border: none;
            border-radius: 15px;
            background: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }
        .btn-upload {
            background-color: #007bff;
            color: #fff;
        }
        .btn-upload:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="upload-card" data-aos="fade-up">
            <h3 class="text-center mb-4">Upload Your CSV File</h3>
            <form action="import.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="csv_file" class="form-label">Select CSV File</label>
                    <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-upload btn-lg">Upload CSV</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>
<?php 
    }
    ?>