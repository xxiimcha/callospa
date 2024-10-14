<script>
// Disable Dates Function
const packages = <?php echo json_encode($packageData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

document.addEventListener('DOMContentLoaded', function() {
    const checkInDateInput = document.getElementById('check-in-date');
    const checkOutDateInput = document.getElementById('check-out-date');
    const packageSelect = document.getElementById('package');

    // Initialize flatpickr for check-in and check-out date inputs
    const checkInFlatpickr = flatpickr(checkInDateInput, {
        dateFormat: "Y-m-d",
        minDate: new Date(),
        disable: []
    });

    const checkOutFlatpickr = flatpickr(checkOutDateInput, {
        dateFormat: "Y-m-d",
        minDate: new Date(),
        disable: []
    });

    // Function to check availability and disable dates
    function checkAvailability() {
        const selectedPackage = packageSelect.value;

        if (!selectedPackage) {
            console.log('Please select a package.');
            return;
        }

        console.log(`Checking availability for package: ${selectedPackage}`);

        // AJAX request to check availability and fetch booked dates
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_packagesAvailability.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log('Response from server:', response);

                const bookedDates = response.bookedDates.map(date => new Date(date)); // Convert to Date objects

                // Disable the booked dates in flatpickr
                checkInFlatpickr.set('disable', bookedDates);
                checkOutFlatpickr.set('disable', bookedDates);
            }
        };
        xhr.send(`package=${encodeURIComponent(selectedPackage)}`);
    }

    // Trigger check availability when package is changed
    packageSelect.addEventListener('change', function() {
        checkAvailability();
    });
});

// Show Package Details Function
function showPackageDetails() {
    const packageSelect = document.getElementById('package');
    const packageDetails = document.getElementById('package-details');
    const option = packageSelect.querySelector(`option[value="${packageSelect.value}"]`);

    if (option) {
        const imagesData = option.getAttribute('data-images');
        const roomNames = option.getAttribute('data-room-names');
        const packageImages = document.getElementById('package-images');

        console.log(`Selected Package: ${option.value}, Room Names: ${roomNames}`);

        if (imagesData && imagesData !== 'null') { // Ensure images data is valid
            const images = JSON.parse(imagesData);

            if (Array.isArray(images)) {
                console.log('Package Images:', images);
                packageImages.innerHTML = images.map(image => `<img src="${image}" alt="Package Image" style="width: 300px; height: auto;">`).join('');
            } else {
                console.log('Images data is not an array:', images);
            }
        } else {
            console.log('No images data found for the selected package');
            packageImages.innerHTML = '';
        }

        document.getElementById('package-price').textContent = 'Price: Php' + option.getAttribute('data-price');
        document.getElementById('package-description').innerHTML = 'Room Names: ' + roomNames;
        packageDetails.style.display = 'block';
    } else {
        packageDetails.style.display = 'none';
    }
}

// Update Guest Count Function
function updateGuestCount() {
    const packageSelect = document.getElementById('package');
    const guestInput = document.getElementById('guests');
    const option = packageSelect.querySelector(`option[value="${packageSelect.value}"]`);

    if (option) {
        const guests = option.getAttribute('data-guests');
        console.log(`Setting guest count to: ${guests}`);
        guestInput.value = guests;
    } else {
        guestInput.value = '';
    }
}

// Update Check-In and Check-Out Times Function
function updateTimes() {
    const packageSelect = document.getElementById('package');
    const checkInDateInput = document.getElementById("check-in-date");
    const checkOutDateInput = document.getElementById("check-out-date");
    const checkInTimeInput = document.getElementById("check-in-time");
    const checkOutTimeInput = document.getElementById("check-out-time");

    const selectedPackageName = packageSelect.value;
    const selectedPackage = packages.find(pkg => pkg.package_name === selectedPackageName);

    if (selectedPackage) {
        console.log(`Selected Package: ${selectedPackageName}, Setting Check-In/Check-Out Times`);
        checkInTimeInput.value = checkInDateInput.value ? selectedPackage.checkInTime : '';
        checkOutTimeInput.value = checkOutDateInput.value ? selectedPackage.checkOutTime : '';
        checkInTimeInput.readOnly = !checkInDateInput.value;
        checkOutTimeInput.readOnly = !checkOutDateInput.value;
    } else {
        console.log('No selected package found for updating times.');
        checkInTimeInput.value = '';
        checkOutTimeInput.value = '';
        checkInTimeInput.readOnly = false;
        checkOutTimeInput.readOnly = false;
    }
}

