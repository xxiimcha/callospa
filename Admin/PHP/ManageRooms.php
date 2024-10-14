<?php
require 'activity_log.php';

session_start();

include 'callospa_admin_database.php';
include 'callospa_resort_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Manage Rooms Page");
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
<style>
    /* Container for image previews */
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .preview-wrapper {
        position: relative;
        display: inline-block;
    }

    .preview-wrapper img {
        max-width: 100px;
        height: auto;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
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

</style>

<body>
    <?php include 'Sidebar.php'; ?>
    <section id="content">

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Manage Rooms</h1>
                    <ul class="breadcrumb">
                        <li><a href="AdministratorPage.php">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="ManageRooms.php">Manage Rooms</a></li>
                    </ul>
                </div>
                <div class="right">
                    <button class="btn-add" id="openAddRoomModalBtn">Add Room</button>
                </div>
            </div>

            <table border="1" cellpadding="10" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Name</th>
                        <th>Subcategory</th>
                        <th>Price (PHP)</th>
                        <th>Description</th>
                        <th>Inclusions</th>
                        <th>Guests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, room_name, subcategory_rooms, price, description, inclusions, guests, `room-images` FROM rooms";
                    $result = $resort_conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $resort_conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id']);
                            $room_name = htmlspecialchars($row['room_name']);
                            $subcategory_rooms = htmlspecialchars($row['subcategory_rooms']);
                            $price = number_format($row['price'], 2);
                            $description = htmlspecialchars($row['description']);
                            $inclusions = htmlspecialchars($row['inclusions']);
                            $guests = htmlspecialchars($row['guests']);
                            $roomImages = htmlspecialchars($row['room-images']); // Get the images from the database

                            echo "<tr data-images='$roomImages'>";
                            echo "<td>$id</td>";
                            echo "<td class='room-name'>$room_name</td>";
                            echo "<td class='room-subcategory'>$subcategory_rooms</td>";
                            echo "<td class='room-price'>$price</td>";
                            echo "<td class='room-description'>$description</td>";
                            echo "<td class='room-inclusions'>$inclusions</td>";
                            echo "<td class='room-guests'>$guests</td>";
                            echo "<td>";
                            echo "<button class='edit'>Edit</button>";
                            echo "<button class='delete'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No rooms available.</td></tr>";
                    }

                    $resort_conn->close(); ?>
                </tbody>
            </table>

            <!-- Edit Room Modal -->
            <div id="editRoomModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Room</h2>
                    <form id="editRoomForm" enctype="multipart/form-data">
                        <input type="hidden" id="roomId" name="roomId">

                        <label for="roomName">Room Name:</label>
                        <input type="text" id="roomName" name="roomName" required>

                        <label for="subcategory">Subcategory:</label>
                        <input type="text" id="subcategory" name="subcategory">

                        <label for="roomPrice">Price:</label>
                        <input type="number" id="roomPrice" name="roomPrice" required>

                        <label for="roomCapacity">Guest Capacity:</label>
                        <input type="number" id="roomCapacity" name="roomCapacity" required>
                        <label for="roomDescription">Description:</label>
                        <textarea id="roomDescription" name="roomDescription" required></textarea>

                        <label for="roomInclusions">Inclusions:</label>
                        <textarea id="roomInclusions" name="roomInclusions" required></textarea>

                        <!-- Image Upload for Edit Room -->
                        <label for="editRoomPhotos">Upload Photos:</label>
                        <input type="file" id="editRoomPhotos" name="roomPhotos[]" accept="image/*" multiple>
                        <div id="editPreviewContainer" class="preview-container"></div>

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Edit Room Success Modal -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Room details updated successfully!</p>
                </div>
            </div>

            <!-- Add Room Modal -->
            <div id="addRoomModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add Room</h2>
                    <form id="addRoomForm" enctype="multipart/form-data">
                        <label for="roomName">Room Name:</label>
                        <input type="text" id="roomName" name="roomName" required>

                        <label for="subcategory">Subcategory:</label>
                        <input type="text" id="subcategory" name="subcategory">

                        <label for="roomPrice">Price:</label>
                        <input type="number" id="roomPrice" name="roomPrice" required>

                        <label for="roomCapacity">Guest Capacity:</label>
                        <input type="number" id="roomCapacity" name="roomCapacity" required>

                        <label for="roomDescription">Description:</label>
                        <textarea id="roomDescription" name="roomDescription" required></textarea>

                        <label for="roomInclusions">Inclusions:</label>
                        <textarea id="roomInclusions" name="roomInclusions" required></textarea>

                        <!-- Image Upload for Add Room -->
                        <label for="addRoomPhotos">Upload Photos:</label>
                        <input type="file" id="addRoomPhotos" name="roomPhotos[]" accept="image/*" multiple>
                        <div id="addPreviewContainer" class="preview-container"></div>

                        <button type="submit" class="save-button">Add Room</button>
                    </form>
                </div>
            </div>

            <!-- Add Room Success Modal -->
            <div id="addRoomSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Room added successfully!</p>
                </div>
            </div>

            <!-- Delete Room Confirmation Modal -->
            <div id="deleteConfirmationModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this room?</p>
                    <button id="confirmDeleteButton" class="save-button">Yes</button>
                    <button id="cancelDeleteButton" class="save-button">No</button>
                </div>
            </div>

            <!-- Delete Room Success Modal -->
            <div id="deleteSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Room successfully deleted!</p>
                </div>
            </div>
        </main>
    </section>
    <script src="../JS/Sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addRoomPhotosInput = document.getElementById('addRoomPhotos');
            const addPreviewContainer = document.getElementById('addPreviewContainer');
            const editRoomPhotosInput = document.getElementById('editRoomPhotos');
            const editPreviewContainer = document.getElementById('editPreviewContainer');

            let addPreviewImages = [];
            let editPreviewImages = [];

            // Handle Add Room Photo Preview
            addRoomPhotosInput.addEventListener('change', (event) => {
                const files = event.target.files;
                renderImagePreviews(files, addPreviewImages, addPreviewContainer);
            });

            // Handle Edit Room Photo Preview
            editRoomPhotosInput.addEventListener('change', (event) => {
                const files = event.target.files;
                renderImagePreviews(files, editPreviewImages, editPreviewContainer);
            });

            // Function to render image previews
            function renderImagePreviews(files, previewImages, previewContainer) {
                // Clear previous previews
                previewContainer.innerHTML = '';
                previewImages = [];

                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.classList.add('preview-wrapper');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = `Photo ${index + 1}`;
                        img.classList.add('preview-image');

                        const removeButton = document.createElement('button');
                        removeButton.innerText = 'X';
                        removeButton.classList.add('remove-photo');
                        removeButton.setAttribute('data-index', index);

                        // Remove image functionality
                        removeButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            removeImage(index, previewImages, previewContainer);
                        });

                        previewWrapper.appendChild(img);
                        previewWrapper.appendChild(removeButton);
                        previewContainer.appendChild(previewWrapper);

                        // Store preview data
                        previewImages.push({ file, img });
                    };

                    reader.readAsDataURL(file);
                });
            }

            // Function to remove specific image
            function removeImage(index, previewImages, previewContainer) {
                // Remove the image from the previewImages array
                previewImages.splice(index, 1);

                // Re-render the preview container
                renderPreviewImages(previewImages, previewContainer);
            }

            // Re-render preview container after removing image
            function renderPreviewImages(previewImages, previewContainer) {
                previewContainer.innerHTML = ''; // Clear previous previews

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

                    removeButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        removeImage(index, previewImages, previewContainer);
                    });

                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(removeButton);
                    previewContainer.appendChild(previewWrapper);
                });
            }
            
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

            const setupEditRoomModal = () => {
                const modal = document.getElementById('editRoomModal');
                const closeBtn = modal.querySelector('.close');
                const editButtons = document.querySelectorAll('.edit');
                const form = document.getElementById('editRoomForm');
                const successModal = document.getElementById('successModal');
                const closeSuccessBtn = successModal.querySelector('.close-success-modal');
                const editPreviewContainer = document.getElementById('editPreviewContainer');

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        const roomData = ['roomId', 'roomName', 'subcategory', 'roomPrice', 'roomCapacity', 'roomDescription', 'roomInclusions'];
                        const roomImages = row.getAttribute('data-images'); // Assuming room images are stored in the data attribute

                        // Load the text values into the modal inputs
                        roomData.forEach((field, index) => {
                            document.getElementById(field).value = row.cells[index].innerText;
                        });

                        // Clear previous previews
                        editPreviewContainer.innerHTML = '';

                        // Load existing images into the preview container
                        if (roomImages) {
                            const imagesArray = roomImages.split(', '); // Assuming comma-separated image paths
                            imagesArray.forEach((image, index) => {
                                const previewWrapper = document.createElement('div');
                                previewWrapper.classList.add('preview-wrapper');

                                const img = document.createElement('img');
                                img.src = `../../RoomImages/${image.trim()}`; // Adjust the path based on where your images are stored
                                img.alt = `Existing Photo ${index + 1}`;
                                img.classList.add('preview-image');

                                const removeButton = document.createElement('button');
                                removeButton.innerText = 'X';
                                removeButton.classList.add('remove-photo');
                                removeButton.setAttribute('data-image', image);

                                // Add event listener to mark image for removal
                                removeButton.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    removeImageFromServer(image, previewWrapper);
                                });

                                previewWrapper.appendChild(img);
                                previewWrapper.appendChild(removeButton);
                                editPreviewContainer.appendChild(previewWrapper);
                            });
                        }

                        openModal(modal);
                    });
                });

                // Function to remove image from server or mark it for removal
                function removeImageFromServer(image, wrapper) {
                    if (confirm('Are you sure you want to remove this image?')) {
                        fetch('delete_image.php', { // Create this PHP script to handle the image deletion
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `image=${encodeURIComponent(image)}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                wrapper.remove(); // Remove the image preview from the modal
                            } else {
                                alert('Failed to remove image.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                }

                assignCloseModalEvent(closeBtn, modal);
                assignOutsideClickEvent(modal);
                handleFormSubmission(form, 'update_room.php', successModal);

                assignCloseModalEvent(closeSuccessBtn, successModal);
                assignOutsideClickEvent(successModal);
            };


            const setupAddRoomModal = () => {
                const addRoomModal = document.getElementById('addRoomModal');
                const addRoomSuccessModal = document.getElementById('addRoomSuccessModal');
                const openAddRoomModalBtn = document.getElementById('openAddRoomModalBtn');
                const closeAddRoomModalBtn = addRoomModal.querySelector('.close');
                const closeSuccessModalBtn = addRoomSuccessModal.querySelector('.close-success-modal');
                const form = document.getElementById('addRoomForm');

                openAddRoomModalBtn.addEventListener('click', () => openModal(addRoomModal));

                assignCloseModalEvent(closeAddRoomModalBtn, addRoomModal);
                assignOutsideClickEvent(addRoomModal);
                assignCloseModalEvent(closeSuccessModalBtn, addRoomSuccessModal);
                assignOutsideClickEvent(addRoomSuccessModal);

                handleFormSubmission(form, 'add_room.php', addRoomSuccessModal);
            };

            const setupDeleteRoomModal = () => {
                const deleteButtons = document.querySelectorAll('.delete');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const deleteSuccessModal = document.getElementById('deleteSuccessModal');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                const cancelDeleteButton = document.getElementById('cancelDeleteButton');
                let roomToDelete = null;

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        roomToDelete = row.cells[0].innerText;
                        openModal(deleteConfirmationModal);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    fetch('delete_room.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: roomToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(deleteSuccessModal);
                                closeModal(deleteConfirmationModal);
                                document.querySelector(`tr:has(td:contains('${roomToDelete}'))`).remove();
                            } else {
                                alert('Failed to delete the room.');
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

            setupEditRoomModal();
            setupAddRoomModal();
            setupDeleteRoomModal();
        });
    </script>

</body>

</html>
