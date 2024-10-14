<?php

include 'callospa_resort_database.php';

$title = "Callospa Resort";

$mainHeader = "CALLOSPA";
$subHeader = "Resort";

$mainTitle = "EXPLORE OUR PACKAGES";
$subTitle = "Discover our unique packages, each thoughtfully designed to combine comfort and elegance, ensuring a memorable stay.";

$navLinks = [
    "Home" => "HomePage.php",
    "Packages" => "PackagesPage.php",
    "Rooms" => "RoomsPage.php",
    "Events" => "EventsPage.php",
    "Spa" => "AmenitiesPage.php",
    "Gallery" => "GalleryPage.php",
];

$sqlRoomPackages = "SELECT id, package_name AS name, price, description, images AS image 
                    FROM packages 
                    WHERE id BETWEEN 1 AND 3";

$resultRoomPackages = $conn->query($sqlRoomPackages);

$roomPackages = [];

if ($resultRoomPackages->num_rows > 0) {
    while ($package = $resultRoomPackages->fetch_assoc()) {
        $images = explode(',', $package['image']);
        $package['image'] = !empty($images) ? trim($images[0]) : '';
        $roomPackages[] = $package;
    }
}

$sqlEventPackages = "SELECT id, package_name AS name, price, description, images AS image 
                     FROM packages 
                     WHERE id BETWEEN 4 AND 9";

$resultEventPackages = $conn->query($sqlEventPackages);

$eventPackages = [];

if ($resultEventPackages->num_rows > 0) {
    while ($package = $resultEventPackages->fetch_assoc()) {
        $images = explode(',', $package['image']);
        $package['image'] = !empty($images) ? trim($images[0]) : '';
        $eventPackages[] = $package;
    }
}

$sqlSpaPackages = "SELECT id, package_name AS name, price, description, images AS image 
                   FROM packages 
                   WHERE id BETWEEN 10 AND 15";

$resultSpaPackages = $conn->query($sqlSpaPackages);

$spaPackages = [];

if ($resultSpaPackages->num_rows > 0) {
    while ($package = $resultSpaPackages->fetch_assoc()) {
        $images = explode(',', $package['image']);
        $package['image'] = !empty($images) ? trim($images[0]) : '';
        $spaPackages[] = $package;
    }
}

$conn->close();

$contactInfo = [
    "name" => "Callospa Resort",
    "email" => "callos.realty.leasing@gmail.com",
    "address" => "H599+3gf, Marigman Rd, Antipolo, 1870, Rizal",
    "phone" => "+63 9178243715 / +63 983560798"
];
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
    <link rel="stylesheet" href="css/style.css">
    <title>Callospa Resort - List of Packages</title>
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
                        <?php foreach ($navLinks as $name => $link): ?>
                            <li class="nav-item">
                                <a href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>"
                                    class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == $link ? 'active' : ''; ?>">
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
        <section class="section-hero section-hero--package">
            <header class="header--hero">
                <h1 class="heading heading-primary u-margin-bottom-md"><?php echo htmlspecialchars($mainTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="u-margin-bottom-xl"><?php echo htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>
        </section>

        <section class="section">
            <div class="u-container">
                <div class="packages">
                    <div class="packages-tab-container">
                        <button class="btn btn-package btn-package--room btn-package-active" data-tab="room">Room Packages</button>

                        <button class="btn btn-package btn-package--event" data-tab="event">Event Packages</button>

                        <button class="btn btn-package btn-package--spa" data-tab="spa">Spa Packages</button>
                    </div>

                    <div class="packages-content packages-content--room packages-content-active">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-secondary u-margin-bottom-md">Room Packages</h2>
                            <p>Browse our exclusive packages, each crafted to deliver a unique blend of comfort and style, making your stay truly unforgettable.</p>
                        </div>
                        <div class="grid grid-3-cols">
                            <?php if (!empty($roomPackages)): ?>
                                <?php foreach ($roomPackages as $package): ?>
                                    <article class="card">
                                        <img class="card-img" src="<?php echo htmlspecialchars($package['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>" />
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                            <p class="card-price">Php <?php echo htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p class="card-desc"><?php echo htmlspecialchars($package['description']); ?></p>
                                            <a href="PackagesReservationForm.php" class="card-btn">Book Now</a>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No Room Packages Found.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="packages-content packages-content--event">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-secondary u-margin-bottom-md">Event Packages</h2>
                            <p>Browse our exclusive packages, each crafted to deliver a unique blend of comfort and style, making your stay truly unforgettable.</p>
                        </div>
                        <div class="grid grid-3-cols">
                            <?php if (!empty($eventPackages)): ?>
                                <?php foreach ($eventPackages as $package): ?>
                                    <article class="card">
                                        <img class="card-img" src="<?php echo htmlspecialchars($package['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>" />
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                            <p class="card-price">Php <?php echo htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p class="card-desc"><?php echo htmlspecialchars($package['description']); ?></p>
                                            <a href="PackagesReservationForm.php" class="card-btn">Book Now</a>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No Event Packages Found.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="packages-content packages-content--spa">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-secondary u-margin-bottom-md">Spa Packages</h2>
                            <p>Browse our exclusive packages, each crafted to deliver a unique blend of comfort and style, making your stay truly unforgettable.</p>
                        </div>
                        <div class="grid grid-3-cols">
                            <?php if (!empty($spaPackages)): ?>
                                <?php foreach ($spaPackages as $package): ?>
                                    <article class="card">
                                        <img class="card-img" src="<?php echo htmlspecialchars($package['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>" />
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                            <p class="card-price">Php <?php echo htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p class="card-desc"><?php echo htmlspecialchars($package['description']); ?></p>
                                            <a href="PackagesReservationForm.php" class="card-btn">Book Now</a>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No Spa Packages Found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
    <script src="js/script.js"></script>
</body>

</html>