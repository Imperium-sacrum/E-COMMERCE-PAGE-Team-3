<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/team3icon.jpg" alt="Brand Logo" style="height: 50px;">
                The Debugged Deli
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Meat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Vegetables</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Beverages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Snacks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Desserts</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center ms-auto">
                    <div class="search-bar me-3">
                        <input type="text" placeholder="Search">
                        <button type="button">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <a class="btn btn-primary me-3" href="login.php" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                        Login
                    </a>

                    <li class="nav-item dropdown" style="list-style-type: none;">
                        <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false" style="display: flex; align-items: center;">
                            <i class="fa-solid fa-user" style="color: var(--russet); font-size: 1.2rem;"></i> 
                            <span style="color: var(--russet); margin-left: 0.5rem;">Profile</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="padding: 10px; border-radius: 5px; background-color: var(--beige);">
                            <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])): ?>
                                <li><a class="dropdown-item" href="profile.php">My account</a></li>
                                <li><a class="dropdown-item" href="logout.php?logout">Log out</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="registration.php" style="background-color: var(--dark-olive-green); border-color: var(--dark-olive-green); color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>