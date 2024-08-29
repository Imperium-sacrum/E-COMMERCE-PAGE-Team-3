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
                    <img src="https://cdn.pixabay.com/photo/2015/03/28/17/14/fruit-696169_1280.jpg" class="d-block w-100" alt="Product 1">


                    <div class="carousel-caption d-none d-md-block">
                        <h5>Offers for every taste</h5>
                        <p class="text-white">Save up to 50% on seleced products. 100% Organic</p>
                        <p class="text-white">As long as stock is available</p>
                        <a href="cards.php" class="btn" type="button">Explore now</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.pixabay.com/photo/2017/06/05/17/27/meat-2374652_1280.jpg" class="d-block w-100" alt="Product 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Cold cuts</h5>
                        <p class="text-white">No Artificial Additives | 100% Satisfaction Guaranteed</p>
                        <a href="cards.php" class="btn" type="button">Discover now</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.pixabay.com/photo/2023/07/15/10/52/bread-8128550_1280.jpg" class="d-block w-100" alt="Product 3">
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
        <h1>Best Sellers</h1>
        <div class="categories">
            <ul class="categ-li d-flex flex-row text-dark justify-content-start">
            </ul>
        </div>

        <div class="container-cards section-card mt-5">
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-1 row-cols-xs-1">
                <div class="col">
                    <div class="product-item card">
                        <img src="images/bokbok3.jpg" alt="bobr">
                        <h3>Bobr</h3>
                        <p>€</p>
                    </div>
                </div>
                <div class="col">
                    <div class="product-item card">
                        <img src="images/bokbok3.jpg" alt="bobr">
                        <h3>Bobr</h3>
                        <p>€</p>
                    </div>
                </div>
                <div class="col">
                    <div class="product-item card">
                        <img src="images/bokbok3.jpg" alt="bobr">
                        <h3>Bobr</h3>
                        <p>€</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- whatever you wanna name it section -->
    <div class="container py-4 content-section">
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark">
                    <img src="images/bokbok3.jpg" alt="bobr">
                    <h2>Bobr</h2>
                    <p>Explore our unique selection of Bobr</p>
                    <button class="btn" type="button">Discover More</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-body-tertiary border">
                    <img src="images/bokbok3.jpg" alt="bobr">
                    <h2>Bobr</h2>
                    <p>Check out our most loved products by our loyal customers.</p>
                    <button class="btn" type="button">Shop Now</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>