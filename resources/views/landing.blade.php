<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="{{favicon(settings('favicon'))}}">
    <!-- ---- add bootstrap css ----- -->
    <link rel="stylesheet" href="{{asset('landing')}}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('landing')}}/icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('landing')}}/icons/themify-icons/css/themify-icons.css">

    <link rel="stylesheet" href="{{asset('landing')}}/css/style.css">
    <title>Parcelfly - Parcel Delivery Application & Website</title>
</head>
<body>
    <header class="bg-color">
        <div class="container">
            <nav class="navbar navbar-expand-lg py-4">
                <div class="container-fluid d-flex justify-content-between">
                    <a class="navbar-brand m-0" href="#">
                        <img src="{{asset('landing')}}/images/logo.png" alt="">
                    </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#features">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="https://bugbuild.com/delivery-doc/">Documentation</a>
                            </li>
                        </ul>
                    </div>
                    <a class="custom-btn d-none d-lg-block" target="_blank" href="https://delivery.bugbuild.com/">Demo</a>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="bg-color mb-5">
            <div class="container py-5">
                <div class="row py-5">
                    <div class="slide-info col-12 col-lg-6">
                        <h1 class="mb-3">We Have Faster Delivery in Your House</h1>
                        <p class="mb-5">Delivery your package quickly cheaply and easily only here, We prioritize the safety of your package. With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                        <a class="custom-btn" target="_blank" href="https://delivery.bugbuild.com/">Frontend Demo</a>
                        <a class="custom-btn" target="_blank" href="https://delivery.bugbuild.com/signin">Admin Demo</a>
                    </div>
                    <div class="left-img col-lg-6 d-none d-lg-block">
                        <img src="{{asset('landing')}}/images/Rectangle_3.png" alt="">
                    </div>
                </div>

            </div>
        </div>

        <!-- Highlight Features start -->

        <div class="container py-5" id="features">
            <h2 class="text-center mb-60">Highlight Features</h2>
            <div class="row " >
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(6).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Full Dynamic Application</h6>
                            <p>Dynamic features swiftly adapt to user interactions and real-time data changes, ensuring an impeccably seamless and responsive user experience</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(1).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Multi Language</h6>
                            <p>supporting multiple languages, allowing users from diverse linguistic backgrounds to access and interact with the interface in their preferred language effortlessly</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(7).png" alt="">
                        </div>
                        <div class="info">
                            <h6>RTL Support</h6>
                            <p>Full support for right-to-left (RTL) languages, ensuring that users can comfortably navigate and interact with the interface in languages such as Arabic, Hebrew, and Urdu</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(6).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Role Based Permissions</h6>
                            <p>Control over user access, allowing administrators to assign specific roles and permissions to individuals or groups based on their responsibilities</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(6).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Dynamic Parcel Charged System</h6>
                            <p>Dynamic pricing calculates charges based on weight, destination, delivery time, and market conditions, ensuring fair customer pricing</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(3).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Powerful Admin Dashboard</h6>
                            <p>A robust admin dashboard consolidates comprehensive tools for efficient user management, parcel tracking, and profit analysis and much more into a single platform.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(5).png" alt="">
                        </div>
                        <div class="info">
                            <h6>User Panel</h6>
                            <p>Very user-friendly interface dashboard enables easy navigation. Users manage accounts, track parcels, and perform tasks seamlessly from the panel</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(4).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Unlimited Parcel Create</h6>
                            <p>empowers users with the ability to create parcels with no restrictions, limitless parcel creation to accommodate varying business needs and shipment volumes</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex features-item">
                        <div class="icon">
                            <img src="{{asset('landing')}}/images/icon1(2).png" alt="">
                        </div>
                        <div class="info">
                            <h6>Order Tracking</h6>
                            <p>Comprehensive order tracking allows Administrators/users to monitor parcel status in real-time, ensuring transparency and peace of mind during shipping</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Highlight Features end -->

        <!-- Our Delivery Process start -->
        <div class="bg-color mb-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2>We Have Faster Delivery in Your House</h2>
                        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Finibus Bonorum et Malorum Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="parcel-info">
                            <div class="bg-red icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <span class="tx-red">Parcel Placed</span>
                                <p class="mb-0">Your order has being placed</p>
                            </div>
                        </div>
                        <div class="parcel-info">
                            <div class="bg-pr icon">
                                <i class="ti-package"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <span class="tx-pr">Parcel Received</span>
                                <p class="mb-0">Your order has being placed</p>
                            </div>
                        </div>
                        <div class="parcel-info">
                            <div class="bg-ylw icon">
                                <i class="ti-loop"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <span class="tx-ylw">Process</span>
                                <p class="mb-0">Your order has being placed</p>
                            </div>
                        </div>
                        <div class="parcel-info">
                            <div class="bg-pr icon">
                                <i class="ti-truck"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <span class="tx-pr">Your Parcel is shipped</span>
                                <p class="mb-0">Your order has being placed</p>
                            </div>
                        </div>
                        <div class="parcel-info">
                            <div class="bg-gr icon">
                                <i class="ti-check-box"></i>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <span class="tx-gr">Delivered</span>
                                <p class="mb-0">Your order has being placed</p>
                            </div>
                        </div>
                    </div>
                    <div class="left-img col-lg-8 d-none d-lg-block">
                        <img src="{{asset('landing')}}/images//Group10.png" alt="">
                    </div>
                </div>

            </div>
        </div>
        <!-- Our Delivery Process end -->
        <!-- Advance Features start -->
        <div class="container text-center py-5">
            <h2>Advance Features</h2>
            <p class="mb-60">With lots of unique blocks, you can easily build a page without coding. </p>
            <div class="row">
                <div class="col-12 col-md-6 mb-60">
                    <div class="advance-features">
                        <img src="{{asset('landing')}}/images/Frame1.png" alt="">
                        <div class="info">
                            <h6>Unique Web Design</h6>
                            <p>Facilitates order processing, payment transactions, and receipt generation.
                                Tracks sales data, helping to analyze popular items and trends.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-60">
                    <div class="advance-features">
                        <img src="{{asset('landing')}}/images/Frame(1).png" alt="">
                        <div class="info">
                            <h6>Powerful Admin Panel</h6>
                            <p>Facilitates order processing, payment transactions, and receipt generation.
                                Tracks sales data, helping to analyze popular items and trends.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-60">
                    <div class="advance-features">
                        <img src="{{asset('landing')}}/images/Frame(2).png" alt="">
                        <div class="info">
                            <h6>RTL Support</h6>
                            <p>Facilitates order processing, payment transactions, and receipt generation.
                                Tracks sales data, helping to analyze popular items and trends.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-60">
                    <div class="advance-features">
                        <img src="{{asset('landing')}}/images/Frame(3).png" alt="">
                        <div class="info">
                            <h6>Parcel Tracking</h6>
                            <p>Facilitates order processing, payment transactions, and receipt generation.
                                Tracks sales data, helping to analyze popular items and trends.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Advance Features end -->
        <!-- Video Solution start -->

    </main>
    <footer>
    <div class="bg-color">
        <div class="container text-center py-5">
            <img src="{{asset('landing')}}/images/logo.png" alt="logo">
            <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Finibus Bonorum et Malorum Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a class="custom-btn" target="_blank" href="https://delivery.bugbuild.com/">Frontend Demo</a>
                <a class="custom-btn" target="_blank" href="https://delivery.bugbuild.com/signin">Admin Demo</a>
                <a class="custom-btn" target="_blank" href="https://delivery.bugbuild.com/parcel/track">Live Tracking</a>
            </div>
        </div>
        <hr>
        <p class="text-center py-4 m-0">{{settings('copyright')}}</p>
    </div>
    </footer>
    <!-- ---- add bootstrap script ----- -->
    <script src="{{asset('landing')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
