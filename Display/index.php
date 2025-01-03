<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM faculty_table";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Members</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .card {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            margin-right: 20px;
        }
        .card-content {
            flex: 1;
        }
        .card-content p {
            margin: 4px 0;
            font-size: 16px;
        }
        .card-content strong {
            font-weight: bold;
        }
		<style>

	.container {
		background-color: rgb(238, 235, 240);
		height: 40px;
		width: auto;
		display: flex;
		flex-direction: row;
		justify-content: start;
	}

	.row {
		background-color: rgb(238, 235, 240);
		color: rgb(11, 11, 12);
		height: 50%;
		width: 20%;
		margin-right: 60%;
		margin-top: 10px;
		margin-left: 10px;
	}

	.search-bar {
		margin-top: 5px;
	}

	.real {
		background-color: white;
		color: white;
		padding: 10px 20px;
		text-align: center;
		height: auto;
		width: auto;
		margin: 0;
		padding: 0;
	}

	.container1 {
		background-color: rgb(255, 255, 255);
		color: rgb(43, 69, 152);
		height: 120px;
		width: auto;
		position: sticky;
	}

	.row1 {
		background-color: rgb(255, 255, 255);
		align-items: center;
		justify-content: space-between;
		text-align: center;
		display: flex;
		flex-direction: row;
		width: 80%;
		margin-left: 10%;
	}

	.site_header_1 {
		height: 100px;
		width: 100px;
	}

	.photo {
		height: 100%;
		width: 100%;
	}

	.navbar {
		background-color: rgb(43, 69, 152);
		color: white;
		height: 20px;
		width: auto;
		text-decoration: none;
		font-size: medium;
		padding: 10px 20px;
	}

	.nav {
		display: flex;
		justify-content: space-between;
		color: rgb(255, 255, 255);
		display: flex;
		flex-direction: row;
	}

	.nav li {
		margin: o 15px;
		justify-content: start;
		color: rgb(254, 255, 255);
		font-size: 14.5px;
		background-color: rgb(43, 69, 152) ;
	}

	.a {
		color: rgb(255, 255, 255);
	}

	.all{
		height: auto;
		width: auto;
		background-color:rgb(238, 235, 240);
		display: flex;
		flex-direction: row;
		justify-content: space-between;
	}

	.department{
		height: auto;
		width: 20%;
		background-color:rgb(50, 61, 107);
		color: rgb(255, 255, 255);
		margin-top: 5px;
		margin-left: 5px;
		margin-bottom: 5px;
		font-size: xx-large;
		font-weight: 1000; 
	}

	.teachers{
		background-color:rgb(238, 235, 240) ;
		color: rgb(247, 241, 241);
		font-size: xx-large;
		font-weight: 1000;
		display: flex;
		flex-direction: column;
		margin-top: 5px;
		margin-right: 5px;
		justify-content: space-between;
		height: auto;
		width: 80%;
		margin-left: 4px;
		margin-bottom: 5px;
	}

	.teach1{
		background-color: rgb(235, 230, 230);
		display: flex;
		flex-direction: row;
		margin-top: 2px;
		margin-left: 2px;
		margin-right: 2px;
		justify-content: space-around;
		
	}

	.t1{
		background-color: rgb(226, 232, 232);
		color: black;
		height: 20%;
		width: 40%;
		margin-top: 20px;
		margin-left: 2px;
		margin-right: 2px;
	}

	.img1 {
		height: 200px;
		width: 200px;
		margin-top: 5px;
		margin-bottom: 5px;

	}

	footer {
		background-color:rgb(43, 69, 152) ;
		color: rgb(255, 255, 255);
		text-align: center;
		padding: 10px 20px;
		bottom: 0;
		width: 100%;
		position: fixed;
		height: 20px;
		position: relative;
	}
    </style>
</head>
<body>
	
	<div>
		<h1>Faculty Members</h1>
		<?php if ($result->num_rows > 0): ?>
			<?php while ($row = $result->fetch_assoc()): ?>
				<div class="card">
					<img src="<?php echo $row['image']; ?>" alt="Faculty Image">
					<div class="card-content">
						<p><strong>Faculty ID:</strong> <?php echo $row['faculty_id']; ?></p>
						<p><strong>Name:</strong> <?php echo $row['name']; ?></p>
						<p><strong>Designation:</strong> <?php echo $row['Designation']; ?></p>
						<p><strong>Department:</strong> <?php echo $row['Department']; ?></p>
						<p><strong>Date of Joining:</strong> <?php echo $row['date_of_joining']; ?></p>
						<p><strong>Email:</strong> <?php echo $row['email_id']; ?></p>
						<p><strong>Contact No:</strong> <?php echo $row['contact_no']; ?></p>
					</div>
				</div>
			<?php endwhile; ?>
		<?php else: ?>
			<p>No records found.</p>
		<?php endif; ?>
		<?php $conn->close(); ?>
	</div>
    
</body>
</html>
