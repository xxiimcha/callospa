<?php

include 'callospa_resort_database.php';

$title = "Callospa Resort";

$mainHeader = "CALLOSPA";
$subHeader = "Resort";

$mainTitle = "AMENITIES RESERVATION FORM";
$subTitle = "Book our premium amenities with ease by filling out the form below. Select your desired amenities and schedule to enhance your stay.";

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

$query = "SELECT * FROM amenities";
$result = mysqli_query($conn, $query);

$amenities = [];

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['amenities_categories'];
    $amenities[$category][] = [
        'name' => $row['amenities_subcategory_name'],
        'image_url' => $row['amenities_subcategory_image_url'],
        'description' => $row['amenities_subcategory_description'],
        'price' => number_format((float)$row['price'], 2, '.', ''),
        'duration' => $row['duration'],
    ];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
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
                            $isActive = (basename($link) == $currentPage || ($currentPage == 'AmenitiesReservationForm.php' && basename($link) == 'AmenitiesPage.php')) ? 'active' : '';
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
        <section class="section-hero section-hero--amenity-form">
            <header class="header--hero">
                <h1 class="heading heading-primary u-margin-bottom-md"><?php echo htmlspecialchars($mainTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="u-margin-bottom-xl"><?php echo htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>
        </section>

        <div class="section section">
            <div class="u-container">
                <form action="SubmitAmenityReservation.php" method="POST" enctype="multipart/form-data" class="form">
                    <div class="form-block">
                        <h2 class="form-title u-margin-bottom-sm">Contact Information</h2>
                        <p class="form-desc u-margin-bottom-lg">Fill in your contact details to help us get in touch with you regarding your reservation.</p>

                        <div class="form-row u-margin-bottom-md">

                            <div class="form-input-group">
                                <label for="first-name" class="form-label">First Name <span class="form-required">*</span></label>
                                <input type="text" id="first-name" name="first_name" class="form-input" placeholder="Enter your First Name" required />
                            </div>

                            <div class="form-input-group">
                                <label for="middle-name" class="form-label">Middle Name </label>
                                <input type="text" id="middle-name" name="middle_name" class="form-input" placeholder="Enter your Middle Name" />
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">

                            <div class="form-input-group">
                                <label for="last-name" class="form-label">Last Name <span class="form-required">*</span></label>
                                <input type="text" id="last-name" name="last_name" class="form-input" placeholder="Enter your Last Name" required />
                            </div>

                            <div class="form-input-group">
                                <label for="contact-number" class="form-label">Contact Number <span class="form-required">*</span>
                                </label>
                                <input type="tel" id="contact-number" name="contact_number" class="form-input" placeholder="Enter your Contact Number" required />
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="email" class="form-label">Email <span class="form-required">*</span></label>
                                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your Email" required />
                            </div>

                            <div class="form-input-group">
                                <label for="handle" class="form-label">Facebook/Instagram Handle
                                </label>
                                <input type="handle" id="handle" name="handle" class="form-input" placeholder="Enter your Contact Handle" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Where did you hear about us?<span class="form-required">*</span></label>
                            <div class="form-checkbox-group u-margin-bottom-md"><label class="form-label-checkbox"><input type="checkbox" name="source[]" value="Facebook" />Facebook</label>
                                <label class="form-label-checkbox"><input type="checkbox" name="source[]" value="Word of Mouth" />Word of Mouth</label>
                                <label class="form-label-checkbox"><input type="checkbox" name="source[]" value="Returning Customer" />Returning Customer</label>
                                <label class="form-label-checkbox"><input type="checkbox" name="source[]" value="Google" />Google</label>
                            </div>

                            <label class="form-label-checkbox"><input type="checkbox" name="source[]" value="Others" />Others:<input type="text" name="source_other" class="form-input" placeholder="Enter where did you hear us" /></label>
                        </div>
                    </div>

                    <div class="form-block">
                        <h2 class="form-title u-margin-bottom-sm">Reservation Details</h2>
                        <p class="form-desc u-margin-bottom-lg">Please provide information about your stay, including the room type you wish to book check-in and check-out dates & additional number of guests.</p>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="package-category" class="form-label">Select Spa Category <span class="form-required">*</span></label>
                                <select id="package-category" name="package-category" class="form-input" required onchange="updatePackageOptions()">
                                    <option value="" disabled selected>Select Spa Category</option>
                                    <?php foreach (array_keys($amenities) as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="package" class="form-label">Select Spa Category <span class="form-required">*</span></label>
                                <select id="package" name="package" class="form-input" required onchange="updatePackageDetails()">
                                    <option value="">Select Spa Service</option>
                                </select>
                            </div>
                        </div>

                        <div id="package-details" class="dropdown-details" style="display: none;">
                            <div id="package-images" class="dropdown-images"></div>
                            <div class="dropdown-body">
                                <p class="dropdown-description"><span class="dropdown-label">Price: </span><span id="package-price"></span></p>
                                <p class="dropdown-description"><span class="dropdown-label">Duration: </span><span id="package-duration"></span></p>
                                <p class="dropdown-description"><span class="dropdown-label">Description: </span><span id="package-description"></span></p>
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="check-in-date" class="form-label">Check-In Date<span class="form-required">*</span></label>
                                <input type="text" id="check-in-date" name="check_in_date" required onchange="calculateTotalCost()" class="form-input" placeholder="Enter Check-In Date" />
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="check-in-time" class="form-label">Check-In Time<span class="form-required">*</span></label>
                                <input type="text" id="check-in-time" name="check_in_time" class="form-input" required />
                                <div id="time-picker"></div>
                            </div>

                            <div class="form-input-group">
                                <label for="check-out-time" class="form-label">Check-Out Time:</label>
                                <input type="text" id="check-out-time" name="check_out_time" class="form-input" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-input-group">
                                <label for="guests" class="form-label">Number of Guests:<span class="form-required">*</span></label>
                                <input type="number" id="guests" name="guests" min="1" class="form-input" required />
                                <p class="form-note"><strong>Note: </strong>The number of guests displayed is the <strong>maximum allowed</strong> for that particular room.</p>
                            </div>

                            <div class="form-input-group">
                                <label for="additional_guest" class="form-label">Add Additional Guests (Optional):</label>
                                <input type="number" id="additional_guest" name="additional_guest" min="0" placeholder="0" oninput="calculateTotalCost()" class="form-input" />
                                <p class="form-note">If you want to have <strong>additional guests</strong>, there will be a charge of <strong>₱250.00 per person.</strong></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-block form-block-payment">
                        <h2 class="form-title u-margin-bottom-sm">Payment Details</h2>
                        <div class="form-payment-container u-margin-bottom-lg">
                            <div class="form-group-price">
                                <div class="u-margin-bottom-lg">
                                    <p class="form-details">Total Reservation Cost: <span id="total-cost" class="form-price">Php 0.00</span></p>
                                    <p class="form-note">The price listed above shows the <strong> total cost of your reservation.</strong></p>
                                    <input type="hidden" id="total-cost-hidden" name="total_cost" value="0" />
                                </div>
                                <div class="u-margin-bottom-md">
                                    <p class="form-details"> 20% Reservation Cost Deposit: <span id="discount-amount" class="form-price">Php 0.00</span></p>
                                    <p class="form-note"> This deposit is <strong>20% of the total reservation cost</strong> and must be paid to <strong>secure your booking.</strong></p>
                                    <input type="hidden" id="deposit-amount" name="deposit_amount" value="0" />
                                </div>
                                <div>
                                    <p class="form-details"> Remaining Balance Upon Check-In: <span id="remaining-balance" class="form-price">Php 0.00</span></p>
                                    <p class="form-note"> The price listed above shows the <strong> remaining balance of your reservation.</strong> The remaining balance will be <strong> due upon check-in.</strong></p>
                                    <input type="hidden" id="remaining-balance-hidden" name="remaining_balance" value="0" />
                                </div>
                            </div>

                            <div class="form-group-payment-method">
                                <div class="u-margin-bottom-md">
                                    <h4 class="form-heading-payment">Payment Method<span class="form-required">*</span></h4>
                                    <p class="form-note u-margin-bottom-sm"><strong>Scan the QR code to pay the 20% deposit amount.</strong> This will confirm your booking.</p>

                                    <div class="form-payment-option">
                                        <input type="radio" id="bdo" name="payment_method" value="BDO" onclick="showQRCode('bdo')" /><label for="bdo" class="form-label-inline">BDO</label>
                                    </div>

                                    <div id="qr-code-section">
                                        <div id="bdo-qr" class="qr-code-container" style="display: none">
                                            <img src="images/bdo-qr.png" alt="BDO QR Code" class="qr-code-image" />
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="form-heading-payment">Payment Verification<span class="form-required">*</span></h4>
                                    <p class="form-note u-margin-bottom-sm">Upload an image of your proof of payment for verification after scanning the QR code. Please ensure the file name is <strong>Fullname_Proof_of_Payment_Date.</strong> Allowed formats are <strong>jpg, jpeg, or png.</strong>> </p>

                                    <div class="form-input-group">
                                        <label for="proof-of-payment" class="form-label">Upload Payment Confirmation<span class="form-required">*</span></label>
                                        <input type="file" id="proof-of-payment" name="proof_of_payment" accept="image/*" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-input-group u-margin-bottom-md">
                            <h4 class="form-heading-payment">Terms and Conditions <span class="form-required">*</span></h4>
                            <p class="form-note u-margin-bottom-sm">Before proceeding with your reservation, please carefully <strong>review our terms and conditions.</strong> Your agreement to these terms is required for completing the booking process.</p>
                            <input type="checkbox" id="termsAgree" name="agree" required />
                            <label for="termsAgree" class="form-label-inline">I have read and agree with the<span class="terms-link" id="termsLink">Terms and Conditions</span></label>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Reservation</button>
                    </div>
                </form>
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

    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Terms and Conditions</h2>
            <p>These terms and conditions govern your use of our resort and residences. By making a reservation or using our services, you agree to these terms.</p>
            <ul>
                <li><strong>General Information</strong></li>
                <ul>
                    <li>These terms and conditions apply to all guests and visitors of the resort.</li>
                    <li>No smoking is allowed in rooms or public areas. Smoking violations will incur a cleaning fee.</li>
                    <li>We reserve the right to modify these terms at any time. Changes will be communicated through the contact details provided.</li>
                </ul>

                <li><strong>Reservation Policies</strong></li>
                <ul>
                    <li>All reservations must be guaranteed with a valid payment method.</li>
                    <li>Rates and availability are subject to change. Prices confirmed at the time of booking are final.</li>
                    <li>Your reservation is confirmed once you receive a confirmation email. Ensure your email address is correct.</li>
                    <li>A non-refundable deposit of 15% of the total reservation amount is required. The balance is due at the time of use or check-in.</li>
                    <li>Maximum occupancy as specified at booking. Additional users may incur extra charges.</li>
                </ul>

                <li><strong>Cancellation and Changes</strong></li>
                <ul>
                    <li>Cancellations must be made at least 7 days before the scheduled arrival date to receive a full refund, minus any applicable fees.</li>
                    <li>Cancellations within 7 days of the scheduled arrival date will incur a cancellation fee equal to the first night’s stay.</li>
                    <li>Cancellations made within 3 days of the reservation will forfeit the deposit. Changes are subject to availability and may incur additional charges.</li>
                    <li>Requests for extension are subject to availability and extra charges.</li>
                </ul>

                <li><strong>Payment Methods</strong></li>
                <ul>
                    <li>Payments can be made via GCash, BDO, and BPI.</li>
                </ul>

                <li><strong>Liability and Responsibility</strong></li>
                <ul>
                    <li>The resort is not responsible for any personal belongings lost or damaged during your stay.</li>
                    <li>Guests are responsible for any damage caused to the hotel property during their stay. The cost of repairs or replacements will be charged to the guest.</li>
                    <li>Lost items are not the resort’s responsibility. Please use the in-room safe for valuables.</li>
                </ul>

                <li><strong>Reservation Use</strong></li>
                <ul>
                    <li>Arrive on time to fully utilize your reserved slot. Late arrivals may have their time reduced.</li>
                    <li>No pets are allowed in the amenities area.</li>
                </ul>
            </ul>

            <input type="checkbox" id="modalAgree" name="modalAgree" required>
            <label for="modalAgree">I have read and agree with the Terms and Conditions</label>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="js/script.js"></script>
    <?php include('js/amenitiesReservation.php');?>
</body>

</html>