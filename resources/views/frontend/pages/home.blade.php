@extends('frontend.layout.app')
@push('header')
    <style>
        #news .owl-stage {
            display: flex;
        }
    </style>
@endpush
@section('content')
    <section style="padding: 0;" id="hero" class="d-flex align-items-center bg-secondary">
        <div id="carouselExampleAutoplaying" class="home-carousel carousel slide w-100" data-pause="false"
            data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banners as $banner)
                    <button type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide-to="{{ $loop->iteration - 1 }}" class="@if ($loop->iteration == 1) active @endif"
                        aria-current="true" aria-label="Slide-{{ $loop->iteration }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($banners as $banner)
                    <div class="carousel-item @if ($loop->iteration == 1) active @endif">
                        <img src="{{ asset('uploads/resource-images/' . $banner->image) }}" class="d-block w-100"
                            alt="...">
                        <div class="home-banner-inner">

                            <h4 class="inner-header" style="color:{{ $banner->title_color }}">{{ $banner->title }}</h4>
                            <p class="inner-pragraph" style="color: {{ $banner->details_color }}">{{ $banner->details }}</p>
                            @if ($banner->button_text != null)
                                <div class="button-area">
                                    <a href="{{ $banner->link }}" class="btn btn-slider"
                                        style="background-color: {{ $banner->button_color }}; color: #ffffff;">{{ $banner->button_text }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="partners">
        <h1 class="section-heading text-light">{{ trans('language.proud_partners') }}</h1>
        <div class="section-heading-underline"></div>
        <div class="partners-img-container container">
            @foreach ($partners as $partner)
                <div class="partner-logo-area">
                    <a href="{{ route('brand.products', $partner->slug) }}"><img class="img-fluid"
                            src="{{ asset('uploads/brand-images/' . $partner->image) }}" title="{{ $partner->title }}"
                            alt="{{ $partner->title }}"></a>
                </div>
            @endforeach
        </div>
    </section>

    <section id="product-category">
        <h1 class="section-heading">{{ trans('language.product_category') }}</h1>
        <div class="section-heading-underline"></div>
        <div class="product-category__card-container container">
            <div class="owl-carousel owl-theme" id="feature_category_carousel">
                @foreach ($categories as $category)
                    <div class="item">
                        <div class="card">
                            <a href="{{ url('category/' . $category->slug) }}">
                                <img src="{{ asset('uploads/category-images/' . $category->image) }}" alt="">
                                <p class="text-uppercase">
                                    {{ $category->getTranslation(Session::get('language') ?? 'en', 'title') }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <section class="home__products__section pt-0">
        <h1 class="section-heading text-center">{{ trans('language.featured_products') }}</h1>
        <div class="section-heading-underline"></div>
        <div class="container">
            <div class="owl-carousel owl-theme" id="feature_product_carousel">
                @foreach ($products as $product)
                    <div class="item h-100">
                        <a href="{{ url('product/' . $product->slug) }}">
                            <div class="card product-cart">
                                <img src="{{ asset('uploads/product-images/' . $product->thumbnail) }}" alt=""
                                    loading="lazy">
                                <p title="{{ $product->name }}"
                                    class="product-title text-uppercase text-center d-flex flex-column">
                                    <span>{{ Str::limit($product->getTranslation(Session::get('language') ?? 'en', 'name') ?? $product->name, 25, '...') }}</span>
                                    <small>Item Code: {{ $product->code }}</small>
                                    @php
                                        $feature_product_attributes = Cache::remember(
                                            "feature_product_attributes_{$product->id}",
                                            now()->addHours(1),
                                            function () use ($product) {
                                                return $product->attributes;
                                            },
                                        );
                                    @endphp
                                    @if (count($feature_product_attributes) > 0)
                                        <small class="text-capitalize">
                                            @foreach ($feature_product_attributes as $attribute)
                                                @if ($attribute->is_filter == 1)
                                                    {{ $attribute->attribute_name }}: {{ $attribute->value }},
                                                @endif
                                            @endforeach
                                        </small>
                                    @endif
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="services" class="pt-4 pb-4">
        <h1 class="section-heading text-light">{{ trans('language.services') }}</h1>
        <div class="section-heading-underline white"></div>
        <div class="container">
            <div class="services__card--wrapper">
                <div class="owl-carousel owl-theme" id="feature_service_carousel">
                    @foreach ($services as $item)
                        <div class="item h-100">
                            <a href="{{ route('service.details', $item->slug) }}">
                                <div class="card text-center ">
                                    <div class="img__hover--effect">
                                        <img class="img-fluid" src="{{ asset('uploads/service-images/' . $item->media) }}"
                                            alt="" loading="lazy">
                                    </div>
                                    <p class="text-uppercase custom-tooltip"
                                        title="{{ $item->getTranslation(Session::get('language') ?? 'en', 'title') ?? $item->title }}">
                                        {{ Str::limit($item->getTranslation(Session::get('language') ?? 'en', 'title') ?? $item->title, 100, '...') }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="news">
        <h1 class="section-heading">{{ trans('language.news') }}</h1>
        <div class="section-heading-underline"></div>
        <div class="news_card-container container">
            <div class="owl-carousel owl-theme" id="feature_news_carousel">
                @foreach ($newses as $news)
                    <div class="item h-100 p-2">
                        <div class="new--card">
                            <div>
                                <a class="news__img--container" href="{{ route('news.details', $news->slug) }}"> <img
                                    src="{{ asset('uploads/news-images/' . $news->media) }}" alt=""
                                    loading="lazy"></a>
                            <h5>{{ \Illuminate\Support\Str::words($news->getTranslation(Session::get('language') ?? 'en', 'title') ?? $news->title, 10, '...') }}
                            </h5>
                            <p>{{ \Illuminate\Support\Str::limit($news->getTranslation(Session::get('language') ?? 'en', 'short_description') ?? $news->short_description, 100) }}
                            </p>
                            </div>
                            <div>
                                <a href="{{ route('news.details', $news->slug) }}">{{ __('language.btn_read_more') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('footer')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#feature_product_carousel').owlCarousel({
                    loop: true,
                    nav: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 1
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: 5
                        }
                    }
                })

                $('#feature_category_carousel').owlCarousel({
                    loop: true,
                    nav: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 1
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: 5
                        }
                    }
                })
                $('#feature_service_carousel').owlCarousel({
                    loop: true,
                    nav: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        }
                    }
                })

                $('#feature_news_carousel').owlCarousel({
                    loop: true,
                    nav: true,
                    margin: 10,
                    autoplay: false,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        }
                    }
                })
            });
        </script>
    @endpush
@endsection
