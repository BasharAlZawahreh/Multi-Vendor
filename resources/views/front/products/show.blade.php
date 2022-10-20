<x-front-layout>
    <x-slot:breadcrumbs>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Single Product</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home.index') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('home.index') }}">Shop</a></li>
                            <li>Single Product</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumbs>

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="{{ $product->image_url }}" id="current" alt="#">
                                </div>
                                <div class="images">
                                    <img src="{{ asset('assets/images/product-details/01.jpg') }}" class="img"
                                        alt="#">
                                    <img src="{{ asset('assets/images/product-details/02.jpg') }}" class="img"
                                        alt="#">
                                    <img src="{{ asset('assets/images/product-details/03.jpg') }}" class="img"
                                        alt="#">
                                    <img src="{{ asset('assets/images/product-details/04.jpg') }}" class="img"
                                        alt="#">
                                    <img src="{{ asset('assets/images/product-details/05.jpg') }}" class="img"
                                        alt="#">
                                </div>
                            </main>
                        </div>
                    </div>
                    
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="text" hidden id="product_id" name="product_id" value="{{ $product->id }}">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="product-info">
                                <h2 class="title">{{ $product->namep }}</h2>
                                <p class="category"><i class="lni lni-tag"></i> {{ $product->category->name }}<a
                                        href="javascript:void(0)">{{ substr($product->category->description, 0, 50) }}...</a>
                                </p>
                                <h3 class="price">
                                    {{ Currency::format($product->price, 'JOD') }}<span>{{ Currency::format($product->compare_price, 'JOD') }}</span>
                                </h3>
                                <p class="info-text">{{ $product->description }}</p>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group color-option">
                                            <label class="title-label" for="size">Choose color</label>
                                            <div class="single-checkbox checkbox-style-1">
                                                <input type="checkbox" id="checkbox-1" checked>
                                                <label for="checkbox-1"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-2">
                                                <input type="checkbox" id="checkbox-2">
                                                <label for="checkbox-2"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3">
                                                <label for="checkbox-3"><span></span></label>
                                            </div>
                                            <div class="single-checkbox checkbox-style-4">
                                                <input type="checkbox" id="checkbox-4">
                                                <label for="checkbox-4"><span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="color">Battery capacity</label>
                                            <select class="form-control" id="color">
                                                <option>5100 mAh</option>
                                                <option>6200 mAh</option>
                                                <option>8000 mAh</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="color">Quantity</label>
                                            <select name="quantity" class="form-control">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="button cart-button">
                                                <button type="submit" class="btn" style="width: 100%;">Add to
                                                    Cart</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="wish-button">
                                                <button class="btn"><i class="lni lni-reload"></i> Compare</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="wish-button">
                                                <form action="{{ route('products.add-to-wishlist', $product->id) }}"
                                                    method="post">
                                                    @csrf

                                                    <button type="submit" class="btn"><i
                                                            class="lni lni-heart"></i>
                                                        To
                                                        Wishlist</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Details</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat.
                                </p>
                                <h4>Features</h4>
                                <ul class="features">
                                    <li>Capture 4K30 Video and 12MP Photos</li>
                                    <li>Game-Style Controller with Touchscreen</li>
                                    <li>View Live Camera Feed</li>
                                    <li>Full Control of HERO6 Black</li>
                                    <li>Use App for Dedicated Camera Operation</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info-body">
                                <h4>Specifications</h4>
                                <ul class="normal-list">
                                    <li><span>Weight:</span> 35.5oz (1006g)</li>
                                    <li><span>Maximum Speed:</span> 35 mph (15 m/s)</li>
                                    <li><span>Maximum Distance:</span> Up to 9,840ft (3,000m)</li>
                                    <li><span>Operating Frequency:</span> 2.4GHz</li>
                                    <li><span>Manufacturer:</span> GoPro, USA</li>
                                </ul>
                                <h4>Shipping Options:</h4>
                                <ul class="normal-list">
                                    <li><span>Courier:</span> 2 - 4 days, $22.50</li>
                                    <li><span>Local Shipping:</span> up to one week, $10.00</li>
                                    <li><span>UPS Ground Shipping:</span> 4 - 6 days, $18.00</li>
                                    <li><span>Unishop Global Export:</span> 3 - 4 days, $25.00</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->

    <!-- Review Modal -->
    <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-name">Your Name</label>
                                <input class="form-control" type="text" id="review-name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-email">Your Email</label>
                                <input class="form-control" type="email" id="review-email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-subject">Subject</label>
                                <input class="form-control" type="text" id="review-subject" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-rating">Rating</label>
                                <select class="form-control" id="review-rating">
                                    <option>5 Stars</option>
                                    <option>4 Stars</option>
                                    <option>3 Stars</option>
                                    <option>2 Stars</option>
                                    <option>1 Star</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review-message">Review</label>
                        <textarea class="form-control" id="review-message" rows="8" required></textarea>
                    </div>
                </div>
                <div class="modal-footer button">
                    <button type="button" class="btn">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Review Modal -->
</x-front-layout>
