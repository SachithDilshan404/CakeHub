<?php
session_start();
require "connection.php";

// Check if the user is logged in
if (!isset($_SESSION["u"])) {
	header("Location: index.php"); // Redirect non-logged-in users to index page
	exit();
}

$email = $_SESSION["u"]["email"];

// Check if the user is an admin
$result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");

$showMyListings = false; // Initialize as false for shoppers

if ($result && $row = $result->fetch_assoc()) {
	$is_admin = $row['is_admin'];
	$showMyListings = ($is_admin == 1);
}


// Check if the user has a profile picture
$image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $email . "'");
$image_data = $image_rs->fetch_assoc();

if (empty($image_data["path"])) {
	header("Location: onboarding.php"); // Redirect users without a profile picture to onboarding page
	exit();
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Profile | Cake Hub</title>
	<link rel="shortcut icon" type="image" href="styles/logo.png">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="styless.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-user-account'></i>
			<span class="text">User Management</span>
		</a>
		<ul class="side-menu top">
			<?php if ($showMyListings) : ?>
				<li <?php if ($showMyListings) echo "class='active'"; ?>>
					<a href="#" data-tab-id="section1">
						<i class='bx bxs-plus-circle'></i>
						<span class="text">My Listings</span>
					</a>
				</li>
			<?php endif; ?>

			<li <?php if (!$showMyListings) echo "class='active'"; ?>>
				<a href="#" data-tab-id="section2">
					<i class='bx bx-info-circle'></i>
					<span class="text">Customer Details</span>
				</a>
			</li>
			<li>
				<a href="#" data-tab-id="section3">
					<i class='bx bxs-add-to-queue'></i>
					<span class="text">Invoice</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" class="logout" onclick="logout()">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<div class="pro">
				<?php

				if (isset($_SESSION["u"])) {
					$session_data = $_SESSION["u"];
					$email = $session_data["email"];
				}

				?>
				<?php
				$result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");
				if ($result && $row = $result->fetch_assoc()) {
					$is_admin = $row['is_admin'];
					$userType = $is_admin == 1 ? 'Admin' : 'Shopper';
				} else {
					$userType = 'Shopper';
				}

				echo '<a class="notification" style="cursor: pointer; margin-right:;">
						<p>' . $userType . '</p>
					</a>';
				?>
				<?php
				if (isset($_SESSION["u"])) {
					$session_data = $_SESSION["u"];

				?>
					<a class="notification" style="cursor: pointer;">
						<p style="margin-left: 30px; margin-right: 30px; font-weight: bold;">Hi, <?php echo $session_data["fname"] . " " . $session_data["lname"]; ?> </p>
					</a>
				<?php
				} else {
				}
				?>
				<?php
				if (isset($_SESSION["u"])) {
					$session_data = $_SESSION["u"];


					// Fetch user profile image
					$image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $email . "'");
					$image_data = $image_rs->fetch_assoc();
				}
				?>
				<a class="profile" style="cursor: pointer;">
					<?php
					if (isset($_SESSION["u"])) {
						if (empty($image_data["path"])) {
							echo '<img src="styles/placeholder.jpg" alt="" width="30px" >';
						} else {
							echo '<img src="' . $image_data["path"] . '" alt="" width="30px" >';
						}
					}
					?>

				</a>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div id="section2" class="tab-content">
				<div class="head-title">
					<div class="left">
						<h1>About Me</h1>
						<ul class="breadcrumb">
							<li>
								<a href="#">My Account</a>
							</li>
							<li><i class='bx bx-chevron-right'></i></li>
							<li>
								<a class="active" href="#">About Me</a>
							</li>
						</ul>
					</div>

				</div>

				<div class="table-data">
					<div class="order">
						<table>
							<thead>
								<tr>
									<?php
									if (isset($_SESSION["u"])) {
										if (empty($image_data["path"])) {
											echo '<img src="styles/placeholder.jpg" alt="" width="30px" >';
										} else {
											echo '<img src="' . $image_data["path"] . '" alt="" width="90px" style="border-radius:50px;">';
										}
									}
									?>
								</tr>
							</thead>

							<tbody style="cursor: pointer;">
								<tr>
									<td>
										<?php
										if (isset($_SESSION["u"])) {
											$session_data = $_SESSION["u"];
										}
										?>
										<p style="font-weight: bold;">First Name</p>
									</td>
									<td><?php echo $session_data["fname"]; ?></td>
									<td></td>
								</tr>
								<tr>
									<td>
										<p style="font-weight: bold;">Last Name</p>
									</td>
									<td><?php echo $session_data["lname"]; ?></td>
									<td></td>
								</tr>
								<tr>
									<td>
										<p style="font-weight: bold;">Email</p>
									</td>
									<td><?php echo $session_data["email"]; ?></td>
									<td></td>
								</tr>
								<tr>
									<td>
										<p style="font-weight: bold;">Mobile Number</p>
									</td>
									<td><?php echo $session_data["mobile"]; ?></td>
									<td></td>
								</tr>
								<tr>
									<td>
										<p style="font-weight: bold;">Joined Date</p>
									</td>
									<td><?php echo $session_data["joined_date"]; ?></td>
									<td></td>
								<tr>
									<td>
										<p style="font-weight: bold;">Address</p>
									</td>
									<?php

									$address_rs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city.city_id INNER JOIN `distric` ON city.distric_distric_id=distric.distric_id INNER JOIN `province` ON distric.province_province_id=province.province_id WHERE `users_email`='" . $email . "'");
									$address_data = $address_rs->fetch_assoc();
									?>
									<td><?php echo $address_data["line1"]; ?></td>
									<td></td>
								</tr>
								<tr>
									<td>
										<p style="font-weight: bold;">Account Type</p>
									</td>
									<?php
									$result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");
									if ($result && $row = $result->fetch_assoc()) {
										$is_admin = $row['is_admin'];
										$userType = $is_admin == 1 ? 'Admin' : 'Shopper';
									} else {
										$userType = 'Shopper';
									}

									echo '<td>
												<p>' . $userType . '</p>
											</td>';
									?>

									<td></td>
								</tr>

							</tbody>

						</table>

						<div>
							<div class="container-contact100-form-btn" style="margin-right: 550px; position:relative">
								<div class="wrap-contact100-form-btn">
									<div class="contact100-form-bgbtn"></div>
									<button class="contact100-form-btn" onclick="window.location='onboarding.php';">
										<span>
											Change Profile Details
											<i class="fa fa-long-arrow-up m-l-7" aria-hidden="true"></i>
										</span>
									</button>
								</div>
							</div>
						</div>
						<div style="margin-top:-63px;">
							<div class="container-contact100-form-btn" style="margin-left: 550px; position:relative">
								<div class="wrap-contact100-form-btn">
									<div class="contact100-form-bgbtn"></div>
									<button class="contact100-form-btn" onclick="window.location='home.php';" ;>
										<span>
											Back to Shopping
											<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
										</span>
									</button>
								</div>
							</div>
						</div>
					</div>

				</div>


			</div>
			<!-- Section 2 Starts Here	-->
			<div id="section1" class="tab-content">
				<div class="head-title">
					<div class="left">
						<h1>My Listings</h1>
						<ul class="breadcrumb">
							<li>
								<a href="#">My Account</a>
							</li>
							<li><i class='bx bx-chevron-right'></i></li>
							<li>
								<a class="active" href="#">Listings</a>
							</li>
						</ul>
					</div>

				</div>
				<br />
				<div class="search">
					<form action="#">
						<div class="form-input">
							<input type="search" placeholder="Sort By..." id="s">
							<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
						</div>
					</form>
				</div>

				<ul class="box-info">
					<li>
						<p style="font-weight:bold;">Active Time</p>
						<span class="text">
							<form>
								<input type="radio" id="n" name="time" value="time">
								<label for="n">Newer to Old</label><br />
								<input type="radio" id="o" name="time" value="time1">
								<label for="o">Old to Newer</label>
							</form>
						</span>
					</li>
					<li>
						<p style="font-weight:bold;">By Price</p>
						<span class="text">
							<form>
								<input type="radio" id="h" name="qty" value="qty">
								<label for="h">High to Low</label><br />
								<input type="radio" id="l" name="qty" value="qty1">
								<label for="l">Low to High</label>
							</form>
						</span>
					</li>
					<li>
						<p style="font-weight:bold;">By Catageory</p>
						<span class="text">
							<form>
								<input type="radio" id="b" name="cake" value="cake">
								<label for="b">Birthday Cakes</label><br />
								<input type="radio" id="u" name="cake" value="cake1">
								<label for="u">Choco Cake</label>
							</form>
						</span>
					</li>



				</ul>
				<div class="container-contact100-form-btn" style="margin-right: 550px; position:relative">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" onclick="sort(0);">
							<span>
								Search
								<i class='bx bxs-search'></i>
							</span>
						</button>
					</div>
				</div>
				<div style="margin-top:-63px;">
					<div class="container-contact100-form-btn" style="margin-left: 550px; position:relative">
						<div class="wrap-contact100-form-btn">
							<div class="contact100-form-bgbtn"></div>
							<button class="contact100-form-btn" onclick="clearSort();" ;>
								<span>
									Clear Filters
									<i class='bx bx-x'></i>
								</span>
							</button>
						</div>
					</div>
				</div>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Listed Products</h3>
							<i class='bx bx-search'></i>
							<i class='bx bx-filter'></i>
						</div>
						<table>
							<tbody>
								<div class="gg" id="sort">
									<section id="product-cards">
										<div class="container">
											<?php

											if (isset($_GET["page"])) {
												$pageno = $_GET["page"];
											} else {
												$pageno = 1;
											}

											$product_rs = Database::search("SELECT * FROM `product` WHERE `users_email`='" . $email . "'");
											$product_num = $product_rs->num_rows;

											$results_per_page = 6;
											$number_of_pages = ceil($product_num / $results_per_page);

											$page_results = ($pageno - 1) * $results_per_page;
											$selected_rs = Database::search("SELECT * FROM `product` WHERE `users_email`='" . $email . "' LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

											$selected_num = $selected_rs->num_rows;

											for ($x = 0; $x < $selected_num; $x++) {
												$selected_data = $selected_rs->fetch_assoc();

											?>

												<div class="row" style="margin-top:50px;">
													<div class="col-md-3 py-3 py-md-0">
														<div class="card" style="width: 257px; height:570px;">
															<?php

															$product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $selected_data["id"] . "'");
															$product_img_data = $product_img_rs->fetch_assoc();


															?>
															<img src="<?php echo $product_img_data["img_path"]; ?>" alt="" class="imghh">
															<div class="card-body">
																<h3><?php echo $selected_data["title"]; ?></h3>
																<div class="star">
																	<i class="bx bxs-star checked"></i>
																	<i class="bx bxs-star checked"></i>
																	<i class="bx bxs-star checked"></i>
																	<i class="bx bxs-star "></i>
																	<i class="bx bxs-star "></i>
																</div>
																<p><?php echo $selected_data["srt_descri"]; ?></p> <br />
																<h6>Rs.<?php echo $selected_data["price"]; ?>.00 <span><button onclick="sendId(<?php echo $selected_data['id']; ?>);">Update</button></span></h6>
															</div>

														</div>
													</div>
												</div>

											<?php
											}

											?>



										</div>
									</section>

									<br />
									<div class="pagination">
										<ul>
											<li><a href="<?php if ($pageno <= 1) {
																echo ("#");
															} else {
																echo "?page=" . ($pageno - 1);
															} ?>" class="prev">&lt; Prev</a></li>
											<?php
											for ($y = 1; $y <= $number_of_pages; $y++) {
												if ($y == $pageno) {
													echo "<li class='pageNumber active'><a href='?page=$y'>$y</a></li>";
												} else {
													echo "<li class='pageNumber'><a href='?page=$y'>$y</a></li>";
												}
											}
											?>
											<li><a href="<?php if ($pageno >= $number_of_pages) {
																echo ("#");
															} else {
																echo "?page=" . ($pageno + 1);
															} ?>" class="next">Next &gt;</a></li>
										</ul>
									</div>
								</div>
							</tbody>

						</table>

					</div>

				</div>
			</div>




			<div id="section3" class="tab-content">
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Recent Orders</h3>
							<i class='bx bx-search'></i>
							<i class='bx bx-filter'></i>
						</div>
						<table>
							<thead>
								<tr>
									<th>User</th>
									<th>Invoice No</th>
									<th>Amount</th>
									<th>QTY</th>
									<th>Date Order</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `users_email`='" . $email . "'");
								while ($invoice_data = $invoice_rs->fetch_assoc()) {
								?>
									<tr>
										<td>
											<img src="<?php echo $image_data["path"]; ?>">
											<p><?php echo $session_data["fname"]; ?> <?php echo $session_data["lname"]; ?></p>
										</td>
										<td>#<?php echo $invoice_data["order_id"]; ?></td>
										<td>Rs.<?php echo $invoice_data["total"]; ?>.00</td>
										<td>x<?php echo $invoice_data["qty"]; ?></td>
										<td><?php echo $invoice_data["date"]; ?></td>
										<td><span class="status completed">Completed</span></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</main>


	</section>
	<!-- CONTENT -->
	<script src="scriptt.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>


</body>

</html>