<x-front-layout>
    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Your Cart</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($cart->get() as $i => $item)
                    <!-- Start Single Product -->
                    <div class="col-lg-3 col-md-6 col-12">

                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ $item->product->image_url }}" alt="#">
                               @if ($item->product->sale_percent)
                                <span class="price-dec">-{{ $item->product->sale_percent }}%</span>
                               @endif
                            </div>
                            <div class="product-info">
                                <span class="category">{{ $item->product->category->name }}</span>
                                <h4 class="title">
                                    <a
                                        href="{{ route('front.products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                </h4>
                                <ul class="review">
                                    {{ $item->product->rating * 5 }}
                                    @for ($x = 0; $x < $item->product->rating * 5 - 1; $x++)
                                        <li><i class="lni lni-star-filled"></i></li>
                                    @endfor
                                    @for ($x = 0; $x < 5 - $item->product->rating * 5; $x++)
                                        <li><i class="lni lni-star"></i></li>
                                    @endfor
                                </ul>
                                <div class="price">
                                    <span>{{ Currency::format($item->product->price * $item->quantity) }}</span>
                                </div>
                                <div class="form-controll">
                                    <input type="text" value="{{$item->quantity}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                @endforeach

            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="price">
            Total:    {{Currency::format($cart->total())}}
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->
</x-front-layout>
