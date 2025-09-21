<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<!-- jquery  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- //font-awesome -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

	<title>Admin Panel</title>
	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			font-family: 'Segoe UI', sans-serif;
			background-color: #f5f7fa;
		}

		.sidebar {
			width: 220px;
			height: 100vh;
			/* full viewport height */
			position: fixed;
			background-color: #3485A7;
			color: white;
			padding: 25px 15px;
			box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
			overflow-y: auto;
			/* scrollable if content exceeds height */
		}

		.sidebar::-webkit-scrollbar {
			width: 6px;
		}

		.sidebar::-webkit-scrollbar-thumb {
			background-color: rgba(255, 255, 255, 0.3);
			border-radius: 3px;
		}


		.sidebar a {
			color: white;
			display: block;
			padding: 10px 15px;
			margin: 10px 0;
			border-radius: 6px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}

		.sidebar a:hover {
			background-color: #08417a;
			text-decoration: none;
		}

		.content {
			margin-left: 240px;
			padding: 30px;
		}
	</style>

</head>

<body>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>