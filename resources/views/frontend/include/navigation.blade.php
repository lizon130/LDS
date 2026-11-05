<header id="header" class="fixed-top">
    <div class="remove-on-mobile container d-flex justify-content-end">
        <div class="language-area d-flex gap-2">
            {{-- <select name="language" id="language_select" class="language_select top-call-btn">
                <option {{Session::get('language') == 'en' ? 'selected': '' }} value="en">English</option>
                <option {{Session::get('language') == 'fr' ? 'selected': '' }} value="fr">French</option>
                <option {{Session::get('language') == 'es' ? 'selected': '' }} value="es">Spanish</option>
                <option {{Session::get('language') == 'pt' ? 'selected': '' }} value="pt">Portuguese</option>
            </select> --}}
			<div class="flex-fill d-flex align-items-center gap-1">
				<div class="search-input-container">
					<form action="{{ route('search') }}" method="get" class="m-0">
						<input oninput="hideIcon()" id="search-input-id" class="search-input-container__input" name="search_text" type="text" placeholder="Search"/>
						<i id="search-input-icon-id" class="fa-solid fa-magnifying-glass"></i>
					</form>
				</div>
			</div>
            <div class="top-call-btn d-flex align-items-center gap-1">
                <i class="fa fa-phone"></i> <a href="tel:{{ Helper::getSettings('application_phone') }}">{{ Helper::getSettings('application_phone') }}</a>
            </div>
			<div class="top-call-btn d-flex align-items-center gap-1">
                <i class="fa fa-phone"></i> <a href="tel:{{ Helper::getSettings('application_toll_free') }}">Toll-Free: {{ Helper::getSettings('application_toll_free') }}</a>
            </div>
			<div class="top-language d-flex align-items-center gap-1">
                <div class="dropdown">
                    <a href="#" class="language-text text-uppercase dropdown-toggle" role="button"  data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="flag" src="{{ asset('assets/flag/')}}/@if(Session::get('language') == 'en')united-kingdom.png @elseif(Session::get('language') == 'fr')france.png @elseif (Session::get('language') == 'es')spain.png @elseif (Session::get('language') == 'pt')portugal.png @elseif(!Session::get('language'))united-kingdom.png @endif" alt="" loading="lazy"> {{Session::get('language') ?? 'en' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item flag-select" href="" data-language="en">
                                <img class="flag" src="{{ asset('assets/flag/united-kingdom.png')}}" alt="" loading="lazy"> English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item flag-select" href="" data-language="fr">
                                <img class="flag" src="{{ asset('assets/flag/france.png')}}" alt="" loading="lazy"> French
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item flag-select" href="" data-language="es">
                                <img class="flag" src="{{ asset('assets/flag/spain.png')}}" alt="" loading="lazy"> Spanish
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item flag-select" href="" data-language="pt">
                                <img class="flag" src="{{ asset('assets/flag/portugal.png')}}" alt="" loading="lazy"> Portuguese
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex gap-2 align-items-center">
        <div class="flex-fill logo me-auto d-flex align-items-center">
            <div class="">
                <a href="{{ url('/') }}">
                    <img src="{{ Helper::getSettings('site_logo') ? asset('uploads/settings/'.Helper::getSettings('site_logo')) : asset('assets/img/Logo.png')}}" alt="">
                </a>
                
            </div>
			<!--
            <div class="flex-fill px-5">
                <div class="search-input-container">
                    <form action="{{ route('search') }}" method="get">
                        <input oninput="hideIcon()" id="search-input-id" class="search-input-container__input" name="search_text" type="text" placeholder="Search"/>
                        <i id="search-input-icon-id" class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
            </div>-->
        </div>
		<div class="d-block d-lg-none">
			<div class="top-language d-flex align-items-center gap-1">
				<div class="dropdown">
					<a href="#" class="language-text text-uppercase dropdown-toggle" role="button"  data-bs-toggle="dropdown" aria-expanded="false">
						{{Session::get('language') ?? 'en' }}
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li>
							<a class="dropdown-item flag-select" href="" data-language="en">
								<img class="flag" src="{{ asset('assets/flag/united-kingdom.png')}}" alt=""> English
							</a>
						</li>
						<li>
							<a class="dropdown-item flag-select" href="" data-language="fr">
								<img class="flag" src="{{ asset('assets/flag/france.png')}}" alt=""> French
							</a>
						</li>
						<li>
							<a class="dropdown-item flag-select" href="" data-language="es">
								<img class="flag" src="{{ asset('assets/flag/spain.png')}}" alt=""> Spanish
							</a>
						</li>
						<li>
							<a class="dropdown-item flag-select" href="" data-language="pt">
								<img class="flag" src="{{ asset('assets/flag/portugal.png')}}" alt=""> Portuguese
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
        <nav id="navbar" class="navbar">
            <ul>
				<li class="show-on-mobile d-none">
					<div class="flex-fill px-1">
						<div class="search-input-container">
							<form action="{{ route('search') }}" method="get">
								<input oninput="hideIcon()" id="search-input-id" class="search-input-container__input" name="search_text" type="text" placeholder="Search"/>
								<i id="search-input-icon-id" class="fa-solid fa-magnifying-glass"></i>
							</form>
						</div>
					</div>
				</li>
                <li><a class="{{ request()->is('/') ? 'active ' : '' }}nav-link scrollto ps-0 padding-sm-home" href="{{ url('/') }}">{{ trans('language.home') }}</a></li>
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ trans('language.products') }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><div><a class="dropdown-item" href="{{ route('products') }}"><i class="fa-solid fa-gears"></i>{{ trans('language.products') }}</a></div></li>
                      <div class="vr"></div>
                      <li><div><a class="dropdown-item" href="{{ route('parts') }}"><i class="fa-solid fa-screwdriver-wrench"></i>{{ trans('language.parts') }}</a></div></li>
                    </ul>
                </li>
                <li><a class="{{ request()->is('categories') ? 'active ' : '' }}nav-link scrollto" href="{{ url('categories') }}">{{ trans('language.categories') }}</a></li>
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ trans('language.catalogues') }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><div><a class="dropdown-item" href="{{ url('catalogues') }}"><i class="fa-solid fa-file-pdf"></i>{{ trans('language.catalogues') }}</a></div></li>
                      <div class="vr"></div>
                      <li><div><a class="dropdown-item" href="{{ route('manuals') }}"><i class="fa-solid fa-file-lines"></i>{{ trans('language.manual') }}</a></div></li>
                      <li><div><a class="dropdown-item" href="{{ route('forms') }}"><i class="fa-solid fa-file-pen"></i>{{ trans('language.form') }}</a></div></li>
                    </ul>
                </li>
                {{-- <li><a class="{{ request()->is('catalogues') ? 'active ' : '' }}nav-link scrollto" href="{{ url('catalogues') }}">{{ trans('language.catalogues') }}</a></li>--}}
                <li><a class="{{ request()->is('services') ? 'active ' : '' }}nav-link scrollto" href="{{ url('services') }}">{{ trans('language.service') }}</a></li>
                

                  {{-- cart  --}}
                  <li>
                    <a class="{{ request()->is('cart') ? 'active' : '' }} nav-link scrollto header__icon-size" href="{{ url('cart') }}">
                      <i class="fa-solid fa-shopping-cart wish_cart--icon"></i><span class="ms-2 d-block d-lg-none">Your Cart</span>
                      <span id="cart-counter" class="badge badge-secondary" style="{{ count(session('cartlist') ?? []) > 0 ? '' : 'display: none;' }}">
                        {{ count(session('cartlist') ?? []) }}
                      </span>
                    </a>
                  </li>

                {{-- wishlist  --}}
                  <li>
                    <a class="{{ request()->is('/') ? 'active ' : '' }}nav-link scrollto header__icon-size" href="{{ url('wishlist') }}">
                        <i class="fa-solid fa-heart wish_cart--icon"></i><span class="ms-2 d-block d-lg-none">Wishlist</span>
                        <span id="wishlist-counter" class="badge badge-secondary" style="{{ count(session('wishlist') ?? []) > 0 ? '' : 'display: none;' }}">
                            {{ count(session('wishlist') ?? []) }}
                        </span>
                    </a>
                </li>

                @if(Auth::user())
                    <li><a class="getstarted scrollto" href="{{ route('admin.index') }}">{{ trans('language.dashboard') }}</a></li>
                @else
                    <li><a class="getstarted scrollto" href="{{ url('login') }}">{{ trans('language.login') }}</a></li>
                @endif
				
                <li>
                    <a href="#" style="margin-right: -80px;" onclick="toggleSidebar()" class="hide-on-small-device">
                        <i style="font-size: 20px;" class="fa fa-bars"></i>
                      </a>
                </li>

                <div id="google_translate_element"></div>
            </ul>
            <i class="fa fa-list mobile-nav-toggle"></i>
        </nav>
    </div>

    <div class="sidebar" id="sidebar">
        <!-- Close Button -->
        <div class="close-button" onclick="toggleSidebar()"><i class="fa-solid fa-angles-right"></i></div>

        <!-- Add your sidebar content here -->
        <!-- For example: Navigation Links, Contact Info, etc. -->

        <ul>
            <div class="head ">
                    <h4 class="links header"> Corporate <i class="fa-solid fa-briefcase"></i></h4>
                </li>
            </div>
            <div class="right-bar">
                <li>
                    <h4 class="links"> Company Information</h4>
                </li>
            </div>
            <li>
                <a class="{{ request()->is('news') ? 'active ' : '' }}nav-link scrollto" href="{{ url('news') }}">
                    {{ trans('language.news') }}
                </a>
            </li>
            <li>
                <a class="{{ request()->is('about') ? 'active ' : '' }}nav-link scrollto" href="{{ url('about') }}">

                    {{ trans('language.about') }}
                </a>
            </li>
            <li>
                <a class="{{ request()->is('contact') ? 'active ' : '' }}nav-link scrollto" href="{{ url('contact') }}">

                    {{ trans('language.contact') }}
                </a>
            </li>

            <div class="right-bar">
                <li>
                    <h4 class="links">Legal Informations</h4>
                </li>
            </div>

                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('page', 'terms-and-conditions') }}">{{ trans('language.terms_condition') }}</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('page', 'privacy-policy') }}">{{ trans('language.privacy_policy') }}</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('page', 'return-policy') }}">{{ trans('language.return_policy') }}</a></li>
            <!-- Add more menu items as needed -->

            <div class="right-bar">
                <li>
                    <h4 class="links">{{ trans('language.get_in_touch') }}</h4>
                </li>
            </div>

            <li><i class="bx bx-chevron-right"></i> <a href="tel:{{ Helper::getSettings('application_phone') }}"> <i class="fa-solid fa-phone" style="margin-left: 2px"></i>  {{ Helper::getSettings('application_phone') }}</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="mailto:{{ Helper::getSettings('application_email') }}"> <i class="fa-regular fa-envelope" style="margin-left: 2px;"></i>  {{ Helper::getSettings('application_email') }}</a></li>


            <div class="right-bar">
                <li>
                    <h4 class="links">Social Links</h4>
                </li>
            </div>
            <li class="social-icons-row">
                <a class="social-icon" href="{{ Helper::getSettings('facebook_link') }}" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="social-icon" href="{{ Helper::getSettings('twitter_link') }}" target="_blank">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a class="social-icon" href="{{ Helper::getSettings('instagram_link') }}" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="social-icon" href="{{ Helper::getSettings('linkedin_link') }}" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="social-icon" href="{{ Helper::getSettings('youtube_link') }}" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
				
				<a class="social-icon" href="{{ route('review.us') }}" target="_blank" style="padding-top: 10px;">
                    <i class="fa-regular fa-star"></i>
                </a>
				
            </li>



        </ul>
    </div>

    <div id="toastr-container"></div>


</header>

<script>
    const inputField = document.getElementById('search-input-id');
    const icon = document.getElementById('search-input-icon-id');
    const hideIcon = () => {
        if(inputField.value){
            icon.classList.add("d-none");
			inputField.classList.add("search-input-container__input-padding");
        }else{
            icon.classList.remove("d-none");
			inputField.classList.remove("search-input-container__input-padding");
        }
    }
</script>
<script>

function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

document.addEventListener("mousedown", function(event) {
    var sidebar = document.getElementById("sidebar");
    var toggleButton = document.querySelector(".close-button"); // Use a class selector for the close button

    setTimeout(function() {
        if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
            sidebar.classList.remove("active");
        }
    }, 0);
});

</script>







