<?php
require 'activity_log.php';

session_start();

include 'callospa_admin_database.php';
include 'callospa_resort_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Manage Events Page");
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
                    <h1>Manage Events</h1>
                    <ul class="breadcrumb">
                        <li><a href="AdministratorPage.php">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="ManageEvents.php">Manage Events</a></li>
                    </ul>
                </div>
                <div class="right">
                    <button id="openAddEventModalBtn" class="btn-add">Add Events</button>
                </div>
            </div>

            <table border="1" cellpadding="10" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Venue</th>
                        <th>Event Type</th>
                        <th>Price (PHP)</th>
                        <th>Description</th>
                        <th>Inclusions</th>
                        <th>Guests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $venueQuery = "SELECT DISTINCT venue FROM events";
                    $venueResult = $resort_conn->query($venueQuery);

                    $venues = array();

                    if ($venueResult) {
                        while ($row = $venueResult->fetch_assoc()) {
                            $venues[] = $row['venue'];
                        }
                    }

                    $sql = "SELECT id, venue, event_type, price, description, inclusions, guests FROM events";
                    $result = $resort_conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $resort_conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id']);
                            $venue = htmlspecialchars($row['venue']);
                            $event_type = htmlspecialchars($row['event_type']);
                            $price = number_format($row['price'], 2);
                            $description = htmlspecialchars($row['description']);
                            $inclusions = htmlspecialchars($row['inclusions']);
                            $guests = htmlspecialchars($row['guests']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td class='event-venue'>$venue</td>";
                            echo "<td class='event-type'>$event_type</td>";
                            echo "<td class='event-price'>$price</td>";
                            echo "<td class='event-description'>$description</td>";
                            echo "<td class='event-inclusions'>$inclusions</td>";
                            echo "<td class='event-guests'>$guests</td>";
                            echo "<td>";
                            echo "<button class='edit'>Edit</button>";
                            echo "<button class='delete'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No events available.</td></tr>";
                    }

                    $resort_conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Edit Event Modal -->
            <div id="editEventModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Event Details</h2>
                    <form id="editEventForm">
                        <input type="hidden" id="eventId" name="eventId">

                        <label for="venue">Select Venue:</label>
                        <select id="venue" name="venue" required>
                            <option value="" disabled selected>Select a venue</option>
                            <?php foreach ($venues as $venue): ?>
                                <option value="<?php echo htmlspecialchars($venue); ?>"><?php echo htmlspecialchars($venue); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="eventType">Event Type:</label>
                        <input type="text" id="eventType" name="eventType" required>

                        <label for="eventPrice">Price:</label>
                        <input type="number" id="eventPrice" name="eventPrice" required>

                        <label for="eventCapacity">Guest Capacity:</label>
                        <input type="number" id="eventCapacity" name="eventCapacity" required>

                        <label for="eventDescription">Description:</label>
                        <textarea id="eventDescription" name="eventDescription" required></textarea>

                        <label for="eventInclusions">Inclusions:</label>
                        <textarea id="eventInclusions" name="eventInclusions" required></textarea>

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Edit Event Success Modal -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Event details updated successfully!</p>
                </div>
            </div>

            <!-- Add Event Modal -->
            <div id="addEventModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add Event</h2>
                    <form id="addEventForm">
                        <input type="hidden" id="eventId" name="eventId">

                        <label for="venue">Select Venue:</label>
                        <select id="venue" name="venue" required>
                            <option value="" disabled selected>Select a venue</option>
                            <?php foreach ($venues as $venue): ?>
                                <option value="<?php echo htmlspecialchars($venue); ?>"><?php echo htmlspecialchars($venue); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="eventType">Event Type:</label>
                        <input type="text" id="eventType" name="eventType" required>

                        <label for="eventPrice">Price:</label>
                        <input type="number" id="eventPrice" name="eventPrice" required>

                        <label for="eventCapacity">Guest Capacity:</label>
                        <input type="number" id="eventCapacity" name="eventCapacity" required>

                        <label for="eventDescription">Description:</label>
                        <textarea id="eventDescription" name="eventDescription" required></textarea>

                        <label for="eventInclusions">Inclusions:</label>
                        <textarea id="eventInclusions" name="eventInclusions" required></textarea>

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Add Event Success Modal -->
            <div id="addEventSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Event added successfully!</p>
                </div>
            </div>

            <!-- Delete Event Confirmation Modal -->
            <div id="deleteConfirmationModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this event?</p>
                    <button id="confirmDeleteButton" class="save-button">Yes</button>
                    <button id="cancelDeleteButton" class="save-button">No</button>
                </div>
            </div>

            <!-- Delete Event Success Modal -->
            <div id="deleteSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Event successfully deleted!</p>
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

            const setupEditEventModal = () => {
                const modal = document.getElementById('editEventModal');
                const closeBtn = modal.querySelector('.close');
                const editButtons = document.querySelectorAll('.edit');
                const form = document.getElementById('editEventForm');
                const successModal = document.getElementById('successModal');
                const closeSuccessBtn = successModal.querySelector('.close-success-modal');

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        const roomData = ['eventId', 'venue', 'eventType', 'eventPrice', 'eventCapacity', 'eventDescription', 'eventInclusions'];

                        roomData.forEach((field, index) => {
                            document.getElementById(field).value = row.cells[index].innerText;
                        });

                        openModal(modal);
                    });
                });

                assignCloseModalEvent(closeBtn, modal);
                assignOutsideClickEvent(modal);
                handleFormSubmission(form, 'update_event.php', successModal);

                assignCloseModalEvent(closeSuccessBtn, successModal);
                assignOutsideClickEvent(successModal);
            };

            const setupAddEventModal = () => {
                const addEventModal = document.getElementById('addEventModal');
                const addEventSuccessModal = document.getElementById('addEventSuccessModal');
                const openAddEventModalBtn = document.getElementById('openAddEventModalBtn');
                const closeAddEventModalBtn = addEventModal.querySelector('.close');
                const closeSuccessModalBtn = addEventSuccessModal.querySelector('.close-success-modal');
                const addEventForm = document.getElementById('addEventForm');

                openAddEventModalBtn.addEventListener('click', () => {
                    openModal(addEventModal);
                });

                assignCloseModalEvent(closeAddEventModalBtn, addEventModal);
                assignOutsideClickEvent(addEventModal);
                handleFormSubmission(addEventForm, 'add_event.php', addEventSuccessModal);

                assignCloseModalEvent(closeSuccessModalBtn, addEventSuccessModal);
                assignOutsideClickEvent(addEventSuccessModal);
            };

            const setupDeleteEventModal = () => {
                const deleteButtons = document.querySelectorAll('.delete');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const deleteSuccessModal = document.getElementById('deleteSuccessModal');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                const cancelDeleteButton = document.getElementById('cancelDeleteButton');
                let eventToDelete = null;

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        eventToDelete = row.cells[0].innerText;
                        openModal(deleteConfirmationModal);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    fetch('delete_event.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: eventToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(deleteSuccessModal);
                                closeModal(deleteConfirmationModal);
                                document.querySelector(`tr:has(td:contains('${eventToDelete}'))`).remove();
                            } else {
                                alert('Failed to delete the event.');
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

            setupEditEventModal();
            setupAddEventModal();
            setupDeleteEventModal();
        });
    </script>
</body>

</html>