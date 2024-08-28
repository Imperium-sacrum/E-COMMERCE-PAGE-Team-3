<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/hero.css">
    <title>hero</title>
</head>

<body>
    <div class="hero">
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img style="object-fit: cover; filter:brightness(0.7)" src="images/slide.jpg" class="d-block w-100" alt="Product 1">


                    <div class="carousel-caption d-none d-md-block">
                        <h5>Offers for every taste</h5>
                        <p class="text-white">Save up to 50% on seleced products. 100% Organic</p>
                        <p class="text-white">As long as stock is available</p>
                        <a href="cards.php" class="btn" type="button">Explore now</a>
                    </div>
                </div>
                <div class="carousel-item ">
                    <img src="images/meat.jpg" style="object-fit: cover; filter:brightness(0.7)" class="d-block w-100" alt="Product 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Cold cuts</h5>
                        <p class="text-white">No Artificial Additives | 100% Satisfaction Guaranteed</p>
                        <a href="cards.php" class="btn" type="button">Discover now</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.pixabay.com/photo/2023/07/15/10/52/bread-8128550_1280.jpg" style="object-fit: cover; filter:brightness(0.7)" class="d-block w-100" alt="Product 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Whole Grains</h5>
                        <p class="text-white">100% Whole grains goodness for a healthier more nutrious choice</p>
                        <a href="cards.php" class="btn" type="button">Shop now</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <section class="favorites-section">
        <h1 style="font-weight: 600;" class="py-5">Shop<span style="color: #783D19; font-size: 80px"> . </span> Eat<span style="color: #B99470; font-size: 80px"> . </span>Repeat <span style="color: #A9B388; font-size: 80px"> . </span></h1>
        <div class="container mt-5">
            <div class="row">

                <div class="col-md-3">
                    <div class="card-hero position-relative overflow-hidden">
                        <img src="images/hero2.jpg" style="height: 300px; object-fit: cover;" class="card-img-top" alt="Image 1">
                        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center p-4 bg-dark bg-opacity-50 text-white">
                            <p class="card-title-hero text-white text-center">Fresh Flavors,</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-hero position-relative overflow-hidden">
                        <img src="images/hero3.jpg" style="height: 300px; object-fit: cover;" class="card-img-top" alt="Image 2">
                        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center p-4 bg-dark bg-opacity-50 text-white">
                            <p class="card-title-hero text-white text-center">Delivered Fast.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-hero position-relative overflow-hidden">
                        <img src="images/hero1.png" style="height: 300px; object-fit: cover;" class="card-img-top" alt="Image 3">
                        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center p-4 bg-dark bg-opacity-50 text-white">
                            <p class="card-title-hero text-white text-center">Your Plate</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-hero position-relative overflow-hidden">
                        <img src="images/hero5.jpg" style="height: 300px; object-fit: cover;" class="card-img-top" alt="Image 4">
                        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center p-4 bg-dark bg-opacity-50 text-white">
                            <p class="card-title-hero text-white text-center">Our Priority.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="container-fluid content-section">
        <div class="d-flex">
            <div class="col-md-6">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/hero6.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#5F6F52;">ALKOHOLS</h2>
                        <p style="font-size: 0.9rem;">Explore our unique selection of Alkohols from different countries.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Discover more</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/gre.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#5F6F52">FRUITS</h2>
                        <p style="font-size: 0.9rem;">Check out our most loved fruits by our loyal customers.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- last  -->


    <div class="container-fluid content-section">
        <div class="d-flex">


            <div class="col-md-6 ">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/cake.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#9b4c7b;">SWEETNEES</h2>
                        <p style="color:antiquewhite ;font-size: 0.9rem;">Explore our unique selection of Alkohols from different countries.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Discover more</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/tort.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#9b4c7b">CAKES</h2>
                        <p style="color:antiquewhite; font-size: 0.9rem;">Check out our most loved fruits by our loyal customers.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TEST -->
    <div class="container-fluid content-section">
        <div class="d-flex">
            <div class="col-md-6">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/herbs.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#5F6F52;">HERBS</h2>
                        <p style="font-size: 0.9rem;">Explore our unique selection of Alkohols from different countries.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Discover more</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="h-100 position-relative overflow-hidden text-white" style="max-height: 300px;">
                    <img src="images/spices.jpg" alt="bobr" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start p-3 bg-dark bg-opacity-50">
                        <h2 style="font-size: 2rem; color:#5F6F52">SPICES</h2>
                        <p style="font-size: 0.9rem;">Check out our most loved fruits by our loyal customers.</p>
                        <a class="btn btn-sm" href="cards.php" style="font-size: 0.85rem;">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>