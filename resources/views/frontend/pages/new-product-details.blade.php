@extends('frontend.layout.app')
<meta property="og:url" content="{{ url('product/' . $product->id) }}">
<meta property="og:type" content="Website" />
<meta property="og:title" content="{{ $product->name ?? '' }}">
<meta property="og:image" content="{{ asset('uploads/product-images/' . $product->thumbnail) }}">
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="600" />
<meta property="product:brand" content="{{ $product->brand->title ?? '' }}">
<meta property="product:condition" content="new">

<meta property="product:price:currency" content="USD">
@push('header')
    <style>
        #product_image_slider .owl-stage-outer {
            display: flex;
            justify-content: center;
        }
    </style>
@endpush
@section('content')
    <div class="modal fade" id="image_zoom_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div>
                        <div class="owl-carousel owl-theme" id="image_zoom_modal_slider">
                            <div class="item d-flex justify-content-center">
                                <img class="zoom_image" src="{{ asset('uploads/product-images/' . $product->thumbnail) }}"
                                    height="100%" width="100%" alt="">
                            </div>
                            @if ($product->images != null && count($product->images) > 0)
                                @foreach ($product->images as $image)
                                    <div class="item d-flex justify-content-center">
                                        <img class="zoom_image" src="{{ asset('uploads/product-images/' . $image) }}"
                                            height="100%" width="100%" alt="">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="productDetails">
        <div class="breadcrumb__nk">
            <div class="container"><a href="{{ route('home') }}" class="text-light">{{ trans('language.home') }} </a> / <a
                    href="{{ route('products') }}" class="text-light">{{ trans('language.products') }}</a> /
                {{ $product->getTranslation(Session::get('language') ?? 'en', 'name') ?? $product->name }}
            </div>
        </div>

        <div class="container go_back_container">
            <!--<a href="{{ URL::previous() }}"><i class="fa-solid fa-angle-left"></i> {{ trans('language.go_back') }}</a>-->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 productDetails_img_wrapper" style="overflow: hidden;">
                    <div class="d-block d-lg-none">
                        <h3 class="productDetails_title">
                            {{ $product->getTranslation(Session::get('language') ?? 'en', 'name') ?? $product->name }}</h3>
                        <p class="productDetails_code">{{ trans('language.product_code') }} - {{ $product->code }}</p>
                    </div>
                    <div class="productDetails__price__order d-block d-lg-none">
                        <div class="price__section">
                            {{-- @if (auth()->check() && $product->price > 0) --}}
                            @if (auth()->check() && $product->price > 0)
                                @if (auth()->user()->role == 2 && $product->show_price == 1)
                                    <h5 class="price">Price: ${{ Helper::priceAfterOffer($product->id) }}</h5>
                                    @if (Helper::priceAfterOffer($product->id) < $product->price)
                                        <p class="price__discount"> {{ trans('language.old_price') }}:
                                            <del>${{ $product->price }}</del>
                                    @endif
                                    </p>
                                @elseif (auth()->user()->role != 2 && $product->show_price_to_partner == 1)
                                    <h5 class="price">Price: ${{ Helper::priceAfterOffer($product->id) }}</h5>
                                    @if (Helper::priceAfterOffer($product->id) < $product->price)
                                        <p class="price__discount"> {{ trans('language.old_price') }}:
                                            <del>${{ $product->price }}</del>
                                    @endif
                                </p>
                                @endif
                            @endif
                        </div>

                        <div class="order__btn__area">

                            {{-- @if (auth()->check() && auth()->user()->role == 1)
        
                            @else --}}
                            
                            {{-- @if (auth()->check() && $product->price) --}}
                            @if (auth()->check() && $product->price > 0)
                                @if (auth()->user()->role == 2 && $product->show_price == 1)
                                    <a href="{{ route('add.to.cart', ['type' => 'product', 'id' => $product->id]) }}" class="btn order__btn add-to-cart">{{ trans('language.btn_order') }}</a>
                                @elseif(auth()->user()->role != 2 && $product->show_price_to_partner == 1)
                                    <a href="{{ route('add.to.cart', ['type' => 'product', 'id' => $product->id]) }}" class="btn order__btn add-to-cart">{{ trans('language.btn_order') }}</a>
                                @else
                                    <a href="{{ route('add.to.inquiry', $product->id) }}" class="btn inquiry__btn">{{ trans('language.btn_add_to_inquiry_list') }}</a>
                                @endif
                            @else
                                <a href="{{ route('add.to.inquiry', $product->id) }}" class="btn inquiry__btn">{{ trans('language.btn_add_to_inquiry_list') }}</a>
                            @endif
                            <a href="{{ route('add.to.wishlist', ['type' => 'product', 'id' => $product->id]) }}"
                                class="btn wishlist__btn add-to-wishlist"><i class="fa-solid fa-heart"></i></a>
                            {{-- @endif --}}

                        </div>
                    </div>
                    <div class="enlarged_image_container">
                        <img class="enlarged_image mx-auto" height="411px"
                            src="{{ asset('uploads/product-images/' . $product->thumbnail) }}" alt="">
                    </div>
                    <div class="mt-2">
                        <div class="owl-carousel owl-theme" id="product_image_slider">
                            <div class="item">
                                <img src="{{ asset('uploads/product-images/' . $product->thumbnail) }}" height="106px"
                                    alt="">
                            </div>
                            @if ($product->images != null && count($product->images) > 0)
                                @foreach ($product->images as $image)
                                    <div class="item">
                                        <img src="{{ asset('uploads/product-images/' . $image) }}" height="106px"
                                            alt="">
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-none d-lg-block">
                        <h3 class="productDetails_title">
                            {{ $product->getTranslation(Session::get('language') ?? 'en', 'name') ?? $product->name }}</h3>
                        <p class="productDetails_code">{{ trans('language.product_code') }} - {{ $product->code }}</p>
                        <hr>
                    </div>
                    <div class="productDetails__price__order d-none d-lg-block">
                        <div class="price__section">
                            @if (auth()->check() && $product->price > 0)
                                @if (auth()->user()->role == 2 && $product->show_price == 1)
                                    <h5 class="price">Price: ${{ Helper::priceAfterOffer($product->id) }}</h5>
                                    @if (Helper::priceAfterOffer($product->id) < $product->price)
                                        <p class="price__discount"> {{ trans('language.old_price') }}:
                                            <del>${{ $product->price }}</del>
                                    @endif
                                    </p>
                                @elseif (auth()->user()->role != 2 && $product->show_price_to_partner == 1)
                                    <h5 class="price">Price: ${{ Helper::priceAfterOffer($product->id) }}</h5>
                                    @if (Helper::priceAfterOffer($product->id) < $product->price)
                                        <p class="price__discount"> {{ trans('language.old_price') }}:
                                            <del>${{ $product->price }}</del>
                                    @endif
                                </p>
                                @endif
                            @endif
                        </div>

                        <div class="order__btn__area">

                            {{-- @if (auth()->check() && auth()->user()->role == 1)
        
                            @else --}}

                            @if (auth()->check() && $product->price > 0)
                                @if (auth()->user()->role == 2 && $product->show_price == 1)
                                    <a href="{{ route('add.to.cart', ['type' => 'product', 'id' => $product->id]) }}" class="btn order__btn add-to-cart">{{ trans('language.btn_order') }}</a>
                                @elseif(auth()->user()->role != 2 && $product->show_price_to_partner == 1)
                                    <a href="{{ route('add.to.cart', ['type' => 'product', 'id' => $product->id]) }}" class="btn order__btn add-to-cart">{{ trans('language.btn_order') }}</a>
                                @else
                                    <a href="{{ route('add.to.inquiry', $product->id) }}" class="btn inquiry__btn">{{ trans('language.btn_add_to_inquiry_list') }}</a>
                                @endif
                            @else
                                <a href="{{ route('add.to.inquiry', $product->id) }}" class="btn inquiry__btn">{{ trans('language.btn_add_to_inquiry_list') }}</a>
                            @endif
                            <a href="{{ route('add.to.wishlist', ['type' => 'product', 'id' => $product->id]) }}"
                                class="btn wishlist__btn add-to-wishlist"><i class="fa-solid fa-heart"></i></a>
                            {{-- @endif --}}

                        </div>
                    </div>

                    @if ($catalogue)
                        <hr>
                        <div class="productDetails__download">
                            <h5 class="productDetails__download--title">{{ trans('language.downloads') }}</h5>
                            <a href="{{ route('view.catalogue', $catalogue->id) }}"
                                class="btn mb-2">{{ trans('language.catalogues_page') }}</a> <br>

                            {{-- <a href="" class="btn">{{ trans('language.specification_sheet') }}</a> --}}
                        </div>
                    @endif
                    {{-- <hr>
                        <div class="productDetails__keyFeatures">
                            <h5 class="productDetails__keyFeatures--title">{{ trans('language.key_features') }}</h5>
                            {!! $product->getTranslation(Session::get('language') ?? 'en', 'key_features') ?? $product->key_features !!}
                        </div>
                        <hr>
                        <div class="productDetails__furtherInformation">
                            <h5 class="productDetails__furtherInformation--title">{{ trans('language.further_information') }}</h5>
                            {!! $product->getTranslation(Session::get('language') ?? 'en', 'further_information') ??
                                $product->further_information !!}
                        </div> --}}
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <ul class="product__details__nav nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                    @foreach ($custom_fields as $field)
                        @if ($field->field_name != 'Product Information')
                            @if (
                                $product->custom_options &&
                                    count(
                                        $product->custom_options()->where('custom_field_id', $field->id)->get()) > 0)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if ($loop->iteration == 1) active @endif"
                                        id="pills-{{ $field->id }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ $field->id }}" type="button" role="tab"
                                        aria-controls="pills-{{ $field->id }}"
                                        aria-selected="true">{{ $field->field_name }}</button>
                                </li>
                            @endif
                        @else
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($loop->iteration == 1) active @endif"
                                    id="pills-{{ $field->id }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-{{ $field->id }}" type="button" role="tab"
                                    aria-controls="pills-{{ $field->id }}"
                                    aria-selected="true">{{ $field->field_name }}</button>
                            </li>
                        @endif
                    @endforeach
                    @if ($product->servies && count($product->servies) > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-service-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-service" type="button" role="tab"
                                aria-controls="pills-service" aria-selected="false">Services</button>
                        </li>
                    @endif
                    @if ($product->parts && count($product->parts()->where('parts_type', 'parts')->get()) > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Spare parts</button>
                        </li>
                    @endif
                    @if ($product->parts && count($product->parts()->where('parts_type', 'accessories')->get()) > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">Accessories</button>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="product__details-content pt-4 pb-5">
            <div class="tab-content container" id="pills-tabContent">
                @foreach ($custom_fields as $field)
                    <div class="tab-pane fade @if ($loop->iteration == 1) show active @endif"
                        id="pills-{{ $field->id }}" role="tabpanel" aria-labelledby="pills-{{ $field->id }}-tab">
                        @if ($field->field_name == 'Product Information')
                            <div class="row ">
                                <div class="col-lg-12 productDetails__keyFeatures">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h3 class="productDetails__keyFeatures--title">
                                                {{ trans('language.Key_data_at_a_glance') }}</h3>
                                            {!! $product->getTranslation(Session::get('language') ?? 'en', 'key_features') ?? $product->key_features !!}

                                            <h3 class="productDetails__keyFeatures--title">
                                                {{ trans('Further Information') }}</h3>
                                            {!! $product->getTranslation(Session::get('language') ?? 'en', 'further_information') ??
                                                $product->further_information !!}


                                            <div class="product-attributes__data-list">
                                                @foreach ($product->attributes as $attribute)
                                                    @if ($attribute->attribute_name != null)
                                                        <div class="data__item">
                                                            <div class="col-1">{{ $attribute->attribute_name }}</div>
                                                            <div class="col-2">{{ $attribute->value }}</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            @foreach (\App\Models\ProductAttribute::select('sub_option', DB::raw('MAX(id) as id'))->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', null)->groupBy('sub_option')->get() as $row)
                                                @if ($row->sub_option == 'More Options')
                                                    <h5 class="productDetails__keyFeatures--title mt-4">
                                                        {{ $row->sub_option }}:</h5>
                                                    <div class="list--product-features row m-0">
                                                        @foreach (\App\Models\ProductAttribute::where('product_id', $product->id)->where('type', 'custom value')->where('custom_field_id', $field->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->get() as $option)
                                                            <div class="col-lg-4 mb-4">
                                                                <div class="list__item svg">
                                                                    <img src="{{ asset('uploads/product-custom-files/' . $option->image) }}"
                                                                        class="icon" alt="">
                                                                    <h6 class="heading">{{ $option->title }}</h6>
                                                                    <p class="text">{{ $option->value }}</p>
                                                                    <p class="zusatztext"> {{ $option->details }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($row->sub_option == 'Models')
                                                    <h5 class="productDetails__keyFeatures--title mt-4">
                                                        {{ $row->sub_option }}:</h5>
                                                    <div class="product_detail_accordion accordion w-100"
                                                        id="accordionExample">
                                                        @foreach (\App\Models\ProductAttribute::select('title')->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->whereNull('value')->whereNull('details')->groupBy('title')->get() as $sfeatures)
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="headingOne{{ $loop->iteration }}">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOne{{ $loop->iteration }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseOne{{ $loop->iteration }}">
                                                                        {{ $sfeatures->title }}
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOne{{ $loop->iteration }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="headingOne{{ $loop->iteration }}"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body ps-0">
                                                                        <div class="product-attributes__data-list">
                                                                            @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('title', $sfeatures->title)->get() as $sfeatureoption)
                                                                                @if ($sfeatureoption->title != null && $sfeatureoption->value != null)
                                                                                    <div class="data__item">
                                                                                        <div class="col-1">
                                                                                            {{ $sfeatureoption->value }}
                                                                                        </div>
                                                                                        <div class="col-2">
                                                                                            {{ $sfeatureoption->details }}
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($row->sub_option == 'Single components features')
                                                    <h5 class="productDetails__keyFeatures--title mt-4">
                                                        {{ $row->sub_option }}:</h5>
                                                    <div class="product_detail_accordion accordion w-100"
                                                        id="accordionExample">
                                                        @foreach (\App\Models\ProductAttribute::select('title')->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->whereNull('value')->whereNull('details')->groupBy('title')->get() as $sfeatures)
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="headingOne{{ $loop->iteration }}">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOne{{ $loop->iteration }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseOne{{ $loop->iteration }}">
                                                                        {{ $sfeatures->title }}
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOne{{ $loop->iteration }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="headingOne{{ $loop->iteration }}"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body ps-0">
                                                                        <div class="product-attributes__data-list">
                                                                            @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('title', $sfeatures->title)->get() as $sfeatureoption)
                                                                                @if ($sfeatureoption->title != null && $sfeatureoption->value != null)
                                                                                    <div class="data__item">
                                                                                        <div class="col-1">
                                                                                            {{ $sfeatureoption->value }}
                                                                                        </div>
                                                                                        <div class="col-2">
                                                                                            {{ $sfeatureoption->details }}
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($row->sub_option == 'Notice')
                                                    <div class="row m-0">
                                                        <div class="col-lg-4 ps-0">
                                                            <h5 class="productDetails__keyFeatures--title ">
                                                                {{ $row->sub_option }}:</h5>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p>{{ \App\Models\ProductAttribute::where('product_id', $product->id)->where('type', 'custom value')->where('custom_field_id', $field->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('sub_option', 'Notice')->whereNull('title')->first()->details ?? '' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @elseif($row->sub_option == 'Scope of delivery')
                                                    <div class="row m-0">
                                                        <div class="col-lg-4 ps-0">
                                                            <h5 class="productDetails__keyFeatures--title ">
                                                                {{ $row->sub_option }}:</h5>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p>
                                                                @if (isset(
                                                                        \App\Models\ProductAttribute::where('product_id', $product->id)->where('type', 'custom value')->where('custom_field_id', $field->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('sub_option', 'Scope of delivery')->whereNull('title')->first()->details) &&
                                                                        \App\Models\ProductAttribute::where('product_id', $product->id)->where('type', 'custom value')->where('custom_field_id', $field->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('sub_option', 'Scope of delivery')->whereNull('title')->first()->details != null)
                                                                    @foreach (explode(',', \App\Models\ProductAttribute::where('product_id', $product->id)->where('type', 'custom value')->where('custom_field_id', $field->id)->where('language_code', Session::get('admin_language') ?? 'en')->where('ancestor_id', $row->id)->where('sub_option', 'Scope of delivery')->whereNull('title')->first()->details,) as $key => $val)
                                                                        <li>{{ $val ?? '' }}</li>
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="col-lg-4">
                                            <img class="enlarged_image mx-auto"
                                                src="{{ asset('uploads/product-images/' . $product->thumbnail) }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($field->field_name == 'Benefits')
                            @foreach (\App\Models\ProductAttribute::select('sub_option', DB::raw('MAX(id) as id'))->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', null)->groupBy('sub_option')->get() as $row)
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-center">
                                        <h3 class="productDetails__keyFeatures--title mb-3">{{ $row->sub_option }}</h3>
                                        <p>{{ \App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', $row->id)->whereNull('title')->first()->details ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-lg-12 p-0 mt-4">
                                        <div class="row">
                                            @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', $row->id)->whereNotNull('title')->get() as $benifit)
                                                <div class="col-lg-6 mb-4">
                                                    <div class="benifit-list-item d-flex">
                                                        <div class="icon">
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                        </div>
                                                        <div>
                                                            <strong class="title">{{ $benifit->title }}</strong>
                                                            <span class="details">{{ $benifit->details }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif ($field->field_name == 'Application')
                            @foreach (\App\Models\ProductAttribute::select('sub_option', DB::raw('MAX(id) as id'))->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', null)->groupBy('sub_option')->get() as $row)
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-center">
                                        <h3 class="productDetails__keyFeatures--title mb-3">{{ $row->sub_option }}</h3>
                                    </div>
                                    <div class="col-lg-12 media-carousel mt-4"
                                        data-carousel-id="application_image_carousel_{{ $row->id }}">
                                        <div class="owl-carousel owl-theme application_image_carousel"
                                            id="application_image_carousel_{{ $row->id }}">
                                            @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', $row->id)->get() as $app_image)
                                                <div class="item">
                                                    @if (in_array(strtolower(pathinfo(asset('uploads/product-custom-files/' . $app_image->image), PATHINFO_EXTENSION)), [
                                                            'mp4',
                                                            'avi',
                                                            'mov',
                                                        ]))
                                                        <div class="text-center">
                                                            <video poster="" height="600px" width=""
                                                                class="controls" controls>
                                                                <source
                                                                    src="{{ asset('uploads/product-custom-files/' . $app_image->image) }}"
                                                                    type="video/mp4">
                                                            </video>
                                                        </div>
                                                    @elseif(in_array(strtolower(pathinfo(asset('uploads/product-custom-files/' . $app_image->image), PATHINFO_EXTENSION)), [
                                                            'png',
                                                            'jpg',
                                                            'jpeg',
                                                            'webp',
                                                            'gif',
                                                        ]))
                                                        <img src="{{ asset('uploads/product-custom-files/' . $app_image->image) }}"
                                                            class="w-80 h-auto m-auto" alt="">
                                                    @else
                                                        <div class="text-center">
                                                            <iframe width="600px" height="400px"
                                                                src="{{ $app_image->details }}" frameborder="0"
                                                                allowfullscreen></iframe>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif ($field->field_name == 'Downloads')
                            <div class="row mt-4">
                                <div class="col-lg-12 text-center">
                                    <h3 class="productDetails__keyFeatures--title mb-3">{{ $field->field_name }}</h3>
                                </div>
                                <div class="product_detail_accordion accordion w-100" id="accordionExample">
                                    @foreach (\App\Models\ProductAttribute::select(\DB::raw("SUBSTRING_INDEX(sub_option, ' - ', 1) AS modified_sub_option"), \DB::raw('MAX(id) as id'))->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->whereNull('ancestor_id')->groupBy('modified_sub_option')->get() as $row)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne{{ $loop->iteration }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne{{ $loop->iteration }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseOne{{ $loop->iteration }}">
                                                    {{ $row->modified_sub_option }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $loop->iteration }}"
                                                class="accordion-collapse collapse"
                                                aria-labelledby="headingOne{{ $loop->iteration }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body ps-0">
                                                    <div class="col-llg-12 downloads__data-list">
                                                        @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->whereNull('ancestor_id')->where(\DB::raw("SUBSTRING_INDEX(sub_option, ' - ', 1)"), '=', $row->modified_sub_option)->get() as $row2)
                                                            @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', $row2->id)->whereNotNull('image')->get() as $files)
                                                                <div class="data__item">
                                                                    <div class="col-5">
                                                                        <strong>{{ $row2->sub_option }}</strong>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        @php
                                                                            $fileExtension = pathinfo(
                                                                                $files->image,
                                                                                PATHINFO_EXTENSION,
                                                                            );
                                                                            $isPDF =
                                                                                strtolower($fileExtension) === 'pdf';
                                                                        @endphp
                                                                        @if ($isPDF)
                                                                            <a class="link link--download" target="_blank"
                                                                                href="{{ asset('uploads/product-custom-files/' . $files->image) }}">
                                                                                Download <i
                                                                                    class="fa-solid fa-download"></i>
                                                                            </a>
                                                                        @else
                                                                            <a class="link link--download"
                                                                                href="{{ route('download.file', ['fileName' => $files->image]) }}">
                                                                                Download <i
                                                                                    class="fa-solid fa-download"></i>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--
                                        <div class="col-llg-12 downloads__data-list">
                                            @foreach (\App\Models\ProductAttribute::select('sub_option', DB::raw('MAX(id) as id'))->where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', null)->groupBy('sub_option')->get() as $row)
    @foreach (\App\Models\ProductAttribute::where('type', 'custom value')->where('custom_field_id', $field->id)->where('product_id', $product->id)->where('ancestor_id', $row->id)->whereNotNull('image')->get() as $files)
    <div class="data__item">
                                                        <div class="col-5">
                                                            <strong>{{ $row->sub_option }}</strong>
                                                        </div>
                                                        <div class="col-2">
                                                            @php
                                                                $fileExtension = pathinfo(
                                                                    $files->image,
                                                                    PATHINFO_EXTENSION,
                                                                );
                                                                $isPDF = strtolower($fileExtension) === 'pdf';
                                                            @endphp
                                                            @if ($isPDF)
    <a class="link link--download" target="_blank" href="{{ asset('uploads/product-custom-files/' . $files->image) }}">
                                                                    Download <i class="fa-solid fa-download"></i>
                                                                </a>
@else
    <a class="link link--download" href="{{ route('download.file', ['fileName' => $files->image]) }}">
                                                                    Download <i class="fa-solid fa-download"></i>
                                                                </a>
    @endif
                                                        </div>
                                                    </div>
    @endforeach
    @endforeach
                                        </div>-->
                            </div>
                        @endif
                    </div>
                @endforeach

                @if ($product->servies && count($product->servies) > 0)
                    <div class="tab-pane fade" id="pills-service" role="tabpanel" aria-labelledby="pills-service-tab">
                        <div class="row mt-4 ">
                            <div class="col-lg-12 mb-5 text-center">
                                <h3 class="productDetails__keyFeatures--title mb-3">{{ trans('language.services') }}</h3>
                                <p>We will be happy to advise you individually and adapt your products for the best possible
                                    application.</p>
                                <a href="{{ route('contact-us') }}" class="">{{ trans('language.contact') }}</a>
                            </div>
                            @foreach ($product->servies as $service)
                                <div class="col-lg-12 row mb-4">
                                    <div class="col-lg-6">
                                        @if ($loop->iteration % 2 != 0)
                                            <div class="m-auto">
                                                <img class="w-100" height="416px"
                                                    src="{{ asset('uploads/service-images/' . $service->media) }}"
                                                    alt="">
                                            </div>
                                        @else
                                            <h2>{{ $service->title }}</h2>
                                            <p>{{ $service->short_description }}</p>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        @if ($loop->iteration % 2 != 0)
                                            <h2>{{ $service->title }}</h2>
                                            <p>{{ $service->short_description }}</p>
                                        @else
                                            <div class="m-auto">
                                                <img class="w-100" height="416px"
                                                    src="{{ asset('uploads/service-images/' . $service->media) }}"
                                                    alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($product->parts && count($product->parts()->where('parts_type', 'parts')->get()) > 0)
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row mt-4 ">
                            <div class="col-lg-12 mb-5 text-center">
                                <h3 class="productDetails__keyFeatures--title mb-3">
                                    {{ trans('Spare parts and individual components') }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($product->parts->where('parts_type', 'parts') as $item)
                                <div class="col-lg-12">
                                    <div class="wishlist__card bg-none bb-1">
                                        <div class="wishlist__card--img">
                                            <img src="{{ asset('uploads/part-images/' . $item->thumbnail) }}"
                                                alt="" class="img-fluid">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <h6>{{ $item->name }}</h6>
                                                <p class="mb-1">Code - {{ $item->code }}</p>
                                                @if ($item->price)
                                                    <p class="mb-0">Price:
                                                        ${{ Helper::partPriceFaterOffer($item->id) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="wishlist__card--request">
                                            <div>
                                                @if ($item->price)
                                                    <a href="{{ route('add.to.cart', ['type' => 'part', 'id' => $item->id]) }}"
                                                        class="btn add-to-cart">{{ trans('language.btn_add_to_cart') }}</a>
                                                @else
                                                    <a href="{{ route('add.to.inquiry', $item->id) }}"
                                                        class="btn ">{{ trans('language.btn_request_inquiry') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($product->parts && count($product->parts()->where('parts_type', 'accessories')->get()) > 0)
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="row mt-4 ">
                            <div class="col-lg-12 mb-5 text-center">
                                <h3 class="productDetails__keyFeatures--title mb-3">{{ trans('Accessories') }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($product->parts->where('parts_type', 'accessories') as $item)
                                <div class="col-lg-12">
                                    <div class="wishlist__card bg-none bb-1">
                                        <div class="wishlist__card--img">
                                            <img src="{{ asset('uploads/part-images/' . $item->thumbnail) }}"
                                                alt="" class="img-fluid">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <h6>{{ $item->name }}</h6>
                                                <p class="mb-1">Code - {{ $item->code }}</p>
                                                @if ($item->price)
                                                    <p class="mb-0">Price:
                                                        ${{ Helper::partPriceFaterOffer($item->id) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="wishlist__card--request">
                                            <div>
                                                @if ($item->price)
                                                    <a href="{{ route('add.to.cart', ['type' => 'part', 'id' => $item->id]) }}"
                                                        class="btn add-to-cart">{{ trans('language.btn_add_to_cart') }}</a>
                                                @else
                                                    <a href="{{ route('add.to.inquiry', $item->id) }}"
                                                        class="btn ">{{ trans('language.btn_request_inquiry') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if (count($releted_products) > 0)
            <div class="pb-5">
                <h1 class="page_title ">{{ trans('language.related_products') }}</h1>
                <div class="container">
                    <div class="owl-carousel owl-theme p-4" id="related_product_carousel">
                        @if (count($product->parts) > 0)
                            @foreach ($product->parts as $part)
                                <div class="item">
                                    <a href="{{ route('parts.details', $part->slug) }}">
                                        <div class="card product-cart">
                                            <img src="{{ asset('uploads/part-images/' . $part->thumbnail) }}" alt="">
                                            <p title="{{ $part->name }}" class="product-title text-uppercase d-flex flex-column">
                                                <span>{{ Str::limit($part->getTranslation(Session::get('language') ?? 'en', 'title') ?? $part->name, 30, '...') }}</span>
                                                <small>Item Code: {{ $part->code }}</small>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                        @foreach ($releted_products as $product)
                            <div class="item">
                                <a href="{{ route('product.details', $product->slug) }}">
                                    <div class="card product-cart">
                                        <img src="{{ asset('uploads/product-images/' . $product->thumbnail) }}" alt="">
                                        <p title="{{$product->name}}" class="product-title text-uppercase d-flex flex-column">
                                            <span>{{ Str::limit($product->getTranslation(Session::get('language') ?? 'en', 'title') ?? $product->name, 30, '...')  }}</span>
                                            <small>Item Code: {{ $product->code }}</small>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>



    @push('footer')
        <script>
            $(document).ready(function() {
                $('#product_image_slider').owlCarousel({
                    loop: false,
                    margin: 10,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    responsive: {
                        0: {
                            items: 4
                        },
                        600: {
                            items: 4
                        },
                        1000: {
                            items: 6
                        }
                    }
                });

                $('#image_zoom_modal_slider').owlCarousel({
                    loop: false,
                    margin: 10,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 1
                        }
                    }
                });

                $('.prev1').click(function() {
                    $('.carousel-1').trigger('prev.owl.carousel');
                });

                $('.next1').click(function() {
                    $('.carousel-1').trigger('next.owl.carousel');
                });

                $('#related_product_carousel').owlCarousel({
                    loop: false,
                    margin: 10,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 5
                        }
                    }
                });

                $('.prev2').click(function() {
                    $('.carousel-2').trigger('prev.owl.carousel');
                });

                $('.next2').click(function() {
                    $('.carousel-2').trigger('next.owl.carousel');
                });

                $(".media-carousel").each(function(index) {
                    let id = $(this).attr('data-carousel-id');
                    $('#' + id).owlCarousel({
                        loop: false,
                        nav: true,
                        margin: 10,
                        autoplay: false,
                        autoplayTimeout: 4000,
                        autoplayHoverPause: true,
                        items: 1,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 1
                            },
                            1000: {
                                items: 1
                            }
                        }
                    })
                });

            });


            $(document).ready(function() {
                $('.item').click(function() {
                    var imgSrc = $(this).find('img').attr('src');
                    $('.enlarged_image').attr('src', imgSrc);
                });

                $('.enlarged_image').click(function() {
                    //let main_image = $(this).attr('src');
                    //$('#image_zoom_modal .zoom_image').attr('src', main_image);
                    $('#image_zoom_modal').modal('show');
                });
            });
        </script>



        <script>
            function magnify(imgID, zoom) {
                const existing = document.querySelector('.img-magnifier-glass');
                if (existing) {
                    existing.remove();
                }

                var img, glass, w, h, bw;
                img = document.getElementById(imgID);

                glass = document.createElement("DIV");
                glass.setAttribute("class", "img-magnifier-glass");

                img.parentElement.insertBefore(glass, img);

                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
                bw = 3;
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;

                glass.addEventListener("mousemove", moveMagnifier);
                img.addEventListener("mousemove", moveMagnifier);

                glass.addEventListener("touchmove", moveMagnifier);
                img.addEventListener("touchmove", moveMagnifier);

                function moveMagnifier(e) {
                    var pos, x, y;
                    e.preventDefault();
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;
                    if (x < 0 || x > img.width || y < 0 || y > img.height) {
                        glass.remove();
                        return;
                    }
                    if (x > img.width - (w / zoom)) {
                        x = img.width - (w / zoom);
                    }
                    if (x < w / zoom) {
                        x = w / zoom;
                    }
                    if (y > img.height - (h / zoom)) {
                        y = img.height - (h / zoom);
                    }
                    if (y < h / zoom) {
                        y = h / zoom;
                    }
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
                }

                function getCursorPos(e) {
                    var a, x = 0,
                        y = 0;
                    e = e || window.event;
                    a = img.getBoundingClientRect();
                    x = e.pageX - a.left;
                    y = e.pageY - a.top;
                    x = x - window.pageXOffset;
                    y = y - window.pageYOffset;
                    return {
                        x: x,
                        y: y
                    };
                }
            }

            document.getElementById('zoom_image').addEventListener('mouseenter', function() {
                magnify("zoom_image", 3);
            });
        </script>
    @endpush
@endsection
