<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/footer.css">
    <title>Document</title>
</head>

<body>
    <style>
        #map {
            border-radius: 5px;
        }
    </style>

    <footer>
        <div class="container">
            <div class="row py-5">

                <!-- About Section -->
                <div class="col-6 col-md-2 mb-3">
                    <h5>ABOUT</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Our Story</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Our Suppliers</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Sustainability</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Careers</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Blog</a></li>
                    </ul>
                </div>

                <!-- Customer Service Section -->
                <div class="col-6 col-md-2 mb-3">
                    <h5>CUSTOMER SERVICE</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Order Tracking</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Shipping Information</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Returns & Exchanges</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Subscription Form -->
                <div class="col-md-4 mb-3">
                    <h5>Subscribe to Our Newsletter</h5>
                    <p>Get the latest updates on new products and upcoming sales.</p>
                    <form>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                            <input id="newsletter1" type="email" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                        <small>By subscribing, you agree to our Privacy Policy and Terms.</small>
                    </form>


                </div>
                <div id="map" class="m-2" style="height: 350px; width: 100%;"></div>
            </div>


            <!-- Bottom Footer Links -->
            <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                <p>&copy; 2024 Team3. All rights reserved.</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Terms & Conditions</a></li>
                    <li class="list-inline-item"><a href="#">Accessibility</a></li>
                    <li class="list-inline-item"><a href="#">Your Privacy Choices</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // iniziali a new map function
        function initMap() {
            // coordinate for code factory location from google
            const ourLocation = {
                lat: 48.19679697492332,
                lng: 16.359630573899167
            };

            //center and  zoom a map
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: ourLocation,
            });

            // marker for our location
            const marker = new google.maps.Marker({
                position: ourLocation,
                map: map,
                icon: {
                    url: '../images/green-areas.png',
                    scaledSize: new google.maps.Size(50, 50),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(25, 50)
                }
            });
        }
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzOtc6wgsDmp0F1oGdj4hC-tW_aCEjsIA&callback=initMap">
    </script>
</body>

</html>