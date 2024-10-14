<script>
const bookedDates = <?php echo $disabledDatesJSON; ?>;

function disableUnavailableDates(selectedPackage) {
    let disabledDates = [];

    // This function adds booked dates for a specific package to the disabledDates array
    function addDisabledDatesForPackage(package) {
        if (package in bookedDates) {
            bookedDates[package].forEach(event => {
                let startDate = new Date(event.check_in);
                let endDate = new Date(event.check_out);

                // Add each date in the range between check-in and check-out to disabledDates array
                while (startDate <= endDate) {
                    disabledDates.push(startDate.toISOString().split('T')[0]);  // Convert date to YYYY-MM-DD format
                    startDate.setDate(startDate.getDate() + 1);  // Move to the next day
                }
            });
        }
    }

    // Always disable dates for the selected package only if there are actual bookings for the selected package
    addDisabledDatesForPackage(selectedPackage);

    // Check for related packages based on the selected package only if those packages have bookings
    if (selectedPackage === 'Day Resort Grounds Exclusive') {
        // Disable dates for all related packages for 'Day Resort Grounds Exclusive'
        addDisabledDatesForPackage('1 Day with Reception Hall');
        addDisabledDatesForPackage('24-Hour with Reception Hall');
        addDisabledDatesForPackage('1 Day with Conference Room');
        addDisabledDatesForPackage('24-Hour with Conference Room');
    } else if (selectedPackage === '1 Day with Reception Hall' || 
            selectedPackage === '24-Hour with Reception Hall' ||
            selectedPackage === '1 Day with Conference Room' || 
            selectedPackage === '24-Hour with Conference Room') {
        // Disable dates for 'Day Resort Grounds Exclusive' and 'Night Resort Grounds Exclusive' if there are bookings for them
        addDisabledDatesForPackage('Day Resort Grounds Exclusive');
    } else if (selectedPackage === 'Night Resort Grounds Exclusive') {
        // Disable dates for 'Day Resort Grounds Exclusive' and its related packages if they have bookings
        addDisabledDatesForPackage('Day Resort Grounds Exclusive');
        addDisabledDatesForPackage('1 Day with Reception Hall');
        addDisabledDatesForPackage('24-Hour with Reception Hall');
        addDisabledDatesForPackage('1 Day with Conference Room');
        addDisabledDatesForPackage('24-Hour with Conference Room');
    }

    // Apply the disabled dates to the Flatpickr calendar
    flatpickr("#check-in-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: disabledDates
    });

    flatpickr("#check-out-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: disabledDates
    });
}

// Add event listener to the package dropdown
document.getElementById('package').addEventListener('change', function() {
    const selectedPackage = this.value;
    disableUnavailableDates(selectedPackage);
});

// Update Package Options Function
function updatePackageOptions() {
    const category = document.getElementById('package-category').value;
    const packageSelect = document.getElementById('package');
    const packages = <?php echo json_encode($packages); ?>;

    const fieldsToClear = ['package-price', 'package-duration', 'package-description', 'package-inclusions', 'package-images'];

    const clearFields = () => fieldsToClear.forEach(id => {
        const element = document.getElementById(id);
        if (id === 'package-images') {
            element.innerHTML = '';
        } else {
            element.innerText = '';
        }
    });

    packageSelect.innerHTML = '<option value="">Select Event Type</option>';
    clearFields();

    if (category && packages[category]) {
        Object.keys(packages[category]['events']).forEach(eventType => {
            const option = document.createElement('option');
            option.value = eventType;
            option.textContent = eventType;
            packageSelect.appendChild(option);
        });
    }
}

