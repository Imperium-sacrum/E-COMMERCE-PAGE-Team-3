<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
  header("Location: ../session/login.php");
  exit();
}
if (isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}
require_once "../db_components/db_connect.php";
require_once "../db_components/file_upload.php";

#query for user 
$sql = "SELECT * FROM users WHERE user_id =" . $_SESSION["admin"];
#run
$result = mysqli_query($connect, $sql);
#fetch
$row = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="generator" content="Hugo 0.122.0" />
  <title>Dashboard Admins</title>

  <link
    rel="canonical"
    href="https://getbootstrap.com/docs/5.3/examples/dashboard/" />

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, 0.1);
      border: solid rgba(0, 0, 0, 0.15);
      border-width: 1px 0;
      box-shadow: inset 0 0.5em 1.5em rgba(0, 0, 0, 0.1),
        inset 0 0.125em 0.5em rgba(0, 0, 0, 0.15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .logo {
      border: solid 0.5px white;
      border-radius: 100%;
      padding: 15px 2px;
    }

    .bi {
      vertical-align: -0.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>

  <!-- Custom styles for this template -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css"
    rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="./styles/dashboard.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Left: Logo -->
        <a>
          <img src="../images/shin2.png" alt="Logo" style="width: 50px; height: 48px;">
        </a>

        <!-- Right: Dropdown -->
        <div class="d-flex align-items-center">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../images/<?= $row['image'] ?>" alt="<?= $row['first_name'] ?>" width="40" height="38" class="d-inline-block align-text-center rounded-circle border border-dark border-3 m-3"> Hey, <?= $row["username"] ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="../session/logout.php?logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>


  <div class="container-fluid">
    <div class="row">
      <div
        class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
        <div
          class="offcanvas-md offcanvas-end bg-body-tertiary"
          tabindex="-1"
          id="sidebarMenu"
          aria-labelledby="sidebarMenuLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
              Company name
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="offcanvas"
              data-bs-target="#sidebarMenu"
              aria-label="Close"></button>
          </div>
          <div
            class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto"
            style="height: 100%">
            <ul class="nav flex-column list-group" role="tablist">
              <li
                class="nav-item list-group-item list-group-item-action active"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  aria-current="page"
                  href="#"
                  id="dashboard">
                  <i class="fa-solid fa-table-columns"></i>Dashboard
                </a>
              </li>
              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <input type="hidden" />
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href=""
                  id="products">
                  <i class="fa-solid fa-cart-shopping"></i> Products
                </a>
              </li>
              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href=""
                  id="categories">
                  <i class="fa-solid fa-list"></i> Products Categories
                </a>
              </li>
              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href="#"
                  id="orders">
                  <i class="fa-regular fa-folder-open"></i>Orders
                </a>
              </li>

              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href="#"
                  id="users">
                  <i class="fa-solid fa-user"></i>Users & Admins
                </a>
              </li>
              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href="#"
                  id="discounts">
                  <i class="fa-solid fa-chart-line"></i>Discounts
                </a>
              </li>
              <li
                class="nav-item list-group-item list-group-item-action"
                data-bs-toggle="list">
                <a
                  class="nav-link d-flex align-items-center gap-2"
                  href="#"
                  id="reviews">
                  <i class="fa-solid fa-comment"></i>Reviews
                </a>
              </li>
            </ul>

            <hr class="my-3" />
            <div class="d-flex justify-content-center" id="createdBtn"></div>
          </div>
        </div>
      </div>

      <main class="col-md-9 ms-sm-auto col-lg-10" id="main"></main>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"></script>
  <script
    src="https://kit.fontawesome.com/5076860948.js"
    crossorigin="anonymous"></script>
  <script src="dashboard.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./chart.js"></script>
</body>

</html>