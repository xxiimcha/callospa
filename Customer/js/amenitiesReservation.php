<script>
    const amenities = <?php echo json_encode($amenities); ?>;

    // Update Package Options Function
    function updatePackageOptions() {
        console.log("Package Category Changed:", document.getElementById('package-category').value);
        const category = document.getElementById('package-category').value;
        const packageSelect = document.getElementById('package');
        packageSelect.innerHTML = '<option value="">Select Package</option>';

        if (category && amenities[category]) {
            amenities[category].forEach(packageDetail => {
                const option = document.createElement('option');
                option.value = packageDetail.name;
                option.textContent = packageDetail.name;
                packageSelect.appendChild(option);
            });
        }
        updatePackageDetails();
    }

    // Update Package Details Function 
    function updatePackageDetails() {
        const category = document.getElementById('package-category').value;
        const packageName = document.getElementById('package').value;

        console.log("Updating Package Details for:", category, packageName);

        const priceSpan = document.getElementById('package-price');
        const durationSpan = document.getElementById('package-duration');
        const descriptionSpan = document.getElementById('package-description');
        const packageImages = document.getElementById('package-images');
        const packageDetailsContainer = document.getElementById('package-details');

        if (category && packageName && amenities[category]) {
            const packageDetails = amenities[category].find(subcategory => subcategory.name === packageName);

            if (packageDetails) {
                console.log("Package Details Found:", packageDetails);
                priceSpan.textContent = packageDetails.price;
                durationSpan.textContent = packageDetails.duration;
                descriptionSpan.textContent = packageDetails.description;

                packageImages.innerHTML = ''; // Clear previous images

                if (packageDetails.image_url) {
                    const imageArray = packageDetails.image_url.split(',');
                    imageArray.forEach(function(image) {
                        const img = document.createElement('img');
                        img.src = image.trim();
                        img.alt = 'Package Image';
                        packageImages.appendChild(img); // Append to the correct container
                    });
                }

                packageDetailsContainer.style.display = 'block';
            } else {
                console.log("No Package Details Found, resetting.");
                resetPackageDetails();
            }
        } else {
            resetPackageDetails();
        }
    }

    // Reset Package Details Function
    function resetPackageDetails() {
        console.log("Resetting Package Details.");
        document.getElementById('package-price').textContent = '--';
        document.getElementById('package-duration').textContent = '--';
        document.getElementById('package-description').textContent = '--';

        const packageImages = document.getElementById('package-images');
        packageImages.innerHTML = ''; // Clear images
        document.getElementById('package-details').style.display = 'none'; // Hide package details
    }

    document.getElementById('check-in-date').addEventListener('change', function() {
        const packageName = document.getElementById('package').value;
        const selectedDate = new Date(this.value);
        console.log("Check-In Date Changed:", selectedDate);
        if (packageName && selectedDate) {
            checkAvailability(selectedDate, packageName);
        }
    });

    // Variable to store filtered available times globally
    let filteredAvailableTimes = [];

    // Populate the time picker with formatted booked times
    function populateTimePicker(bookedTimes) {
        const availableTimes = generateAvailableTimes();
        const timePicker = document.getElementById('time-picker');
        
        // Clear the existing time picker content
        timePicker.innerHTML = ''; 

        const formattedBookedTimes = bookedTimes.map(time => formatTimeTo12Hour(time));
        console.log("Formatted Booked Times:", formattedBookedTimes);

        console.log("Generated Available Times: ", availableTimes);

        // Filter out booked times from available times
        filteredAvailableTimes = availableTimes.filter(time => {
            return !bookedTimes.some(bookedTime => bookedTime.trim().toUpperCase() === time.trim().toUpperCase());
        });

        console.log("Filtered Available Times:", filteredAvailableTimes);

        filteredAvailableTimes.forEach(time => {
            const timeDiv = document.createElement('div');
            timeDiv.textContent = time;
            timeDiv.classList.add('time-slot'); // You can style it with CSS

            // Time is available, so make it selectable
            timeDiv.addEventListener('click', function() {
                document.getElementById('check-in-time').value = time; // Set selected time
                timePicker.style.display = 'none'; // Hide the time picker
                updateCheckOutTime(); // Update the checkout time based on selection
            });

            // Add the time div to the time picker
            timePicker.appendChild(timeDiv);
        });
    }

    // Prevent regenerating times when clicking on the input
    function initializeCheckInTimePicker() {
        const checkInTimeInput = document.getElementById('check-in-time');
        const timePicker = document.getElementById('time-picker');
        
        checkInTimeInput.addEventListener('focus', function() {
            // Only show already filtered times, no regeneration
            if (filteredAvailableTimes.length > 0) {
                timePicker.style.display = 'block';
            }

            const rect = checkInTimeInput.getBoundingClientRect();
            timePicker.style.top = `${rect.bottom + window.scrollY}px`;
            timePicker.style.left = `${rect.left}px`;
        });

        // Hide the time picker when clicking outside
        document.addEventListener('click', function(event) {
            if (!checkInTimeInput.contains(event.target) && !timePicker.contains(event.target)) {
                timePicker.style.display = 'none';
            }
        });
    }

    // Function to check availability
    function checkAvailability(selectedDate, packageName) {
        const formattedDate = selectedDate.toISOString().split('T')[0];
        console.log("Checking availability for date:", formattedDate, "and package:", packageName);

        fetch('check_amenitiesAvailability.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `package_category=${document.getElementById('package-category').value}&package=${packageName}&selected_date=${formattedDate}`
        })
        .then(response => response.json())
        .then(data => {
            console.log("Raw Booked Times:", data.bookedTimes);

            // Format booked times to ensure they are in 12-hour format with AM/PM
            const formattedBookedTimes = data.bookedTimes.map(time => formatTimeTo12Hour(time));
            console.log("Formatted Booked Times:", formattedBookedTimes);

            disableDate(data.dateStatus === 'disabled');
            populateTimePicker(formattedBookedTimes); // Pass formatted times
            if (formattedBookedTimes.length >= generateAvailableTimes().length) {
                disableDate(true);  // Disable date if fully booked
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to format time to 12-hour format and remove leading zero in hours
    function formatTimeTo12Hour(timeStr) {
        // If the string already contains 'AM' or 'PM', return it as is
        if (timeStr.includes('AM') || timeStr.includes('PM')) {
            return timeStr;
        }

        let [hours, minutes] = timeStr.split(':');
        hours = parseInt(hours, 10); // Convert hours to integer to remove any leading zero
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; // Convert 0 to 12 for 12 AM and 12 PM

        // If hours are less than 10, it will not include a leading zero.
        return `${hours}:${minutes.padStart(2, '0')} ${ampm}`;
    }

    // Function to generate available times from 08:00 AM to 10:00 PM in 12-hour format
    function generateAvailableTimes() {
        const times = [];
        const startHour = 8;
        const endHour = 22;

        for (let hour = startHour; hour <= endHour; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                let formattedHour = hour > 12 ? hour - 12 : hour;
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const formattedMinute = minute.toString().padStart(2, '0');
                
                // Add leading zero to the hour if less than 10
                formattedHour = formattedHour.toString().padStart(2, '0');
                
                times.push(`${formattedHour}:${formattedMinute} ${ampm}`);
            }
        }
        console.log("Generated Available Times:", times);
        return times;
    }

    // Function to disable the date
    function disableDate(isDisabled) {
        const checkInDateInput = document.getElementById('check-in-date');
        console.log("Disabling Date:", isDisabled);
        checkInDateInput.disabled = isDisabled;
    }

    // Initialize Flatpickr for the Check-In Date
    document.addEventListener('DOMContentLoaded', function() {
        initializeCheckInTimePicker();

        flatpickr("#check-in-date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                console.log("Date Changed via Flatpickr:", dateStr);
                calculateTotalCost();
            }
        });
    });

    // Function to calculate and display Check-Out Time
    function updateCheckOutTime() {
        const checkInTimeStr = document.getElementById('check-in-time').value;
        const durationStr = document.getElementById('package-duration').textContent;

        console.log("Check-In Time String:", checkInTimeStr);
        console.log("Duration String:", durationStr);

        if (!checkInTimeStr || !durationStr || durationStr === '--') {
            return;
        }

        const checkInTime = new Date(`1970-01-01T${convertTo24Hour(checkInTimeStr)}:00`);
        const durationParts = durationStr.split(' ');
        let durationHours = parseFloat(durationParts[0]);
        if (durationParts[1] === 'mins') {
            durationHours /= 60;
        }

        const checkOutTime = new Date(checkInTime.getTime() + durationHours * 60 * 60 * 1000);
        console.log("Check-Out Time Calculated:", checkOutTime);
        document.getElementById('check-out-time').value = formatTime(checkOutTime);
    }

    // Helper function to convert time to 24-hour format
    function convertTo24Hour(time) {
        const [hourMinute, modifier] = time.split(' ');
        let [hours, minutes] = hourMinute.split(':');
        hours = parseInt(hours, 10);
        minutes = parseInt(minutes, 10);
        if (modifier === 'PM' && hours < 12) {
            hours += 12;
        }
        if (modifier === 'AM' && hours === 12) {
            hours = 0;
        }
        console.log("Converted Time to 24-hour format:", `${hours}:${minutes}`);
        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }

    // Helper function to format time back to 12-hour format
    function formatTime(date) {
        let hours = date.getHours();
        const minutes = date.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const formattedTime = `${hours}:${String(minutes).padStart(2, '0')} ${ampm}`;
        console.log("Formatted Time in 12-hour format:", formattedTime);
        return formattedTime;
    }

    // Event listener to update check-out time when check-in time changes
    document.getElementById('check-in-time').addEventListener('change', updateCheckOutTime);

    // Calculate Total Cost Function
    function calculateTotalCost() {
        const packageCategory = document.getElementById('package-category').value;
        const packageName = document.getElementById('package').value;
        const numberOfGuests = parseInt(document.getElementById('guests').value) || 1;

        console.log("Calculating Total Cost for Category:", packageCategory, "Package:", packageName, "Guests:", numberOfGuests);

        const priceSpan = document.getElementById('package-price');
        const totalCostElement = document.getElementById('total-cost');
        const discountAmountElement = document.getElementById('discount-amount');
        const remainingBalanceElement = document.getElementById('remaining-balance');

        // Ensure elements exist before calculating total cost
        if (priceSpan && totalCostElement && discountAmountElement && remainingBalanceElement) {
            const pricePerPackage = parseFloat(priceSpan.textContent) || 0;
            const totalCost = pricePerPackage * numberOfGuests;
            const depositAmount = totalCost * 0.15;
            const remainingBalance = totalCost - depositAmount;

            console.log("Total Cost:", totalCost, "Deposit Amount:", depositAmount, "Remaining Balance:", remainingBalance);

            totalCostElement.textContent = `₱ ${totalCost.toFixed(2)}`;
            discountAmountElement.textContent = `₱ ${depositAmount.toFixed(2)}`;
            remainingBalanceElement.textContent = `₱ ${remainingBalance.toFixed(2)}`;
        } else {
            console.log("One or more elements for calculating the total cost are missing.");
        }
    }

    document.getElementById('package-category').addEventListener('change', updatePackageOptions);
    document.getElementById('package').addEventListener('change', updatePackageDetails);
    document.getElementById('guests').addEventListener('input', calculateTotalCost);

    // Show QR Code Function
    function showQRCode(method) {
        console.log("Showing QR Code for:", method);
        document.querySelectorAll('.qr-code-container').forEach(container => container.style.display = 'none');
        const qrCodeSection = document.getElementById(`${method}-qr`);
        if (qrCodeSection) {
            qrCodeSection.style.display = 'block';
        }
    }
</script>