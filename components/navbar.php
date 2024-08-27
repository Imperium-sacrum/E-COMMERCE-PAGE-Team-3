<?php
// session_start();

require_once __DIR__ . '/../db_components/db_connect.php';


// Fetch categories from the database
$sqlCategories = "SELECT * FROM product_categories";
$resultCategories = mysqli_query($connect, $sqlCategories);

if (!$resultCategories) {
    die("Query Failed: " . mysqli_error($connect));
}
?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/images/logo4.jpg" alt="Brand Logo" style="height: 60px;">
            AJYKZJ
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <?php
                if (mysqli_num_rows($resultCategories) > 0) {
                    // Loop through each category and create a list item
                    while ($category = mysqli_fetch_assoc($resultCategories)) {
                        echo "<li class='nav-item'>";
                        echo "<a class='nav-link' href='../cards.php?search=" . $category['category_name'] . "'>" . $category['category_name'] . "</a>";
                        echo "</li>";
                    }
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='#'>No Categories</a></li>";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <div class="d-flex align-items-center ms-auto">
                <?php if (!isset($_SESSION['username'])): ?>
                    <a class="btn btn-primary me-3" href="session/login.php" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                        Login
                    </a>
                <?php endif; ?>
                <li class="nav-item dropdown" style="list-style-type: none;">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                        <i class="fa-solid fa-user" style="color: var(--russet); font-size: 1.2rem;"></i>
                        <?php if (!isset($_SESSION['username'])): ?>
                            <span style="color: var(--russet); margin-left: 0.5rem;"><a href="../users/profile.php">Profile</a></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="padding: 10px; border-radius: 5px; background-color: var(--beige);">
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a class="dropdown-item" href="../users/profile.php" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">My account</a></li>
                            <li><a class="dropdown-item" href="session/logout.php?logout" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">Log out</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="session/registration.php" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <div class="cart-icon ms-3">
                    <a href="cart.php">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 290.627 290.627" xml:space="preserve" style="width: 24px; height: 24px;">
                            <g>
                                <g>
                                    <path style="fill:#333333;" d="M67.208,220.313h10.359h8.391h162.909l40.176-140.625h-11.048
                                        c-1.463-29.447-16.589-32.813-23.292-32.813c-6.075,0-10.641,2.348-14.062,5.517v-5.517c0-7.753,6.309-14.063,14.062-14.063
                                        v-9.375c-12.923,0-23.437,10.514-23.437,23.438v5.517c-3.417-3.169-7.983-5.517-14.058-5.517c-4.059,0-11.198,1.247-16.542,8.733
                                        l6.422-27.291c1.622-6.891,0.033-14.03-4.364-19.58S191.742,0,184.663,0c-10.589,0-19.781,7.177-22.35,17.452l-6.478,25.912
                                        c-8.33-17.302-25.987-29.302-46.439-29.302c-28.43,0-51.562,23.133-51.562,51.563c0,4.8,0.717,9.497,2.02,14.063h-6.131
                                        L38.099,14.063H1.583v9.375h29.109l44.644,187.5h-8.128c-12.923,0-23.437,10.514-23.437,23.438s10.514,23.438,23.437,23.438
                                        h0.422c-0.258,1.528-0.422,3.089-0.422,4.688c0,15.511,12.614,28.125,28.125,28.125s28.125-12.614,28.125-28.125
                                        c0-1.598-0.164-3.159-0.422-4.688h66.469c-0.258,1.528-0.422,3.089-0.422,4.688c0,15.511,12.614,28.125,28.125,28.125
                                        s28.125-12.614,28.125-28.125s-12.614-28.125-28.125-28.125c-10.383,0-19.448,5.672-24.319,14.063h-73.237
                                        c-4.87-8.391-13.936-14.063-24.319-14.063s-19.448,5.672-24.319,14.063h-3.806c-7.753,0-14.062-6.309-14.062-14.063
                                        S59.455,220.313,67.208,220.313z M217.208,56.25c10.809,0,14.133,14.888,14.161,15.023c0.45,2.166,2.363,3.727,4.575,3.727
                                        c0.005,0,0.014,0,0.014,0c2.208,0,4.12-1.552,4.584-3.713c0.033-0.15,3.356-15.037,14.166-15.037
                                        c10.552,0,13.355,13.092,13.931,23.438h-65.362C203.854,69.347,206.656,56.25,217.208,56.25z M160.817,62.077l10.589-42.352
                                        c1.523-6.094,6.975-10.35,13.256-10.35c4.2,0,8.105,1.889,10.716,5.18c2.606,3.291,3.548,7.523,2.587,11.616L185.37,79.688
                                        h-26.428c1.298-4.566,2.016-9.262,2.016-14.063c0-1.2-0.098-2.381-0.178-3.563L160.817,62.077z M151.583,65.625
                                        c0,4.828-0.862,9.539-2.47,14.063h-13.805c-1.613-4.514-2.475-9.225-2.475-14.063c0-9.755,3.314-18.975,9.375-26.456
                                        C148.059,46.411,151.583,55.613,151.583,65.625z M135.496,32.545c-7.791,9.267-12.037,20.831-12.037,33.08
                                        c0,4.805,0.713,9.502,2.016,14.063H93.317c1.303-4.561,2.016-9.258,2.016-14.063c0-12.248-4.247-23.813-12.037-33.08
                                        c7.191-5.686,16.247-9.108,26.1-9.108S128.305,26.859,135.496,32.545z M67.208,65.625c0-10.012,3.525-19.214,9.375-26.456
                                        c6.061,7.481,9.375,16.702,9.375,26.456c0,4.838-0.862,9.548-2.47,14.063H69.683C68.071,75.164,67.208,70.453,67.208,65.625z
                                         M55.958,89.063h220.664l-34.823,121.875H85.958h-0.984L55.958,89.063z M217.208,243.75c10.341,0,18.75,8.409,18.75,18.75
                                        s-8.409,18.75-18.75,18.75s-18.75-8.409-18.75-18.75S206.867,243.75,217.208,243.75z M95.333,243.75
                                        c10.341,0,18.75,8.409,18.75,18.75s-8.409,18.75-18.75,18.75s-18.75-8.409-18.75-18.75S84.993,243.75,95.333,243.75z" />
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<?php

?>