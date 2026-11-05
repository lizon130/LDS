@if($subcategory && count($subcategory->subcategories) > 0)
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sub_category_collapse" aria-expanded="true" aria-controls="sub_category_collapse">
                    {{ trans('language.select_sub_category') }}
                </button>
            </h2>
            <div id="sub_category_collapse" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        @foreach($subcategory->subcategories as $subcategory)
                            <div class="col-lg-4 form-check">
                                <input class="form-check-input subcategory_for_filter" type="checkbox" value="{{$subcategory->id}}"
                                    id="subcategory_for_filter{{$subcategory->id}}" name="subcategory_for_filter[]">
                                <label class="form-check-label" for="subcategory_for_filter{{$subcategory->id}}">
                                    {{ $subcategory->title }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    @if ($products->count() > 0)
        @foreach ($products as $product)
            <a class="col-6 col-md-4 col-lg-3 ps-1 pe-1 mb-2" href="{{ url('product/'.$product->slug) }}">
                <div class="card product-cart">
                    <img src="{{ asset('uploads/product-images/' . $product->thumbnail) }}" alt="">
                    <p title="{{$product->name}}" class="product-title text-uppercase d-flex flex-column">
						<span>{{ Str::limit($product->getTranslation(Session::get('language') ?? 'en', 'title') ?? $product->name, 30, '...')  }}</span>
						<small>Item Code: {{ $product->code }}</small>
						@php
							$feature_product_attributes = Cache::remember("feature_product_attributes_{$product->id}", now()->addHours(1), function () use ($product) {
								return $product->attributes;
							});
						@endphp
						@if(count($feature_product_attributes) > 0)
							<small class="text-capitalize">
								@foreach($feature_product_attributes as $attribute)
									@if($attribute->is_filter == 1)
										{{ $attribute->attribute_name}}: {{ $attribute->value }},
									@endif
								@endforeach
							</small>
						@endif
					</p>
                </div>
            </a>
        @endforeach
    @else
        <h1 style="width: max-content;">{{ trans('language.no_product_found') }}.</h1>
    @endif
</div>