// Update Package Details Function
function updatePackageDetails() {
    const category = document.getElementById('package-category').value;
    const eventType = document.getElementById('package').value;
    const packageDetails = document.getElementById('package-details');

    const packages = <?php echo json_encode($packages); ?>;

    if (category && eventType) {
        const selectedPackage = packages[category]['events'][eventType];

        document.getElementById('package-price').innerText = selectedPackage.price;
        document.getElementById('package-duration').innerText = selectedPackage.duration;
        document.getElementById('package-description').innerText = selectedPackage.description;
        document.getElementById('package-inclusions').innerText = selectedPackage.inclusions;
        document.getElementById('check-in-time').value = formatTimeForInput(selectedPackage.check_in_time);
        document.getElementById('check-out-time').value = formatTimeForInput(selectedPackage.check_out_time);
        document.getElementById('guests').value = selectedPackage.guests || '';

        const imagesDiv = document.getElementById('package-images');
        imagesDiv.innerHTML = '';
        if (selectedPackage.images && selectedPackage.images.length > 0) {
            selectedPackage.images.forEach(function(image) {
                const imgElement = document.createElement('img');
                imgElement.src = image;
                imgElement.alt = eventType + ' image';
                imagesDiv.appendChild(imgElement);
            });
        }
        packageDetails.style.display = 'block';


        calculateTotalCost();
    } else {
        clearFields();
        document.getElementById('check-in-time').value = '';
        document.getElementById('check-out-time').value = '';
        document.getElementById('guests').value = '';
        document.getElementById('total-cost').textContent = '₱0.00';
        document.getElementById('discount-amount').textContent = '₱0.00';
        document.getElementById('remaining-balance').textContent = '₱0.00';

        packageDetails.style.display = 'none';
    }
}

document.getElementById('package-category').addEventListener('change', updatePackageOptions);
document.getElementById('package').addEventListener('change', updatePackageDetails);

// Check In and Check Out Date Function
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const formattedToday = today.toISOString().split('T')[0];

    // Initialize Flatpickr for check-in date
    flatpickr("#check-in-date", {
        dateFormat: "Y-m-d",
        minDate: formattedToday,
        onChange: function(selectedDates, dateStr, instance) {
            calculateTotalCost();
        }
    });

    // Initialize Flatpickr for check-out date
    flatpickr("#check-out-date", {
        dateFormat: "Y-m-d",
        minDate: formattedToday,
        onChange: function(selectedDates, dateStr, instance) {
            calculateTotalCost();
        }
    });
});


// Helper function to format time into HH:MM
function formatTimeForInput(timeString) {
    if (!timeString) return '00:00';
    const [hours, minutes] = timeString.split(':').map(Number);
    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
}

// Calculate Total Cost Function
function calculateTotalCost() {
    const selectedPackage = document.getElementById('package').value;
    const checkInDate = new Date(document.getElementById('check-in-date').value);
    const checkOutDate = new Date(document.getElementById('check-out-date').value);
    const additionalGuests = parseInt(document.getElementById('additional_guest').value) || 0;

    if (!selectedPackage || isNaN(checkInDate) || isNaN(checkOutDate)) return;

    const packages = <?php echo json_encode($packages); ?>;
    const packageCategory = document.getElementById('package-category').value;

    if (packages[packageCategory] && packages[packageCategory]['events']) {
        const selectedPkg = packages[packageCategory]['events'][selectedPackage];

        if (!selectedPkg) return;

        const packagePrice = parseInt(selectedPkg.price.replace('₱ ', '').replace(',', ''));

        const days = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
        const additionalGuestCost = additionalGuests * 250;
        const totalCost = (packagePrice * days) + additionalGuestCost;

        const depositAmount = totalCost * 0.25;
        const remainingBalance = totalCost - depositAmount;

        document.getElementById('total-cost').textContent = `₱${totalCost.toLocaleString()}`;
        document.getElementById('discount-amount').textContent = `₱${depositAmount.toLocaleString()}`;
        document.getElementById('remaining-balance').textContent = `₱${remainingBalance.toLocaleString()}`;

        document.getElementById('total-cost-hidden').value = totalCost;
        document.getElementById('deposit-amount').value = depositAmount;
        document.getElementById('remaining-balance-hidden').value = remainingBalance;
    }
}

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

    termsLink.addEventListener('click', () => termsModal.style.display = 'flex');
    closeModal.addEventListener('click', () => termsModal.style.display = 'none');

    modalCheckbox.addEventListener('change', function() {
        if (modalCheckbox.checked) {
            termsCheckbox.checked = true;
            termsCheckbox.disabled = false;
            termsModal.style.display = 'none';
        }
    });
    ['guests', 'additional_guest', 'check-in-date', 'check-out-date'].forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            calculateTotalCost();
        });
    });
});
</script>