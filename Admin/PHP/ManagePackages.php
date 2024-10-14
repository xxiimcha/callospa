<?php
require 'activity_log.php';

session_start();

include 'callospa_admin_database.php';
include 'callospa_resort_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Manage Package Page");
}

$resort_conn = connectToResortDatabase();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/Manage.css">
    <title>Callospa Resort Admin</title>
</head>
<style>
    /* Modal container */
#addPackageModal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
    justify-content: center;
    align-items: center;
}

/* Modal content */
#addPackageModal .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    max-width: 600px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: slide-down 0.3s ease-out;
    position: relative;
}

/* Close button */
#addPackageModal .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}

/* Form styles */
#addPackageForm label {
    display: block;
    font-size: 14px;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

#addPackageForm input[type="text"],
#addPackageForm input[type="number"],
#addPackageForm textarea,
#addPackageForm select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9;
}

#addPackageForm input[type="checkbox"] {
    margin-right: 10px;
}

#addPackageForm select[multiple] {
    height: auto;
    min-height: 100px;
}

/* Save button */
.save-button {
    display: inline-block;
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
}

.save-button:hover {
    background-color: #218838;
}

/* Modal animation */
@keyframes slide-down {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    #addPackageModal .modal-content {
        width: 90%;
        max-width: 90%;
    }
}

/* Container for checkboxes */
.checkbox-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

/* Checkbox label and input */
.checkbox-container div {
    display: flex;
    align-items: center;
}

.checkbox-container input[type="checkbox"] {
    margin-right: 10px;
}

/* Modal content */
#addPackageModal .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 70%; /* Increased width from 50% to 70% */
    max-width: 900px; /* Increased max-width from 600px to 900px */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: slide-down 0.3s ease-out;
    position: relative;
}

/* Two-column layout for the modal */
.modal-body {
    display: flex;
    justify-content: space-between;
}

.left-column, .right-column {
    width: 48%;
}

#packagePhotos {
    margin-bottom: 15px;
}

#previewContainer {
    margin-top: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.preview-container img {
    max-width: 100px;
    height: auto;
    border: 1px solid #ccc;
    padding: 5px;
    border-radius: 5px;
    position: relative;
}

.remove-photo {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: red;
    color: white;
    border: none;
    cursor: pointer;
    padding: 2px 5px;
    border-radius: 50%;
    font-size: 12px;
}

.preview-wrapper {
    position: relative;
    display: inline-block;
}

/* Modal footer */
.modal-footer {
    margin-top: 20px;
    text-align: right;
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .modal-body {
        flex-direction: column;
    }

    .left-column, .right-column {
        width: 100%;
    }

    #addPackageModal .modal-content {
        width: 90%;
        max-width: 90%;
    }
}

