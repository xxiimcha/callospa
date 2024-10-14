<?php
require 'activity_log.php';

session_start();

include 'callospa_admin_database.php';
include 'callospa_resort_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Manage Amenities Page");
}

$resort_conn = connectToResortDatabase();

$conn->close();
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

<body>
    <?php include 'Sidebar.php'; ?>
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Manage Amenities</h1>
                    <ul class="breadcrumb">
                        <li><a href="AdministratorPage.php">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="ManageAmenities.php">Manage Amenities</a></li>
                    </ul>
                </div>
                <div class="right">
                    <button class="btn-add" id="openAddAmenitiesModalBtn">Add Amenities</button>
                </div>
            </div>

            <table border="1" cellpadding="10" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Spa Category</th>
                        <th>Spa Services</th>
                        <th>Description</th>
                        <th>Price (PHP)</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $categoryQuery = "SELECT amenities_categories FROM amenities GROUP BY amenities_categories";
                    $categoryResult = $resort_conn->query($categoryQuery);

                    $amenitiesCategories = array();

                    if ($categoryResult) {
                        while ($row = $categoryResult->fetch_assoc()) {
                            $amenitiesCategories[] = $row['amenities_categories'];
                        }
                    }

                    $sql = "SELECT id, amenities_categories, amenities_subcategory_name, amenities_subcategory_description, price, duration FROM amenities";
                    $result = $resort_conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $resort_conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id']);
                            $amenities_category = htmlspecialchars($row['amenities_categories']);
                            $amenities_subcategory = htmlspecialchars($row['amenities_subcategory_name']);
                            $amenities_description = htmlspecialchars($row['amenities_subcategory_description']);
                            $price = number_format($row['price'], 2);
                            $duration = htmlspecialchars($row['duration']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td class='amenities-category'>$amenities_category</td>";
                            echo "<td class='amenities-subcategory'>$amenities_subcategory</td>";
                            echo "<td class='amenities-subcategory-description'>$amenities_description</td>";
                            echo "<td class='amenities-price'>$price</td>";
                            echo "<td class='amenities-duration'>$duration</td>";
                            echo "<td>";
                            echo "<button class='edit'>Edit</button>";
                            echo "<button class='delete'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No amenities available.</td></tr>";
                    }

                    $resort_conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Edit Amenities Modal -->
            <div id="editAmenitiesModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Amenities Details</h2>
                    <form id="editAmenitiesForm">
                        <input type="hidden" id="amenitiesId" name="amenitiesId">

                        <label for="amenitiesCategories">Select Amenities Category:</label>
                        <select id="amenitiesCategories" name="amenitiesCategories" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($amenitiesCategories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="subcategoryName">Spa Services:</label>
                        <input type="text" id="subcategoryName" name="subcategoryName" required>

                        <label for="subcategoryDescription">Description:</label>
                        <textarea id="subcategoryDescription" name="subcategoryDescription" required></textarea>

                        <label for="amenitiesPrice">Price:</label>
                        <input type="number" id="amenitiesPrice" name="amenitiesPrice" required>

                        <label for="amenitiesDuration">Duration:</label>
                        <input type="text" id="amenitiesDuration" name="amenitiesDuration" required>

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Success Modal -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Amenities details updated successfully!</p>
                </div>
            </div>

            <!-- Add Amenities Modal -->
            <div id="addAmenitiesModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add Amenities</h2>
                    <form id="addAmenitiesForm">
                        <label for="amenitiesCategories">Select Amenities Category:</label>
                        <select id="amenitiesCategories" name="amenitiesCategories" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($amenitiesCategories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="addSubcategoryName">Spa Services:</label>
                        <input type="text" id="addSubcategoryName" name="addSubcategoryName" required>

                        <label for="addSubcategoryDescription">Description:</label>
                        <textarea id="addSubcategoryDescription" name="addSubcategoryDescription" required></textarea>

                        <label for="addAmenitiesPrice">Price:</label>
                        <input type="number" id="addAmenitiesPrice" name="addAmenitiesPrice" required>

                        <label for="addAmenitiesDuration">Duration:</label>
                        <input type="text" id="addAmenitiesDuration" name="addAmenitiesDuration" required>

                        <button type="submit" class="save-button">Add Amenities</button>
                    </form>
                </div>
            </div>

            <!-- Add Amenities Success Modal -->
            <div id="addAmenitiesSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Amenities added successfully!</p>
                </div>
            </div>

            <!-- Delete Amenity Confirmation Modal -->
            <div id="deleteConfirmationModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this amenity?</p>
                    <button id="confirmDeleteButton" class="save-button">Yes</button>
                    <button id="cancelDeleteButton" class="save-button">No</button>
                </div>
            </div>

            <!-- Delete Room Success Modal -->
            <div id="deleteSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Amenity successfully deleted!</p>
                </div>
            </div>
        </main>
    </section>
    <script src="../JS/Sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

            const setupEditAmenitiesModal = () => {
                const modal = document.getElementById('editAmenitiesModal');
                const closeBtn = modal.querySelector('.close');
                const editButtons = document.querySelectorAll('.edit');
                const form = document.getElementById('editAmenitiesForm');
                const successModal = document.getElementById('successModal');
                const closeSuccessBtn = successModal.querySelector('.close-success-modal');

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        const amenitiesData = ['amenitiesId', 'subcategoryName', 'subcategoryDescription', 'amenitiesPrice', 'amenitiesDuration', 'amenitiesCategories']; // Added category

                        amenitiesData.forEach((field, index) => {
                            document.getElementById(field).value = row.cells[index].innerText;
                        });

                        openModal(modal);
                    });
                });

                assignCloseModalEvent(closeBtn, modal);
                assignOutsideClickEvent(modal);
                handleFormSubmission(form, 'update_amenities.php', successModal);

                assignCloseModalEvent(closeSuccessBtn, successModal);
                assignOutsideClickEvent(successModal);
            };

            const setupAddAmenitiesModal = () => {
                const addAmenitiesModal = document.getElementById('addAmenitiesModal');
                const addAmenitiesSuccessModal = document.getElementById('addAmenitiesSuccessModal');
                const openAddAmenitiesModalBtn = document.getElementById('openAddAmenitiesModalBtn');
                const closeAddAmenitiesModalBtn = addAmenitiesModal.querySelector('.close');
                const closeSuccessModalBtn = addAmenitiesSuccessModal.querySelector('.close-success-modal');
                const form = document.getElementById('addAmenitiesForm');

                openAddAmenitiesModalBtn.addEventListener('click', () => openModal(addAmenitiesModal));

                handleFormSubmission(form, 'add_amenities.php', addAmenitiesSuccessModal);

                assignCloseModalEvent(closeAddAmenitiesModalBtn, addAmenitiesModal);
                assignCloseModalEvent(closeSuccessModalBtn, addAmenitiesSuccessModal);
                assignOutsideClickEvent(addAmenitiesModal);
                assignOutsideClickEvent(addAmenitiesSuccessModal);
            };

            const setupDeleteAmenitiesModal = () => {
                const deleteButtons = document.querySelectorAll('.delete');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const deleteSuccessModal = document.getElementById('deleteSuccessModal');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                const cancelDeleteButton = document.getElementById('cancelDeleteButton');
                let amenityToDelete = null;

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        amenityToDelete = row.cells[0].innerText;
                        openModal(deleteConfirmationModal);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    fetch('delete_amenity.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: amenityToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(deleteSuccessModal);
                                closeModal(deleteConfirmationModal);
                                document.querySelector(`tr:has(td:contains('${amenityToDelete}'))`).remove();
                            } else {
                                alert('Failed to delete the amenity.');
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

            setupEditAmenitiesModal();
            setupAddAmenitiesModal();
            setupDeleteAmenitiesModal();
        });
    </script>
</body>

</html>