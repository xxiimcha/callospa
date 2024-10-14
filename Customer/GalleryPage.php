<?php
$title = "Callospa Resort";

$mainHeader = "CALLOSPA";
$subHeader = "Resort";

$mainTitle = "DISCOVER SERENITY AND ELEGANCE";
$subTitle = "Explore our gallery to experience the ultimate in relaxation and luxury. From our beautifully appointed rooms and stunning event spaces to our exceptional amenities, see for yourself why our bed and breakfast retreat is the perfect haven. Reserve your spot and immerse yourself in tranquility today!";

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
    <title>Callospa Resort - Discover Serenity and Elegance</title>
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
        <section class="section-hero section-hero--gallery">
            <header class="header--hero">
                <h1 class="heading heading-primary u-margin-bottom-md"><?php echo htmlspecialchars($mainTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="u-margin-bottom-xl"><?php echo htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>
        </section>


        <section class="section">
            <div class="u-container">
                <div class="u-text-center u-margin-bottom-xl">
                    <h2 class="heading heading-secondary u-margin-bottom-md">
                        Our Gallery
                    </h2>
                    <p>
                        Step into a visual journey through our stunning spaces, where
                        elegance meets serenity. Discover the beauty of our resort through
                        our carefully curated gallery.
                    </p>
                </div>

                <div class="gallery">
                    <div class="gallery-tab-container">
                        <button
                            class="btn btn-gallery btn-gallery--room btn-gallery-active"
                            data-tab="room">
                            Rooms
                        </button>
                        <button class="btn btn-gallery btn-gallery--space" data-tab="space">
                            Events
                        </button>
                        <button
                            class="btn btn-gallery btn-gallery--amenity"
                            data-tab="amenity">
                            Spa
                        </button>
                    </div>

                    <div
                        class="gallery-content gallery-content--room gallery-content-active">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-tertiary u-margin-bottom-md">
                                Feature Rooms
                            </h2>
                            <p>
                                Discover our finest accomodations, where luxury and comfort
                                converge. Each room is thoughtfully designed to provide an
                                exceptional experience, tailored to meet your highest
                                expectations.
                            </p>
                        </div>

                        <div class="gallery-grid">
                            <div class="gallery-grid-item-1">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-rid-item-2">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-3">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-4">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-5">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-6">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-7">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-8">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-9">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-10">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                        </div>
                    </div>

                    <div class="gallery-content gallery-content--space">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-tertiary u-margin-bottom-md">
                                Event Spaces
                            </h2>
                            <p>
                                Host your special occasions in our elegant event spaces,
                                perfectly designed to make every moment unforgettable. From
                                intimate gatherings to grand celebrations, our versatile venues
                                offer the ideal setting for your event.
                            </p>
                        </div>

                        <div class="gallery-grid">
                            <div class="gallery-grid-item-1">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-2">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-3">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-4">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-5">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-6">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-7">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-8">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-9">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-10">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                        </div>
                    </div>

                    <div class="gallery-content gallery-content--amenity">
                        <div class="u-text-center u-margin-bottom-xl">
                            <h2 class="heading heading-tertiary u-margin-bottom-md">
                                Spa Service
                            </h2>
                            <p>
                            Discover our exceptional spa services designed to enhance your relaxation experience. 
                            Indulge in luxurious treatments, unwind in our serene environment, 
                            and rejuvenate your mind and body with our expert spa offerings.
                            </p>
                        </div>

                        <div class="gallery-grid">
                            <div class="gallery-grid-item-1">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-2">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-3">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-4">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-5">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-6">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-7">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-8">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-9">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
                            <div class="gallery-grid-item-10">
                                <img src="images/1.jpg" alt="" class="grid-img" />
                            </div>
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
    <script src="js/gallery.js"></script>
</body>

</html>