</style>
<body>
    <?php include 'Sidebar.php'; ?>
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Manage Packages</h1>
                    <ul class="breadcrumb">
                        <li><a href="AdministratorPage.php">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="ManagePackages.php">Manage Packages</a></li>
                    </ul>
                </div>
                <div class="right">
                    <button class="btn-add" id="openAddPackageModalBtn">Add Package</button>
                </div>
            </div>

            <table border="1" cellpadding="10" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Package Name</th>
                        <th>Price (PHP)</th>
                        <th>Duration</th>
                        <th>Description</th>
                        <th>Inclusions</th>
                        <th>Guests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, package_name, price, duration, description, inclusions, guests FROM packages";
                    $result = $resort_conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $resort_conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id']);
                            $package_name = htmlspecialchars($row['package_name']);
                            $price = number_format($row['price'], 2);
                            $duration = htmlspecialchars($row['duration']);
                            $description = htmlspecialchars($row['description']);
                            $inclusions = htmlspecialchars($row['inclusions']);
                            $guests = htmlspecialchars($row['guests']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td class='package-name'>$package_name</td>";
                            echo "<td class='package-price'>$price</td>";
                            echo "<td class='package-duration'>$duration</td>";
                            echo "<td class='package-description'>$description</td>";
                            echo "<td class='package-inclusions'>$inclusions</td>";
                            echo "<td class='package-guests'>$guests</td>";
                            echo "<td>";
                            echo "<button class='edit'>Edit</button>";
                            echo "<button class='delete'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No packages available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Edit Package Modal -->
            <div id="editPackageModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Package Details</h2>
                    <form id="editPackageForm">
                        <input type="hidden" id="packageId" name="packageId">

                        <label for="packageName">Package Name:</label>
                        <input type="text" id="packageName" name="packageName" required>

                        <label for="packagePrice">Price:</label>
                        <input type="number" id="packagePrice" name="packagePrice" required>

                        <label for="packageDuration">Duration:</label>
                        <input type="text" id="packageDuration" name="packageDuration" required>

                        <label for="packageDescription">Description:</label>
                        <textarea id="packageDescription" name="packageDescription" required></textarea>

                        <label for="packageInclusions">Inclusions:</label>
                        <textarea id="packageInclusions" name="packageInclusions" required></textarea>

                        <label for="packageCapacity">Guest Capacity:</label>
                        <input type="number" id="packageCapacity" name="packageCapacity" required>

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Edit Package Success Modal -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Package details updated successfully!</p>
                </div>
            </div>

            <div id="addPackageModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add Package</h2>
                    <form id="addPackageForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!-- Left Column: Form Fields -->
                            <div class="left-column">
                                <label for="packageName">Package Name:</label>
                                <input type="text" id="packageName" name="packageName" required>

                                <label for="packagePrice">Price (PHP):</label>
                                <input type="number" id="packagePrice" name="packagePrice" required min="0" step="0.01">

                                <label for="packageDuration">Duration (in hours/days):</label>
                                <input type="text" id="packageDuration" name="packageDuration" required>

                                <label for="packageDescription">Description:</label>
                                <textarea id="packageDescription" name="packageDescription" required></textarea>

                                <label for="packageInclusions">Inclusions:</label>
                                <!-- Container for Include Rooms and Include Spas/Amenities checkboxes -->
                                <div class="checkbox-container">
                                    <div>
                                        <input type="checkbox" id="includeRooms" name="includeRooms">
                                        <label for="includeRooms">Include Rooms</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="includeSpas" name="includeSpas">
                                        <label for="includeSpas">Include Spas/Amenities</label>
                                    </div>
                                </div>

                                <!-- Dropdown for selecting rooms (Initially hidden) -->
                                <div id="roomsDropdown" style="display: none;">
                                    <label for="rooms">Select Rooms:</label>
                                    <select id="rooms" name="rooms[]" multiple>
                                        <option value="">Select Room</option>
                                        <?php
                                        $rooms_sql = "SELECT id, room_name FROM rooms";
                                        $rooms_result = $resort_conn->query($rooms_sql);
                                        while ($row = $rooms_result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['room_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Dropdown for selecting spa/amenities categories -->
                                <div id="spasDropdown" style="display: none;">
                                    <label for="amenitiesCategory">Select Spa/Amenities Category:</label>
                                    <select id="amenitiesCategory" name="amenitiesCategory">
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetch categories from the database
                                        $category_sql = "SELECT DISTINCT amenities_categories FROM amenities";
                                        $category_result = $resort_conn->query($category_sql);

                                        while ($row = $category_result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['amenities_categories']) . "'>" . htmlspecialchars($row['amenities_categories']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Dropdown for selecting spa/amenities subcategories (Initially hidden until category is selected) -->
                                <div id="subcategoriesDropdown" style="display: none;">
                                    <label for="subcategories">Select Spa Subcategories:</label>
                                    <select id="subcategories" name="subcategories[]" multiple>
                                        <option value="">Select Subcategory</option>
                                        <!-- Dynamically loaded via JavaScript -->
                                    </select>
                                </div>

                                <label for="packageCapacity">Guest Capacity:</label>
                                <input type="number" id="packageCapacity" name="packageCapacity" required min="1">
                            </div>

                            <!-- Right Column: Photo Upload -->
                            <div class="right-column">
                                <label for="packagePhotos">Upload Photos:</label>
                                <input type="file" id="packagePhotos" name="packagePhotos[]" accept="image/*" multiple>
                                
                                <!-- Display selected images -->
                                <div id="previewContainer" class="preview-container">
                                    <!-- Preview images will be appended here -->
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="save-button">Add Package</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Package Success Modal -->
            <div id="addPackageSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Package added successfully!</p>
                </div>
            </div>

            <!-- Delete Package Confirmation Modal -->
            <div id="deleteConfirmationModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this package?</p>
                    <button id="confirmDeleteButton" class="save-button">Yes</button>
                    <button id="cancelDeleteButton" class="save-button">No</button>
                </div>
            </div>

            <!-- Delete Package Success Modal -->
            <div id="deleteSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Package successfully deleted!</p>
                </div>
            </div>
        </main>
    </section>
    <script src="../JS/Sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const includeRoomsCheckbox = document.getElementById('includeRooms');
            const roomsDropdown = document.getElementById('roomsDropdown');

            const includeSpasCheckbox = document.getElementById('includeSpas');
            const spasDropdown = document.getElementById('spasDropdown');

            // Toggle rooms dropdown based on the checkbox state
            includeRoomsCheckbox.addEventListener('change', () => {
                if (includeRoomsCheckbox.checked) {
                    roomsDropdown.style.display = 'block';
                } else {
                    roomsDropdown.style.display = 'none';
                }
            });

            const amenitiesCategory = document.getElementById('amenitiesCategory');
            const subcategoriesDropdown = document.getElementById('subcategoriesDropdown');
            const subcategoriesSelect = document.getElementById('subcategories');

            // When the category changes, fetch the subcategories
            amenitiesCategory.addEventListener('change', () => {
                const selectedCategory = amenitiesCategory.value;

                if (selectedCategory) {
                    fetchSubcategories(selectedCategory);
                } else {
                    subcategoriesDropdown.style.display = 'none';
                    subcategoriesSelect.innerHTML = ''; // Clear previous options
                }
            });

            function fetchSubcategories(category) {
                // Make an AJAX request to fetch subcategories based on the selected category
                fetch('fetch_subcategories.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `category=${encodeURIComponent(category)}`
                })
                .then(response => response.text())
                .then(data => {
                    subcategoriesSelect.innerHTML = data; // Update the subcategory options
                    subcategoriesDropdown.style.display = 'block'; // Show the subcategories dropdown
                })
                .catch(error => {
                    console.error('Error fetching subcategories:', error);
                });
            }

            // Toggle spas dropdown based on the checkbox state
            includeSpasCheckbox.addEventListener('change', () => {
                if (includeSpasCheckbox.checked) {
                    spasDropdown.style.display = 'block';
                } else {
                    spasDropdown.style.display = 'none';
                }
            });

            const openModal = (modal) => {
                modal.style.display = 'flex';
            };

            const closeModal = (modal) => {
                modal.style.display = 'none';
            };

            const assignCloseModalEvent = (closeBtn, modal) => {
                closeBtn.addEventListener('click', () => closeModal(modal));
            };

            const assignOutsideClickEvent = (modal) => {
                window.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            };

            const handleFormSubmission = (form, url, successModal) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    const formData = new FormData(form);

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(successModal);
                                closeModal(form.closest('.modal'));
                            } else {
                                alert('Failed to update: ' + data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            };

            const setupEditPackageModal = () => {
                const modal = document.getElementById('editPackageModal');
                const closeBtn = modal.querySelector('.close');
                const editButtons = document.querySelectorAll('.edit');
                const form = document.getElementById('editPackageForm');
                const successModal = document.getElementById('successModal');
                const closeSuccessBtn = successModal.querySelector('.close-success-modal');

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        const packageData = ['packageId', 'packageName', 'packagePrice', 'packageDuration', 'packageDescription', 'packageInclusions', 'packageCapacity'];

                        packageData.forEach((field, index) => {
                            document.getElementById(field).value = row.cells[index].innerText;
                        });

                        openModal(modal);
                    });
                });

                assignCloseModalEvent(closeBtn, modal);
                assignOutsideClickEvent(modal);
                handleFormSubmission(form, 'update_package.php', successModal);

                assignCloseModalEvent(closeSuccessBtn, successModal);
                assignOutsideClickEvent(successModal);
            };

            const setupAddPackageModal = () => {
                const addPackageModal = document.getElementById('addPackageModal');
                const addPackageSuccessModal = document.getElementById('addPackageSuccessModal');
                const openAddPackageModalBtn = document.getElementById('openAddPackageModalBtn');
                const closeAddPackageModalBtn = addPackageModal.querySelector('.close');
                const closeSuccessModalBtn = addPackageSuccessModal.querySelector('.close-success-modal');
                const form = document.getElementById('addPackageForm');

                openAddPackageModalBtn.addEventListener('click', () => openModal(addPackageModal));

                assignCloseModalEvent(closeAddPackageModalBtn, addPackageModal);
                assignOutsideClickEvent(addPackageModal);
                assignCloseModalEvent(closeSuccessModalBtn, addPackageSuccessModal);
                assignOutsideClickEvent(addPackageSuccessModal);

                handleFormSubmission(form, 'add_package.php', addPackageSuccessModal);
            };

            const setupDeletePackageModal = () => {
                const deleteButtons = document.querySelectorAll('.delete');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const deleteSuccessModal = document.getElementById('deleteSuccessModal');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                const cancelDeleteButton = document.getElementById('cancelDeleteButton');
                let packageToDelete = null;

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        packageToDelete = row.cells[0].innerText;
                        openModal(deleteConfirmationModal);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    fetch('delete_package.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: packageToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(deleteSuccessModal);
                                closeModal(deleteConfirmationModal);
                                document.querySelector(`tr:has(td:contains('${packageToDelete}'))`).remove();
                            } else {
                                alert('Failed to delete the package.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });

                cancelDeleteButton.addEventListener('click', () => closeModal(deleteConfirmationModal));

                assignCloseModalEvent(document.querySelector('#deleteConfirmationModal .close'), deleteConfirmationModal);
                assignCloseModalEvent(document.querySelector('#deleteSuccessModal .close-success-modal'), deleteSuccessModal);

                assignOutsideClickEvent(deleteConfirmationModal);
                assignOutsideClickEvent(deleteSuccessModal);
            };

            setupEditPackageModal();
            setupAddPackageModal();
            setupDeletePackageModal();
        });

        document.addEventListener('DOMContentLoaded', () => {
    const packagePhotosInput = document.getElementById('packagePhotos');
    const previewContainer = document.getElementById('previewContainer');
    let previewImages = []; // Store all images (newly added and existing)

    packagePhotosInput.addEventListener('change', (event) => {
        const files = event.target.files;
        const newFiles = Array.from(files); // Convert FileList to Array

        // Add new files to the existing previewImages array
        newFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = (e) => {
                const previewWrapper = document.createElement('div');
                previewWrapper.classList.add('preview-wrapper');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = `Photo ${previewImages.length + index + 1}`;
                img.classList.add('preview-image');

                const removeButton = document.createElement('button');
                removeButton.innerText = 'X';
                removeButton.classList.add('remove-photo');
                removeButton.setAttribute('data-index', previewImages.length + index);

                // Add event listener to remove the image when clicking the remove button
                removeButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    removeImage(previewImages.length + index);
                });

                previewWrapper.appendChild(img);
                previewWrapper.appendChild(removeButton);
                previewContainer.appendChild(previewWrapper);

                // Store preview data
                previewImages.push({ file, img });
            };

            reader.readAsDataURL(file);
        });

        updateFileList();
    });

    // Remove specific image from preview
    function removeImage(index) {
        // Remove the preview image from the previewImages array
        previewImages.splice(index, 1);

        // Re-render the preview container after removing the image
        renderPreviewImages();

        updateFileList(); // Update input file list
    }

    // Re-render the preview images (called after removing an image)
    function renderPreviewImages() {
        previewContainer.innerHTML = ''; // Clear existing previews

        previewImages.forEach((image, index) => {
            const previewWrapper = document.createElement('div');
            previewWrapper.classList.add('preview-wrapper');

            const img = document.createElement('img');
            img.src = URL.createObjectURL(image.file);
            img.alt = `Photo ${index + 1}`;
            img.classList.add('preview-image');

            const removeButton = document.createElement('button');
            removeButton.innerText = 'X';
            removeButton.classList.add('remove-photo');
            removeButton.setAttribute('data-index', index);

            // Add event listener to remove the image
            removeButton.addEventListener('click', (e) => {
                e.preventDefault();
                removeImage(index);
            });

            previewWrapper.appendChild(img);
            previewWrapper.appendChild(removeButton);
            previewContainer.appendChild(previewWrapper);
        });
    }

    // Update the file input's FileList object
    function updateFileList() {
        const dataTransfer = new DataTransfer();

        previewImages.forEach((image) => {
            dataTransfer.items.add(image.file);
        });

        packagePhotosInput.files = dataTransfer.files; // Update the file input
    }
});

    </script>
</body>

</html>