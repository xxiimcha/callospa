<?php
require 'activity_log.php';

session_start();
include 'callospa_resort_database.php';
include 'callospa_admin_database.php';
include 'LogOut.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, "Accessed Manage Users Page");
}

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
                    <h1>Manage Users</h1>
                    <ul class="breadcrumb">
                        <li><a href="AdministratorPage.php">Dashboard</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="ManageUsers.php">Manage Users</a></li>
                    </ul>
                </div>
            </div>

            <table border="1" cellpadding="10" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Contact Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT id, username, password, contactnum, firstname, lastname, middlename FROM admin1");

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = htmlspecialchars($row['id']);
                            $username = htmlspecialchars($row['username']);
                            $password = htmlspecialchars($row['password']);
                            $contactnum = htmlspecialchars($row['contactnum']);
                            $firstname = htmlspecialchars($row['firstname']);
                            $lastname = htmlspecialchars($row['lastname']);
                            $middlename = htmlspecialchars($row['middlename']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$username</td>";
                            echo "<td>$password</td>";
                            echo "<td>$contactnum</td>";
                            echo "<td>$firstname</td>";
                            echo "<td>$lastname</td>";
                            echo "<td>$middlename</td>";
                            echo "<td>";
                            echo "<button class='edit'>Edit</button>";
                            echo "<button class='delete'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No admins available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Edit Admin Modal -->
            <div id="editAdminModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Admin Details</h2>
                    <form id="editAdminForm">
                        <input type="hidden" id="adminId" name="adminId">

                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required>

                        <label for="contactnum">Contact Number:</label>
                        <input type="tel" id="contactnum" name="contactnum" required>

                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" required>

                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" required>

                        <label for="middlename">Middle Name:</label>
                        <input type="text" id="middlename" name="middlename">

                        <button type="submit" class="save-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Edit Admin Success Modal -->
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Admin details updated successfully!</p>
                </div>
            </div>

            <!-- Password Mismatch Modal -->
            <div id="passwordMismatchModal" class="modal">
                <div class="modal-content">
                    <span id="close-password-mismatch" class="close">&times;</span>
                    <h2>Password Mismatch</h2>
                    <p>The passwords do not match. Please try again.</p>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteConfirmationModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this admin?</p>
                    <button id="confirmDeleteButton" class="save-button">Yes</button>
                    <button id="cancelDeleteButton" class="save-button">No</button>
                </div>
            </div>

            <!-- Delete Success Modal -->
            <div id="deleteSuccessModal" class="modal">
                <div class="modal-content">
                    <span class="close-success-modal">&times;</span>
                    <h2>Success</h2>
                    <p>Admin deleted successfully!</p>
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

            const setupEditAdminModal = () => {
                const modal = document.getElementById('editAdminModal');
                const closeBtn = modal.querySelector('.close');
                const editButtons = document.querySelectorAll('.edit');
                const form = document.getElementById('editAdminForm');
                const successModal = document.getElementById('successModal');
                const closeSuccessBtn = successModal.querySelector('.close-success-modal');
                const passwordMismatchModal = document.getElementById('passwordMismatchModal');
                const closePasswordMismatchBtn = document.getElementById('close-password-mismatch');

                const hideModal = (modal) => {
                    modal.style.display = 'none';
                };

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        const adminData = ['adminId', 'username', 'password', 'contactnum', 'firstname', 'lastname', 'middlename'];

                        adminData.forEach((field, index) => {
                            if (field !== 'password') {
                                document.getElementById(field).value = row.cells[index].innerText;
                            } else {
                                document.getElementById(field).value = '';
                            }
                        });

                        openModal(modal);
                    });
                });

                assignCloseModalEvent(closeBtn, modal);
                assignOutsideClickEvent(modal);
                handleFormSubmission(form, 'update_users.php', successModal);

                closeSuccessBtn.addEventListener('click', () => {
                    successModal.style.display = 'none';
                    location.reload();
                });

                assignCloseModalEvent(closeSuccessBtn, successModal);
                assignOutsideClickEvent(successModal);

                closePasswordMismatchBtn.addEventListener('click', () => {
                    hideModal(passwordMismatchModal);
                });

                assignCloseModalEvent(closePasswordMismatchBtn, passwordMismatchModal);

                window.addEventListener('click', (event) => {
                    if (event.target === passwordMismatchModal) {
                        hideModal(passwordMismatchModal);
                    }
                });

                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;

                    if (password !== confirmPassword) {
                        openModal(passwordMismatchModal);
                        return;
                    }
                });
            };

            const setupDeleteUserModal = () => {
                const deleteButtons = document.querySelectorAll('.delete');
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const deleteSuccessModal = document.getElementById('deleteSuccessModal');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                const cancelDeleteButton = document.getElementById('cancelDeleteButton');
                let userToDelete = null;

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const row = event.target.closest('tr');
                        userToDelete = row.cells[1].innerText;
                        openModal(deleteConfirmationModal);
                    });
                });

                confirmDeleteButton.addEventListener('click', () => {
                    fetch('delete_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                username: userToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                openModal(deleteSuccessModal);
                                closeModal(deleteConfirmationModal);
                                document.querySelector(`tr:has(td:contains('${userToDelete}'))`).remove();
                            } else {
                                alert('Failed to delete the user.');
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

            setupEditAdminModal();
            setupDeleteUserModal();
        });
    </script>
</body>

</html>