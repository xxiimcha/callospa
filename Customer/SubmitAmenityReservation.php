<?php

include 'callospa_resort_database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $contact_number = intval($_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $handle = $_POST['handle'];
    $sources = isset($_POST['source']) ? implode(',', $_POST['source']) : '';
    $source_other = isset($_POST['source_other']) ? $_POST['source_other'] : '';
    $package_category = isset($_POST['package_category']) ? mysqli_real_escape_string($conn, $_POST['package_category']) : '';
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $check_in_date = mysqli_real_escape_string($conn, $_POST['check_in_date']);
    $check_in_time = isset($_POST['check_in_time']) ? $_POST['check_in_time'] : (isset($_POST['check_in_time_hidden']) ? $_POST['check_in_time_hidden'] : '');
    $check_out_time = isset($_POST['check_out_time']) ? $_POST['check_out_time'] : (isset($_POST['check_out_time_hidden']) ? $_POST['check_out_time_hidden'] : '');
    $guests = intval($_POST['guests']);
    $total_cost = floatval($_POST['total_cost']);
    $deposit_amount = floatval($_POST['deposit_amount']);
    $remaining_balance = floatval($_POST['remaining_balance']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    if (empty($first_name) || empty($last_name) || empty($contact_number) || empty($email) || empty($package_category) || empty($package) || empty($check_in_date) || empty($check_in_time) || empty($guests) || empty($payment_method)) {
    }

    $proof_of_payment = '';
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['proof_of_payment']['tmp_name'];
        $fileName = $_FILES['proof_of_payment']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = array('jpg', 'jpeg', 'png');

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = '../ProofOfPayment/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $proof_of_payment = $fileName;
            } else {
            }
        } else {
        }
    }

    $combined_sources = $sources;
    if (!empty($source_other)) {
        if (!empty($combined_sources)) {
            $combined_sources .= ', ';
        }
        $combined_sources .= $source_other;
    }

    $stmt = $conn->prepare("INSERT INTO pending_amenity_reservations (first_name, middle_name, last_name, contact_number, email, handle, sources, source_other, package_category, package, check_in_date, check_in_time, check_out_time, guests, total_cost, deposit_amount, remaining_balance, payment_method, proof_of_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssssssssidddss", $first_name, $middle_name, $last_name, $contact_number, $email, $handle, $combined_sources, $source_other, $package_category, $package, $check_in_date, $check_in_time, $check_out_time, $guests, $total_cost, $deposit_amount, $remaining_balance, $payment_method, $proof_of_payment);

    if ($stmt->execute()) {
        $title = "Callospa Resort";
        $mainHeader = "CALLOSPA";
        $subHeader = "Resort";
        $mainTitle = "RESERVATION SUMMARY";
        $subTitle = "Thank you for choosing Callospa Resort! Your reservation has been successfully completed.";

        $navLinks = [
            "Home" => "HomePage.php",
            "Packages" => "PackagesPage.php",
            "Rooms" => "RoomsPage.php",
            "Events" => "EventsPage.php",
            "Spa" => "AmenitiesPage.php",
            "Gallery" => "GalleryPage.php",
        ];

        $contactInfo = [
            "name" => "Callospa Resort",
            "email" => "callos.realty.leasing@gmail.com",
            "address" => "H599+3gf, Marigman Rd, Antipolo, 1870, Rizal",
            "phone" => "+63 9178243715 / +63 983560798"
        ];

        $currentPage = basename($_SERVER['PHP_SELF']);
    } else {
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Callospa Resort - Reservation Summary</title>
</head>

<body>

    <header class="header">
        <div class="u-container">
            <div class="header-content">
                <a href="#" class="header-brand">
                    <span class="header-brand-primary"><?php echo htmlspecialchars($mainHeader, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="header-brand-sub"><?php echo htmlspecialchars($subHeader, ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
                <nav class="nav">
                    <ul class="nav-list">
                        <?php
                        $currentPage = basename($_SERVER['PHP_SELF']);
                        foreach ($navLinks as $name => $link):
                            $isActive = (basename($link) == $currentPage || ($currentPage == 'SubmitAmenityReservation.php' && basename($link) == 'AmenitiesPage.php')) ? 'active' : '';
                        ?>
                            <li class="nav-item">
                                <a href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>"
                                    class="nav-link <?php echo $isActive; ?>">
                                    <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <button class="nav-btn">
                    <i class="fa-solid fa-bars nav-icon-menu"></i>
                    <i class="fa-solid fa-x nav-icon-close"></i>
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="section-hero section-hero--submit-amenity">
            <header class="header--hero">
                <h1 class="heading heading-primary u-margin-bottom-md"><?php echo htmlspecialchars($mainTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="u-margin-bottom-xl"><?php echo htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>
        </section>

        <div class="reservation">
            <header class="reservation-header">
                <div class="reservation-brand">
                    <span class="reservation-brand-primary">Callospa</span>
                    <span class="reservation-brand-sub">Resort</span>
                </div>

                <p class="reservation-greeting">Thank you for booking with us! Please review the details of your reservation below to confirm that all information is correct.</p>
            </header>

            <div class="reservation-body">
                <div class="reservation-info">
                    <h3 class="reservation-heading">Contact Information</h3>
                    <ul class="reservation-list">
                        <ul class="reservation-list">
                            <li class="reservation-item">
                                <span class="reservation-label">Full Name</span>
                                <span class="reservation-data"><?php echo htmlspecialchars($first_name . ' ' . ($middle_name ? $middle_name . ' ' : '') . $last_name, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                            <li class="reservation-item">
                                <span class="reservation-label">Contact Number</span>
                                <span class="reservation-data"><?php echo htmlspecialchars($contact_number, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                            <li class="reservation-item">
                                <span class="reservation-label">Email</span>
                                <span class="reservation-data"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                            <li class="reservation-item">
                                <span class="reservation-label">Social Media Handle</span>
                                <span class="reservation-data"><?php echo htmlspecialchars($handle, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                            <li class="reservation-item">
                                <span class="reservation-label">How Did You Hear About Us?</span>
                                <span class="reservation-data"><?php echo htmlspecialchars($combined_sources, ENT_QUOTES, 'UTF-8'); ?></span>
                            </li>
                        </ul>
                </div>


                <div class="reservation-info">
                    <h3 class="reservation-heading">Reservation Details</h3>
                    <ul class="reservation-list">
                        <li class="reservation-item">
                            <span class="reservation-label">Spa Category</span>
                            <span class="reservation-data"><?php echo htmlspecialchars($package_category, ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Spa Service</span>
                            <span class="reservation-data"><?php echo htmlspecialchars($package, ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Check-In Date and Time</span>
                            <span class="reservation-data"><?php echo date('F j, Y', strtotime(htmlspecialchars($check_in_date, ENT_QUOTES, 'UTF-8'))) . ($check_in_time ? ', at ' . date('h:i A', strtotime(htmlspecialchars($check_in_time, ENT_QUOTES, 'UTF-8'))) : ''); ?></span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Number of Guests</span>
                            <span class="reservation-data"><?php echo htmlspecialchars($guests, ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                    </ul>
                </div>

                <div class="reservation-info">
                    <h3 class="reservation-heading">Payment Information</h3>
                    <ul class="reservation-list">
                        <li class="reservation-item">
                            <span class="reservation-label">Total Cost</span>
                            <span class="reservation-data"><?php echo htmlspecialchars(number_format($total_cost, 2), ENT_QUOTES, 'UTF-8'); ?> PHP</span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Deposit Amount</span>
                            <span class="reservation-data"><?php echo htmlspecialchars(number_format($deposit_amount, 2), ENT_QUOTES, 'UTF-8'); ?> PHP</span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Remaining Balance</span>
                            <span class="reservation-data"><?php echo htmlspecialchars(number_format($remaining_balance, 2), ENT_QUOTES, 'UTF-8'); ?> PHP</span>
                        </li>
                        <li class="reservation-item">
                            <span class="reservation-label">Payment Method</span>
                            <span class="reservation-data"><?php echo htmlspecialchars($payment_method, ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                    </ul>
                </div>

                <?php if ($proof_of_payment): ?>
                    <div class="reservation-proof">
                        <h3 class="reservation-heading">Proof of Payment</h3>

                        <div class="reservation-payment">
                            <div class="reservation-row">
                                <img src="<?php echo htmlspecialchars('../ProofOfPayment/' . $proof_of_payment, ENT_QUOTES, 'UTF-8'); ?>" alt="Payment Confirmation" class="reservation-qr" style="max-width: 100%; height: auto;" />
                                <div>
                                    <p>Thank you for providing your payment confirmation! Here is the image of the payment proof you uploaded. Please keep this for your records.</p>
                                </div>
                            </div>

                            <p>We will send your invoice to your email shortly. If you have any questions or need further support with your reservation, feel free to reach out to us. We are committed to making your stay enjoyable and smooth. We look forward to welcoming you and hope you have a wonderful experience at our resort!</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </main>

    <footer class="footer">
        <div class="u-container">
            <div class="footer-content">
                <div class="footer-socials">
                    <a href="#" class="footer-brand u-margin-bottom-lg">
                        <span class="footer-brand-primary"><?php echo htmlspecialchars($mainHeader, ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="footer-brand-sub"><?php echo htmlspecialchars($subHeader, ENT_QUOTES, 'UTF-8'); ?></span>
                    </a>
                    <ul class="footer-list u-margin-bottom-xl">
                        <li class="footer-item">
                            <a href="https://www.facebook.com/profile.php?id=100064383150064" target="_blank" class="footer-link">
                                <i class="fab fa-facebook-f fa-xl"></i>
                            </a>
                        </li>
                        <li class="footer-item">
                            <a href="viber://chat?number=639178334351"
                                target="_blank" class="footer-link">
                                <i class="fab fa-viber fa-xl"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h3 class="footer-heading">Contact Us</h3>
                    <ul class="footer-address">
                        <li class="footer-item">
                            <i class="fa-solid fa-envelope fa-xl"></i>
                            <a class="footer-link" href="mailto:<?php echo htmlspecialchars($contactInfo['email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($contactInfo['email'], ENT_QUOTES, 'UTF-8'); ?></a>
                        </li>
                        <li class="footer-item">
                            <i class="fa-solid fa-phone fa-xl"></i>
                            <p><?php echo htmlspecialchars($contactInfo['phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </li>
                        <li class="footer-item">
                            <i class="fa-solid fa-location-dot fa-xl"></i>
                            <p><?php echo htmlspecialchars($contactInfo['address'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4625.815151226894!2d121.16622007583787!3d14.567698385914756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c74c837569df%3A0x73e3b8d8e8705966!2sCallospa%20Resort!5e1!3m2!1sen!2sph!4v1727404769856!5m2!1sen!2sph" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <p class="u-text-center">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>

</html>