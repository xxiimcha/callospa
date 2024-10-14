<?php

include 'callospa_resort_database.php';

$title = "Callospa Resort";

$mainHeader = "CALLOSPA";
$subHeader = "Resort";

$mainTitle = "ROOM RESERVATION FORM";
$subTitle = "Easily book your stay with us by filling out the form below. Select your desired room, check-in and check-out dates, and provide your details to secure your reservation.";

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

$query = "SELECT id, room_name, subcategory_rooms, price, description, inclusions, guests, `room-images`
          FROM rooms";

$result = $conn->query($query);

$rooms = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!isset($rooms[$row['room_name']])) {
            $rooms[$row['room_name']] = [
                'subcategory_rooms' => [],
            ];
        }

        if (!empty($row['subcategory_rooms'])) {
            $rooms[$row['room_name']]['subcategory_rooms'][$row['subcategory_rooms']] = [
                'price' => $row['price'],
                'description' => $row['description'],
                'guests' => $row['guests'],
                'room-images' => $row['room-images'],
                'inclusions' => $row['inclusions'],
            ];
        } else {
            $rooms[$row['room_name']]['price'] = $row['price'];
            $rooms[$row['room_name']]['description'] = $row['description'];
            $rooms[$row['room_name']]['guests'] = $row['guests'];
            $rooms[$row['room_name']]['room-images'] = $row['room-images'];
            $rooms[$row['room_name']]['inclusions'] = $row['inclusions'];
        }
    }
}