// Calculate Total Cost Function
function calculateTotalCost() {
    const packageSelect = document.getElementById('package');
    const checkInDate = document.getElementById('check-in-date').value;
    const checkOutDate = document.getElementById('check-out-date').value;
    const guestInput = document.getElementById('guests');
    const additionalGuestsInput = document.getElementById('additional_guest');

    const selectedPackageName = packageSelect.value;
    const selectedPackage = packages.find(pkg => pkg.package_name === selectedPackageName);

    if (selectedPackage && checkInDate && checkOutDate) {
        const packagePrice = selectedPackage.price;
        const guestCount = parseInt(guestInput.value, 10) || selectedPackage.guests;
        const additionalGuests = parseInt(additionalGuestsInput.value, 10) || 0;
        const additionalChargePerGuest = 250;

        const duration = (new Date(checkOutDate) - new Date(checkInDate)) / (1000 * 60 * 60 * 24);
        if (duration > 0) {
            const totalGuests = guestCount + additionalGuests;
            const additionalCharges = additionalGuests * additionalChargePerGuest;
            const totalCost = (packagePrice * duration) + additionalCharges;

            const discountAmount = totalCost * 0.20;
            const remainingBalance = totalCost - discountAmount;

            console.log(`Total Cost: Php${totalCost.toLocaleString()}, Deposit: Php${discountAmount.toLocaleString()}, Remaining Balance: Php${remainingBalance.toLocaleString()}`);

            document.getElementById('total-cost').textContent = `Php${totalCost.toLocaleString()}.00`;
            document.getElementById('total-cost-hidden').value = totalCost;
            document.getElementById('discount-amount').textContent = `Php${discountAmount.toLocaleString()}.00`;
            document.getElementById('deposit-amount').value = discountAmount;
            document.getElementById('remaining-balance').textContent = `Php${remainingBalance.toLocaleString()}.00`;
            document.getElementById('remaining-balance-hidden').value = remainingBalance;
        } else {
            resetCostFields();
        }
    } else {
        resetCostFields();
    }
}

// Reset Cost Fields Function
function resetCostFields() {
    console.log('Resetting cost fields...');
    document.getElementById('total-cost').textContent = "Php0.00";
    document.getElementById('total-cost-hidden').value = 0;
    document.getElementById('discount-amount').textContent = "Php0.00";
    document.getElementById('deposit-amount').value = 0;
    document.getElementById('remaining-balance').textContent = "Php0.00";
    document.getElementById('remaining-balance-hidden').value = 0;
}

// Show QR Code Function
function showQRCode(method) {
    console.log(`Showing QR code for payment method: ${method}`);
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

    termsLink.addEventListener('click', () => {
        console.log('Opening terms modal');
        termsModal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        console.log('Closing terms modal');
        termsModal.style.display = 'none';
    });

    modalCheckbox.addEventListener('change', function() {
        if (modalCheckbox.checked) {
            console.log('Terms agreed, enabling final checkbox');
            termsCheckbox.checked = true;
            termsCheckbox.disabled = false;
            termsModal.style.display = 'none';
        }
    });

    // Event listeners to update the form dynamically
    ['package', 'guests', 'additional_guest', 'check-in-date', 'check-out-date'].forEach(id => {
        document.getElementById(id).addEventListener('change', () => {
            showPackageDetails();
            updateGuestCount();
            updateTimes();
            calculateTotalCost();
        });
    });
});
</script>