$conn->close();
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
    <title>Callospa Resort - Room Reservation Form</title>
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
                            $isActive = (basename($link) == $currentPage || ($currentPage == 'RoomReservationForm.php' && basename($link) == 'RoomsPage.php')) ? 'active' : '';
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
        <section class="section-hero section-hero--room-form">
            <header class="header--hero">
                <h1 class="heading heading-primary u-margin-bottom-md"><?php echo htmlspecialchars($mainTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="u-margin-bottom-xl"><?php echo htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>
        </section>

        <div class="section section">
            <div class="u-container">
                <form action="SubmitRoomReservation.php" method="POST" enctype="multipart/form-data" class="form">
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
                            <div class="form-input-group"><label for="room" class="form-label">Select Room <span class="form-required">*</span></label>
                                <select id="room" name="room" class="form-input" required onchange="showRoomDetails()">
                                    <option value="" disabled selected>Select a room</option>
                                    <?php foreach ($rooms as $roomName => $details): ?>
                                        <?php if (!empty($details['subcategory_rooms'])): ?>
                                            <optgroup label="<?php echo htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php foreach ($details['subcategory_rooms'] as $subRoomName => $subRoomDetails): ?>
                                                    <option value="<?php echo htmlspecialchars($subRoomName, ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-guests="<?php echo htmlspecialchars($subRoomDetails['guests'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-price="<?php echo htmlspecialchars($subRoomDetails['price'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-description="<?php echo htmlspecialchars($subRoomDetails['description'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-inclusions="<?php echo htmlspecialchars($subRoomDetails['inclusions'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        data-images="<?php echo htmlspecialchars($subRoomDetails['room-images'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        <?php echo htmlspecialchars($subRoomName, ENT_QUOTES, 'UTF-8'); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>

                                        <?php else: ?>
                                            <option value="<?php echo htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8'); ?>"
                                                data-guests="<?php echo htmlspecialchars($details['guests'], ENT_QUOTES, 'UTF-8'); ?>"
                                                data-price="<?php echo htmlspecialchars($details['price'], ENT_QUOTES, 'UTF-8'); ?>"
                                                data-description="<?php echo htmlspecialchars($details['description'], ENT_QUOTES, 'UTF-8'); ?>"
                                                data-inclusions="<?php echo htmlspecialchars($details['inclusions'], ENT_QUOTES, 'UTF-8'); ?>"
                                                data-images="<?php echo htmlspecialchars($details['room-images'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div id="room-details" class="dropdown-details">
                            <div id="room-images" class="dropdown-images"></div>
                            <div class="dropdown-body">
                                <p class="dropdown-description"><span class="dropdown-label">Price: </span><span id="room-price"></span></p>
                                <p class="dropdown-description"><span class="dropdown-label">Description: </span><span id="room-description"></span></p>
                                <p class="dropdown-description"><span class="dropdown-label">Inclusions: </span><span id="room-inclusions"></span></p>
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="check-in-date" class="form-label">Check-In Date <span class="form-required">*</span></label>
                                <input type="text" id="check-in-date" name="check_in_date" required onchange="calculateTotalCost()" class="form-input" placeholder="Enter Check-In Date" />
                            </div>

                            <div class="form-input-group">
                                <label for="check-out-date" class="form-label">Check-Out Date <span class="form-required">*</span></label>
                                <input type="text" id="check-out-date" name="check_out_date" required onchange="calculateTotalCost()" class="form-input" placeholder="Enter Check-Out Date" />
                            </div>
                        </div>

                        <div class="form-row u-margin-bottom-md">
                            <div class="form-input-group">
                                <label for="check-in-time" class="form-label">Check-In Time</label>
                                <input type="time" id="check-in-time" name="check_in_time" class="form-input" readonly />
                            </div>

                            <div class="form-input-group">
                                <label for="check-out-time" class="form-label">Check-Out Time:</label>
                                <input type="time" id="check-out-time" name="check_out_time" class="form-input" readonly />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-input-group">
                                <label for="guests" class="form-label">Number of Guests:</label>
                                <input type="number" id="guests" name="guests" min="1" class="form-input" readonly required />
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
                                    <h4 class="form-heading-payment">Payment Method</h4>
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
                                    <h4 class="form-heading-payment">Payment Verification</h4>
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
                            <label for="termsAgree" class="form-label-inline">I have read and agree with the <span class="terms-link" id="termsLink">Terms and Conditions</span></label>
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

            <div class="terms-section">
                <h3>General Information</h3>
                <ul>
                    <li>These terms and conditions apply to all guests and visitors of the resort.</li>
                    <li>The resort is not responsible for any personal belongings lost or damaged during your stay.</li>
                    <li>Guests are liable for any damage to the property or furnishings.</li>
                    <li>No smoking is allowed in rooms or public areas. Smoking violations will incur a cleaning fee.</li>
                    <li>We reserve the right to modify these terms at any time. Changes will be communicated through the contact details provided.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>Room Reservation Policies</h3>
                <ul>
                    <li>All reservations must be guaranteed with a valid payment method.</li>
                    <li>Rates and availability are subject to change. Prices confirmed at the time of booking are final.</li>
                    <li>A confirmation email will be sent upon successful booking. Please verify the details and contact us if any discrepancies are found.</li>
                    <li>A non-refundable deposit of 20% of the total room rate is required to secure the booking. The remaining balance is due upon check-in.</li>
                    <li>Cancellations must be made at least 7 days before the check-in date to receive a full refund, minus the non-refundable deposit. Cancellations within 7 days will forfeit the deposit.</li>
                    <li>Changes to your reservation, including date or room type adjustments, are subject to availability and may incur additional charges.</li>
                    <li>Failure to arrive on the scheduled date will result in a charge for the first night and cancellation of the remaining reservation.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>Payment</h3>
                <ul>
                    <li>Payment is accepted via GCash, BDO, and BPI.</li>
                </ul>
            </div>

            <div class="agreement">
                <input type="checkbox" id="modalAgree" name="modalAgree" required>
                <label for="modalAgree">I have read and agree with the Terms and Conditions</label>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="js/script.js"></script>
    <script>
        // Show Room Details Function
        function showRoomDetails() {
            const roomSelect = document.getElementById('room');
            const roomImages = document.getElementById('room-images');
            const roomPrice = document.getElementById('room-price');
            const roomDescription = document.getElementById('room-description');
            const roomInclusions = document.getElementById('room-inclusions');
            const roomDetails = document.getElementById('room-details');
            const selectedRoomOption = roomSelect.selectedOptions[0];

            if (selectedRoomOption && selectedRoomOption.value !== "") {
                const price = selectedRoomOption.getAttribute('data-price');
                const description = selectedRoomOption.getAttribute('data-description');
                const inclusions = selectedRoomOption.getAttribute('data-inclusions');
                const images = selectedRoomOption.getAttribute('data-images');

                roomImages.innerHTML = '';

                if (images) {
                    const imageArray = images.split(',');
                    imageArray.forEach(function(image) {
                        const img = document.createElement('img');
                        img.src = image.trim();
                        img.alt = 'Room Image';
                        roomImages.appendChild(img);
                    });
                }

                roomPrice.textContent = 'Php ' + price;
                roomDescription.textContent = description;
                roomInclusions.textContent = inclusions;

                roomDetails.style.display = 'block';
            } else {
                roomDetails.style.display = 'none';
            }
        }

        // Disable Dates and Checks Availability Function
        document.addEventListener('DOMContentLoaded', function() {
            const checkInDateInput = document.getElementById('check-in-date');
            const checkOutDateInput = document.getElementById('check-out-date');
            const roomSelect = document.getElementById('room');
            const today = new Date().toISOString().split('T')[0];

            const checkInFlatpickr = flatpickr(checkInDateInput, {
                dateFormat: "Y-m-d",
                minDate: today,
                disable: [],
                onChange: function() {
                    checkAvailability();
                }
            });

            const checkOutFlatpickr = flatpickr(checkOutDateInput, {
                dateFormat: "Y-m-d",
                minDate: today,
                disable: [],
                onChange: function() {
                    checkAvailability();
                }
            });

            function checkAvailability() {
                const selectedRoomOption = roomSelect.selectedOptions[0];

                if (!selectedRoomOption || selectedRoomOption.value === "") {
                    return;
                }

                const selectedRoom = selectedRoomOption.value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_roomsAvailability.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        const formattedBookedDates = response.bookedDates.map(date => new Date(date).toISOString().split('T')[0]);
                        const allDisabledDates = formattedBookedDates;

                        checkInFlatpickr.set('disable', allDisabledDates);
                        checkOutFlatpickr.set('disable', allDisabledDates);
                    }
                };

                xhr.send(`room=${encodeURIComponent(selectedRoom)}`);
            }

            roomSelect.addEventListener('change', function() {
                checkAvailability();
                showRoomDetails();
            });
        });

        // Number of Guest Function
        function updateGuestCount() {
            const roomSelect = document.getElementById('room');
            const guestInput = document.getElementById('guests');
            const roomsData = <?php echo json_encode($rooms); ?>;

            let room = null;

            if (roomSelect.selectedOptions[0].parentElement.label) {
                const subRoomName = roomSelect.value;
                const mainRoomName = roomSelect.selectedOptions[0].parentElement.label;
                room = roomsData[mainRoomName]['subcategory_rooms'][subRoomName];
            } else {
                room = roomsData[roomSelect.value];
            }

            if (room) {
                guestInput.value = room.guests;
            } else {
                guestInput.value = "";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateGuestCount();
            showRoomDetails();
        });

        document.getElementById('room').addEventListener('change', function() {
            updateGuestCount();
            calculateTotalCost();
        });

        // Check-In and Check-Out Function
        document.addEventListener("DOMContentLoaded", function() {
            const checkInDateInput = document.getElementById("check-in-date");
            const checkOutDateInput = document.getElementById("check-out-date");
            const checkInTimeInput = document.getElementById("check-in-time");
            const checkOutTimeInput = document.getElementById("check-out-time");

            const defaultCheckInTime = "13:00";
            const defaultCheckOutTime = "10:00";

            function updateTimes() {
                if (checkInDateInput.value && checkOutDateInput.value) {
                    const checkInDate = new Date(checkInDateInput.value);
                    const checkOutDate = new Date(checkInDate.getTime() + (24 * 60 * 60 * 1000));

                    checkInTimeInput.value = defaultCheckInTime;
                    checkOutDateInput.value = checkOutDate.toISOString().split('T')[0];
                    checkOutTimeInput.value = defaultCheckOutTime;
                } else {
                    checkInTimeInput.value = "";
                    checkOutTimeInput.value = "";
                }
            }

            checkInDateInput.addEventListener("change", updateTimes);
            checkOutDateInput.addEventListener("change", updateTimes);
        });


        // Total Cost Function
        function calculateTotalCost() {
            const roomSelect = document.getElementById('room');
            const checkInDate = document.getElementById('check-in-date').value;
            const checkOutDate = document.getElementById('check-out-date').value;
            const guestInput = document.getElementById('guests');
            const additionalGuestsInput = document.getElementById('additional_guest');
            const totalCostElement = document.getElementById('total-cost');
            const totalCostHidden = document.getElementById('total-cost-hidden');
            const discountElement = document.getElementById('discount-amount');
            const depositHidden = document.getElementById('deposit-amount');
            const remainingBalanceElement = document.getElementById('remaining-balance');
            const remainingBalanceHidden = document.getElementById('remaining-balance-hidden');

            const roomsData = <?php echo json_encode($rooms); ?>;
            let room = null;

            const selectedRoomOption = roomSelect.selectedOptions[0];

            if (selectedRoomOption && selectedRoomOption.value !== "") {
                const selectedRoom = selectedRoomOption.value;

                if (selectedRoomOption.parentElement.label) {
                    const subRoomName = selectedRoom;
                    const mainRoomName = selectedRoomOption.parentElement.label;
                    room = roomsData[mainRoomName]['subcategory_rooms'][subRoomName];
                } else {
                    room = roomsData[selectedRoom];
                }
            }

            if (room && checkInDate && checkOutDate) {
                const roomPrice = parseFloat(room.price.replace(/[₱,]/g, ''));
                const additionalChargePerGuest = 250;

                const guestCount = parseInt(guestInput.value, 10) || 0;
                const additionalGuests = parseInt(additionalGuestsInput.value, 10) || 0;

                const checkIn = new Date(checkInDate);
                const checkOut = new Date(checkOutDate);

                if (checkOut <= checkIn) {
                    resetCostDisplay(totalCostElement, totalCostHidden, discountElement, depositHidden, remainingBalanceElement, remainingBalanceHidden);
                    return;
                }

                const duration = (checkOut - checkIn) / (1000 * 60 * 60 * 24);

                if (duration > 0) {
                    const totalGuests = guestCount + additionalGuests;
                    const additionalCharges = additionalGuests * additionalChargePerGuest;
                    const totalCost = (roomPrice * duration) + additionalCharges;

                    const discountAmount = totalCost * 0.20;
                    const remainingBalance = totalCost - discountAmount;

                    displayCost(totalCost, totalCostElement, totalCostHidden, discountAmount, discountElement, depositHidden, remainingBalance, remainingBalanceElement, remainingBalanceHidden);
                } else {
                    resetCostDisplay(totalCostElement, totalCostHidden, discountElement, depositHidden, remainingBalanceElement, remainingBalanceHidden);
                }
            } else {
                resetCostDisplay(totalCostElement, totalCostHidden, discountElement, depositHidden, remainingBalanceElement, remainingBalanceHidden);
            }
        }

        function resetCostDisplay(totalCostElement, totalCostHidden, discountElement, depositHidden, remainingBalanceElement, remainingBalanceHidden) {
            totalCostElement.textContent = "₱0.00";
            totalCostHidden.value = 0;
            discountElement.textContent = "₱0.00";
            depositHidden.value = 0;
            remainingBalanceElement.textContent = "₱0.00";
            remainingBalanceHidden.value = 0;
        }

        function displayCost(totalCost, totalCostElement, totalCostHidden, discountAmount, discountElement, depositHidden, remainingBalance, remainingBalanceElement, remainingBalanceHidden) {
            totalCostElement.textContent = `₱${totalCost.toLocaleString()}.00`;
            totalCostHidden.value = totalCost;
            discountElement.textContent = `₱${discountAmount.toLocaleString()}.00`;
            depositHidden.value = discountAmount;
            remainingBalanceElement.textContent = `₱${remainingBalance.toLocaleString()}.00`;
            remainingBalanceHidden.value = remainingBalance;
        }

        document.getElementById('room').addEventListener('change', function() {
            showRoomDetails();
            calculateTotalCost();
        });
        document.getElementById('guests').addEventListener('input', calculateTotalCost);
        document.getElementById('additional_guest').addEventListener('input', calculateTotalCost);
        document.getElementById('check-in-date').addEventListener('change', calculateTotalCost);
        document.getElementById('check-out-date').addEventListener('change', calculateTotalCost);


        // Show QR Code Function
        function showQRCode(method) {
            document.querySelectorAll('.qr-code-container').forEach(container => container.style.display = 'none');
            const qrCodeSection = document.getElementById(`${method}-qr`);
            if (qrCodeSection) {
                qrCodeSection.style.display = 'block';
            }
        }

        // Modal Functions
        document.addEventListener('DOMContentLoaded', function() {
            const termsLink = document.getElementById('termsLink');
            const termsModal = document.getElementById('termsModal');
            const closeModal = document.getElementById('closeModal');
            const termsCheckbox = document.getElementById('termsAgree');
            const modalCheckbox = document.getElementById('modalAgree');

            termsCheckbox.disabled = true;

            termsLink.addEventListener('click', function() {
                termsModal.style.display = 'flex';
            });

            closeModal.addEventListener('click', function() {
                termsModal.style.display = 'none';
            });

            modalCheckbox.addEventListener('change', function() {
                if (modalCheckbox.checked) {
                    termsCheckbox.checked = true;
                    termsCheckbox.disabled = false;
                    termsModal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>