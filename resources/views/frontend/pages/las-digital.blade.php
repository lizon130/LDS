@php
  $landingAsset = static function ($path) {
    if (!$path) {
      return asset('assets/img/Logo.png');
    }

    return filter_var($path, FILTER_VALIDATE_URL) ? $path : asset(ltrim($path, '/'));
  };
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=yes"
    />
    <title>{{ $content['application_name'] }} | Premium Software & Growth Marketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
      rel="stylesheet"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: "Inter", sans-serif;
        background-color: #0b0507;
        color: #ece5e8;
      }
      :root {
        --primary-deep: #195f95; /* rich deep blue-teal */
        --primary-glow: #1e6ba8;
        --secondary-dark: #170b10; /* deep maroon-black base */
        --accent-gold: #e0bc7c;
        --accent-gold-light: #f5d99b;
        --card-bg: #110c0f;
        --border-dim: #2a1e24;
      }
      .bg-primary-deep {
        background-color: var(--primary-deep);
      }
      .bg-secondary-dark {
        background-color: var(--secondary-dark);
      }
      .text-accent {
        color: var(--accent-gold);
      }
      .border-accent {
        border-color: var(--accent-gold);
      }
      .btn-gradient {
        background: linear-gradient(135deg, #195f95 0%, #103f63 100%);
        box-shadow: 0 8px 20px rgba(25, 95, 149, 0.35);
        transition: all 0.25s ease;
      }
      .btn-gradient:hover {
        background: linear-gradient(135deg, #2378b3 0%, #0e3452 100%);
        transform: translateY(-2px);
      }
      .btn-outline-accent {
        border: 2px solid var(--accent-gold);
        color: var(--accent-gold);
        transition: all 0.2s;
      }
      .btn-outline-accent:hover {
        background: rgba(224, 188, 124, 0.12);
        border-color: var(--accent-gold-light);
        color: var(--accent-gold-light);
      }
      .section-title {
        position: relative;
        display: inline-block;
        font-weight: 800;
      }
      .section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -12px;
        width: 80px;
        height: 4px;
        background: linear-gradient(
          90deg,
          var(--primary-deep),
          var(--accent-gold)
        );
        border-radius: 6px;
      }
      .step-card {
        background: #0e090c;
        border-left: 5px solid var(--primary-deep);
        transition: all 0.3s;
      }
      .step-card:hover {
        transform: translateX(6px);
        background: #1c1318;
        border-left-color: var(--accent-gold);
      }
      .project-card,
      .marketing-card,
      .pricing-card,
      .client-card {
        background: #0f0b0e;
        border: 1px solid #2b1c23;
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      }
      .project-card:hover,
      .marketing-card:hover,
      .pricing-card:hover {
        transform: translateY(-6px);
        border-color: var(--primary-deep);
        box-shadow: 0 20px 30px -12px rgba(25, 95, 149, 0.3);
      }
      .testimonial-card {
        background: #0e090b;
        border-left: 5px solid var(--accent-gold);
        transition: transform 0.2s;
      }
      .badge-popular {
        background: var(--accent-gold);
        color: #170b10;
        font-weight: 800;
        box-shadow: 0 2px 8px rgba(224, 188, 124, 0.4);
      }
      input,
      select,
      textarea {
        background-color: #181012;
        border: 1px solid #3a262e;
        color: #f0e6e9;
      }
      input:focus,
      select:focus,
      textarea:focus {
        outline: none;
        border-color: var(--primary-deep);
        box-shadow: 0 0 0 2px rgba(25, 95, 149, 0.4);
      }
      .step-number-gradient {
        background: linear-gradient(145deg, var(--primary-deep), #0e3a59);
        box-shadow: 0 10px 18px -5px rgba(0, 0, 0, 0.5);
      }
      .footer-maroon {
        background: #050203;
        border-top: 1px solid #2b111b;
      }
      .star-gold {
        color: var(--accent-gold);
      }

      /* carousel custom styles */
      .carousel-container {
        position: relative;
        overflow: hidden;
      }
      .carousel-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        will-change: transform;
      }
      .carousel-card {
        flex: 0 0 100%;
        padding: 0 12px;
      }
      @media (min-width: 768px) {
        .carousel-card {
          flex: 0 0 50%;
        }
      }
      @media (min-width: 1024px) {
        .carousel-card {
          flex: 0 0 33.333%;
        }
      }
      .carousel-nav-btn {
        background: rgba(25, 95, 149, 0.7);
        backdrop-filter: blur(8px);
        transition: 0.2s;
      }
      .carousel-nav-btn:hover {
        background: var(--primary-deep);
        color: white;
      }
      .client-logo-grayscale {
        filter: grayscale(100%) brightness(1.2);
        opacity: 0.7;
        transition: all 0.3s;
      }
      .client-logo-grayscale:hover {
        filter: grayscale(0) brightness(1);
        opacity: 1;
      }

      /* SaaS products section */
      .product-showcase-card {
        background:
          radial-gradient(circle at 85% 15%, rgba(224, 188, 124, 0.13), transparent 27%),
          linear-gradient(145deg, rgba(25, 95, 149, 0.16), rgba(15, 11, 14, 0.96) 48%, rgba(11, 6, 8, 0.98));
        border: 1px solid rgba(224, 188, 124, 0.22);
        box-shadow: 0 28px 70px rgba(0, 0, 0, 0.36);
        transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
      }

      .product-showcase-card:hover {
        transform: translateY(-5px);
        border-color: rgba(224, 188, 124, 0.55);
        box-shadow: 0 35px 85px rgba(25, 95, 149, 0.2);
      }

      .product-feature-chip {
        background: rgba(25, 95, 149, 0.16);
        border: 1px solid rgba(25, 95, 149, 0.42);
      }

      .product-screen {
        background: linear-gradient(145deg, #132b3c, #0b1015 55%, #171016);
        border: 1px solid rgba(224, 188, 124, 0.2);
        box-shadow: 0 24px 55px rgba(0, 0, 0, 0.45);
      }



      /* Hero image carousel */
      .hero-carousel {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 1rem;
        border: 1px solid #195f95;
        background: #08121b;
        box-shadow: 0 28px 70px rgba(0, 0, 0, 0.35);
      }

      .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transform: scale(1.025);
        transition: opacity 0.75s ease, transform 1.1s ease;
        pointer-events: none;
      }

      .hero-slide.active {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
        z-index: 2;
      }

      /* Make the whole active hero banner clickable */
      .hero-slide-link {
        display: block;
        width: 100%;
        height: 100%;
        cursor: pointer;
        text-decoration: none;
      }

      .hero-slide-link:focus-visible {
        outline: 3px solid #e0bc7c;
        outline-offset: -4px;
        border-radius: 1rem;
      }

      .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }

      .hero-carousel::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 3;
        pointer-events: none;
        background: linear-gradient(
          180deg,
          rgba(0, 0, 0, 0.02) 0%,
          rgba(0, 0, 0, 0.02) 66%,
          rgba(0, 0, 0, 0.2) 100%
        );
      }

      .hero-carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 44px;
        height: 44px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: rgba(5, 11, 18, 0.58);
        border: 1px solid rgba(255, 255, 255, 0.22);
        backdrop-filter: blur(10px);
        transition: all 0.25s ease;
      }

      .hero-carousel-btn:hover {
        background: #195f95;
        border-color: rgba(224, 188, 124, 0.72);
        color: #f5d99b;
        transform: translateY(-50%) scale(1.06);
      }

      .hero-carousel-btn.prev {
        left: 14px;
      }

      .hero-carousel-btn.next {
        right: 14px;
      }

      .hero-carousel-dots {
        position: absolute;
        left: 50%;
        bottom: 15px;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 9999px;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(8px);
      }

      .hero-carousel-dot {
        width: 8px;
        height: 8px;
        padding: 0;
        border: 0;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.45);
        transition: all 0.3s ease;
        cursor: pointer;
      }

      .hero-carousel-dot.active {
        width: 26px;
        background: #e0bc7c;
      }

      @media (max-width: 640px) {
        .hero-carousel-btn {
          width: 38px;
          height: 38px;
        }

        .hero-carousel-btn.prev {
          left: 8px;
        }

        .hero-carousel-btn.next {
          right: 8px;
        }
      }

      .product-screen-grid {
        background-image:
          linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
          linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
        background-size: 24px 24px;
      }
    </style>
  </head>
  <body class="bg-secondary-dark">
    <!-- Navigation with refined colors -->
    <header
      class="bg-black/80 backdrop-blur-md border-b border-[#2c1a22] sticky top-0 z-50"
    >
      <div class="container mx-auto px-6 py-2">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <a href="#" class="text-2xl font-bold flex items-center gap-2">
              <img
                src="{{ $landingAsset($content['logo']) }}"
                alt="{{ $content['application_name'] }}"
                style="width: 130px; height: auto"
                onerror="this.style.display = 'none'"
              />
            </a>
          </div>
          <nav class="hidden md:flex space-x-8">
            <a
              href="#home"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Home</a
            >
            <a
              href="#software-process"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Dev Process</a
            >
            <a
              href="#projects"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Projects</a
            >
            <a
              href="#digital-marketing"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Marketing</a
            >
            <a
              href="#pricing"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Pricing</a
            >
            <a
              href="#products"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Products</a
            >
            <a
              href="#reviews"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Reviews</a
            >
            <a
              href="#partners"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Partners</a
            >
            <a
              href="#contact"
              class="font-medium text-gray-300 hover:text-[#e0bc7c] transition"
              >Contact</a
            >
          </nav>
          <button class="md:hidden text-2xl text-white mobile-menu-btn">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        <div
          class="mobile-nav hidden md:hidden mt-4 flex-col space-y-3 pb-3 border-t border-[#3d1e28] pt-3"
        >
          <a href="#home" class="block py-2 text-gray-300 hover:text-gold"
            >Home</a
          >
          <a
            href="#software-process"
            class="block py-2 text-gray-300 hover:text-gold"
            >Dev Process</a
          >
          <a href="#projects" class="block py-2 text-gray-300 hover:text-gold"
            >Projects</a
          >
          <a
            href="#digital-marketing"
            class="block py-2 text-gray-300 hover:text-gold"
            >Marketing</a
          >
          <a href="#pricing" class="block py-2 text-gray-300 hover:text-gold"
            >Pricing</a
          >
          <a href="#products" class="block py-2 text-gray-300 hover:text-gold"
            >Products</a
          >
          <a href="#reviews" class="block py-2 text-gray-300 hover:text-gold"
            >Reviews</a
          >
          <a href="#partners" class="block py-2 text-gray-300 hover:text-gold"
            >Partners</a
          >
          <a href="#contact" class="block py-2 text-gray-300 hover:text-gold"
            >Contact</a
          >
        </div>
      </div>
    </header>

    <!-- Hero Section with #195f95 + #170b10 gradient -->
    <section
      id="home"
      class="py-20 md:py-28 relative overflow-hidden bg-gradient-to-br from-[#170b10] via-[#195f95] to-[#0f2c3f]"
    >
      <div
        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"
      ></div>
      <div class="container mx-auto px-6 relative z-2">
        <div class="flex flex-col lg:flex-row items-center gap-12">
          <div class="lg:w-1/2">
            <span
              class="inline-block px-4 py-1.5 bg-[#195f95]/70 backdrop-blur-sm rounded-full text-[#e0bc7c] text-sm font-semibold tracking-wide mb-4 border border-[#e0bc7c]/40"
              ><i class="fas fa-microchip mr-2"></i> {{ $content['hero_badge'] }}</span
            >
            <h1
              class="text-4xl md:text-6xl font-extrabold leading-tight text-white mb-6"
            >
              {!! $content['hero_title'] !!}
            </h1>
            <p class="text-xl text-[#d9cfd3] mb-8 max-w-2xl">
              {{ $content['hero_copy'] }}
            </p>
            <div class="flex flex-col sm:flex-row gap-5">
              <a
                href="#software-process"
                class="px-8 py-4 bg-gradient-to-r from-[#195f95] to-[#0e3a59] text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all text-center"
                >Explore Dev Process →</a
              >
              <a
                href="#contact"
                class="px-8 py-4 border-2 border-[#e0bc7c] text-[#e0bc7c] font-bold rounded-xl hover:bg-[#195f95]/40 transition-all text-center"
                >Free Consultation</a
              >
            </div>
            <div
              class="mt-10 bg-black/50 backdrop-blur-sm p-5 rounded-2xl border border-[#195f95] max-w-md"
            >
              <div class="flex items-center gap-3">
                <div class="star-gold text-2xl">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i
                  ><i class="fas fa-star"></i><i class="fas fa-star"></i
                  ><i class="fas fa-star"></i>
                </div>
                <span class="text-white font-bold text-lg">5.0 / 5.0</span
                ><span class="text-gray-400">| 180+ businesses</span>
              </div>
              <p class="text-[#e0bc7c] text-sm mt-2">
                "Any software, any complexity — delivered with excellence"
              </p>
            </div>
          </div>
          <div class="lg:w-1/2 w-full">
            <!-- HERO IMAGE CAROUSEL
                 Add/remove .hero-slide blocks below whenever you want more banners.
                 Keep the image files in the same folder as this HTML file. -->
            <div id="heroCarousel" class="hero-carousel group">
              <div class="hero-slide active">
                <a
                  href="{{ route('amar.hishab') }}"
                  class="hero-slide-link"
                  aria-label="Open Amar Hishab Keeper SaaS product page"
                  title="View Amar Hishab Keeper SaaS"
                >
                  <img
                    src="{{ $landingAsset($content['hero_images'][0] ?? null) }}"
                    alt="Amar Hishab Keeper SaaS inventory management"
                    loading="eager"
                    onerror="this.src='https://placehold.co/1200x675/195f95/ffffff?text=Hero+Banner+1'"
                  />
                </a>
              </div>

              <div class="hero-slide">
                <a
                  href="{{ route('amar.hishab') }}"
                  class="hero-slide-link"
                  aria-label="Open Amar Hishab Keeper SaaS product page"
                  title="View Amar Hishab Keeper SaaS"
                >
                  <img
                    src="{{ $landingAsset($content['hero_images'][1] ?? null) }}"
                    alt="SaaS product marketing banner"
                    loading="lazy"
                    onerror="this.src='https://placehold.co/1200x675/103f63/f5d99b?text=Add+hero-cover-2.png'"
                  />
                </a>
              </div>

              <div class="hero-slide">
                <a
                  href="{{ route('amar.hishab') }}"
                  class="hero-slide-link"
                  aria-label="Open Amar Hishab Keeper SaaS product page"
                  title="View Amar Hishab Keeper SaaS"
                >
                  <img
                    src="{{ $landingAsset($content['hero_images'][2] ?? null) }}"
                    alt="LAS Digital Solutions software banner"
                    loading="lazy"
                    onerror="this.src='https://placehold.co/1200x675/170b10/e0bc7c?text=Add+hero-cover-3.png'"
                  />
                </a>
              </div>

              <button
                type="button"
                id="heroPrev"
                class="hero-carousel-btn prev"
                aria-label="Previous hero image"
              >
                <i class="fas fa-chevron-left"></i>
              </button>

              <button
                type="button"
                id="heroNext"
                class="hero-carousel-btn next"
                aria-label="Next hero image"
              >
                <i class="fas fa-chevron-right"></i>
              </button>

              <!-- Dots are created automatically by JavaScript -->
              <div id="heroDots" class="hero-carousel-dots" aria-label="Hero carousel navigation"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SOFTWARE DEV PROCESS -->
    <section id="software-process" class="py-20 bg-[#0c070a]">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Custom Software Development Process
          </h2>
          <p class="text-xl text-[#cdb5bc] max-w-3xl mx-auto mt-6">
            Any software, any stack: AI, Web, Mobile, Desktop, ERPs — we follow
            a battle-tested agile framework.
          </p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="step-card p-6 rounded-xl">
            <div
              class="step-number-gradient w-16 h-16 rounded-xl flex items-center justify-center text-white text-2xl font-black mb-5"
            >
              1
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">
              Discovery & Blueprint
            </h3>
            <p class="text-gray-300">
              In-depth workshops, user stories, tech audit. We define your
              software roadmap and architecture.
            </p>
          </div>
          <div class="step-card p-6 rounded-xl">
            <div
              class="step-number-gradient w-16 h-16 rounded-xl flex items-center justify-center text-white text-2xl font-black mb-5"
            >
              2
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">
              UX/UI & Prototyping
            </h3>
            <p class="text-gray-300">
              Premium design systems, interactive prototypes for web/mobile —
              intuitive & stunning.
            </p>
          </div>
          <div class="step-card p-6 rounded-xl">
            <div
              class="step-number-gradient w-16 h-16 rounded-xl flex items-center justify-center text-white text-2xl font-black mb-5"
            >
              3
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Agile Dev & QA</h3>
            <p class="text-gray-300">
              Sprints, CI/CD, rigorous testing. Any stack: React, Python, .NET,
              Flutter, AI/ML integrations.
            </p>
          </div>
          <div class="step-card p-6 rounded-xl">
            <div
              class="step-number-gradient w-16 h-16 rounded-xl flex items-center justify-center text-white text-2xl font-black mb-5"
            >
              4
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Deploy & Scale</h3>
            <p class="text-gray-300">
              Cloud (AWS/Azure), monitoring, 24/7 support — continuous feature
              upgrades.
            </p>
          </div>
        </div>
        <div class="mt-16 bg-[#110a0e] rounded-2xl p-8 border border-[#195f95]">
          <div class="flex flex-wrap justify-center gap-8 text-center">
            <div>
              <i
                class="fa-solid fa-brain text-[#e0bc7c] text-3xl mb-2 block"
              ></i
              ><span class="font-semibold text-white">AI/ML Solutions</span>
            </div>
            <div>
              <i
                class="fa-solid fa-mobile-screen-button text-[#e0bc7c] text-3xl mb-2 block"
              ></i
              ><span class="font-semibold text-white">iOS/Android Apps</span>
            </div>
            <div>
              <i
                class="fa-solid fa-chalkboard-user text-[#e0bc7c] text-3xl mb-2 block"
              ></i
              ><span class="font-semibold text-white">ERP & CRM</span>
            </div>
            <div>
              <i
                class="fa-solid fa-chart-line text-[#e0bc7c] text-3xl mb-2 block"
              ></i
              ><span class="font-semibold text-white">Real-time Analytics</span>
            </div>
            <div>
              <i
                class="fa-solid fa-cart-shopping text-[#e0bc7c] text-3xl mb-2 block"
              ></i
              ><span class="font-semibold text-white">Marketplaces/Ecom</span>
            </div>
          </div>
          <p class="text-center mt-8 text-[#e0bc7c] font-medium">
            ✓ Any software, from MVP to enterprise-grade. Your vision, our code.
          </p>
        </div>
      </div>
    </section>


    <!-- OUR SAAS PRODUCTS -->
    <section id="products" class="py-20 bg-gradient-to-b from-[#0c070a] via-[#0f0a0d] to-[#0e080b] relative overflow-hidden">
      <div class="absolute -top-24 -right-24 w-80 h-80 bg-[#195f95]/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-32 -left-20 w-96 h-96 bg-[#e0bc7c]/5 rounded-full blur-3xl pointer-events-none"></div>

      <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-12">
          <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#e0bc7c]/30 bg-[#e0bc7c]/5 text-[#e0bc7c] text-sm font-semibold mb-5">
            <i class="fa-solid fa-box-open"></i> Ready-to-Use SaaS Products
          </span>
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Our Products
          </h2>
          <p class="text-gray-300 text-lg max-w-3xl mx-auto mt-7">
            Powerful cloud software built for real business operations. Subscribe, onboard your team, and start working from anywhere without maintaining your own server.
          </p>
        </div>

        <div class="max-w-6xl mx-auto product-showcase-card rounded-[28px] overflow-hidden">
          <div class="grid lg:grid-cols-2 gap-0">
            <div class="p-7 md:p-10 lg:p-12 flex flex-col justify-center">
              <div class="flex flex-wrap items-center gap-3 mb-6">
                <span class="px-3 py-1.5 rounded-full bg-[#195f95] text-white text-xs font-bold uppercase tracking-wider">
                  SaaS Business Software
                </span>
                <span class="px-3 py-1.5 rounded-full bg-[#e0bc7c]/10 border border-[#e0bc7c]/30 text-[#e0bc7c] text-xs font-semibold">
                  Monthly · 6 Months · Yearly
                </span>
              </div>

              <h3 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4">
                Mondal Surgical <span class="text-[#e0bc7c]">Business SaaS</span>
              </h3>

              <p class="text-gray-300 text-lg leading-relaxed mb-7">
                A complete cloud-based sales, inventory, purchase, customer, payment and business management platform designed for surgical, medical and trading businesses. Each subscribed company gets its own secure business environment and isolated database.
              </p>

              <div class="grid sm:grid-cols-2 gap-3 mb-8">
                <div class="product-feature-chip rounded-xl px-4 py-3 flex items-center gap-3">
                  <i class="fa-solid fa-cash-register text-[#e0bc7c]"></i>
                  <span class="text-gray-200 font-medium">POS & Sales</span>
                </div>
                <div class="product-feature-chip rounded-xl px-4 py-3 flex items-center gap-3">
                  <i class="fa-solid fa-boxes-stacked text-[#e0bc7c]"></i>
                  <span class="text-gray-200 font-medium">Inventory & Stock</span>
                </div>
                <div class="product-feature-chip rounded-xl px-4 py-3 flex items-center gap-3">
                  <i class="fa-solid fa-cart-flatbed text-[#e0bc7c]"></i>
                  <span class="text-gray-200 font-medium">Purchase & Supplier</span>
                </div>
                <div class="product-feature-chip rounded-xl px-4 py-3 flex items-center gap-3">
                  <i class="fa-solid fa-chart-pie text-[#e0bc7c]"></i>
                  <span class="text-gray-200 font-medium">Reports & Analytics</span>
                </div>
              </div>

              <div class="flex flex-col sm:flex-row gap-4">
                <a
                  href="{{ route('amar.hishab') }}"
                  class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-[#195f95] to-[#0e3a59] text-white font-bold rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all"
                >
                  Explore Product <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a
                  href="{{ route('amar.hishab') }}#demo"
                  class="inline-flex items-center justify-center gap-2 px-6 py-3.5 border border-[#e0bc7c]/60 text-[#e0bc7c] font-bold rounded-xl hover:bg-[#e0bc7c]/10 transition-all"
                >
                  <i class="fa-solid fa-circle-play"></i> Watch Demo
                </a>
              </div>
            </div>

            <div class="relative p-6 md:p-10 bg-black/20 flex items-center">
              <div class="product-screen product-screen-grid w-full rounded-2xl p-4 md:p-5">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/10">
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-400/80"></span>
                    <span class="w-3 h-3 rounded-full bg-yellow-300/80"></span>
                    <span class="w-3 h-3 rounded-full bg-green-400/80"></span>
                  </div>
                  <span class="text-xs text-gray-400">Secure SaaS Workspace</span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                  <div class="rounded-xl bg-[#195f95]/20 border border-[#195f95]/40 p-4">
                    <i class="fa-solid fa-chart-line text-[#e0bc7c] mb-3"></i>
                    <div class="h-2 bg-white/10 rounded mb-2"></div>
                    <div class="h-2 bg-white/10 rounded w-2/3"></div>
                  </div>
                  <div class="rounded-xl bg-[#e0bc7c]/5 border border-[#e0bc7c]/20 p-4">
                    <i class="fa-solid fa-box text-[#e0bc7c] mb-3"></i>
                    <div class="h-2 bg-white/10 rounded mb-2"></div>
                    <div class="h-2 bg-white/10 rounded w-1/2"></div>
                  </div>
                </div>

                <div class="rounded-xl border border-white/10 bg-black/20 overflow-hidden">
                  <div class="grid grid-cols-4 gap-2 px-4 py-3 bg-white/5 text-[11px] text-gray-400 font-semibold uppercase">
                    <span>Product</span><span>Stock</span><span>Sales</span><span>Status</span>
                  </div>
                  <div class="grid grid-cols-4 gap-2 px-4 py-3 text-xs text-gray-300 border-t border-white/5">
                    <span>Medical Item</span><span>248</span><span>৳42K</span><span class="text-green-400">Active</span>
                  </div>
                  <div class="grid grid-cols-4 gap-2 px-4 py-3 text-xs text-gray-300 border-t border-white/5">
                    <span>Surgical Item</span><span>176</span><span>৳31K</span><span class="text-green-400">Active</span>
                  </div>
                  <div class="grid grid-cols-4 gap-2 px-4 py-3 text-xs text-gray-300 border-t border-white/5">
                    <span>Support Item</span><span>92</span><span>৳18K</span><span class="text-amber-300">Monitor</span>
                  </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                  <span class="px-3 py-1.5 rounded-full bg-green-500/10 border border-green-500/20 text-green-300 text-xs"><i class="fa-solid fa-shield-halved mr-1"></i> Isolated Database</span>
                  <span class="px-3 py-1.5 rounded-full bg-[#195f95]/15 border border-[#195f95]/30 text-blue-200 text-xs"><i class="fa-solid fa-cloud mr-1"></i> Cloud Access</span>
                  <span class="px-3 py-1.5 rounded-full bg-[#e0bc7c]/10 border border-[#e0bc7c]/20 text-[#e0bc7c] text-xs"><i class="fa-solid fa-users mr-1"></i> Multi User</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-8">
          <p class="text-sm text-gray-400">
            More SaaS products are coming soon. Need a custom version for your industry?
            <a href="#contact" class="text-[#e0bc7c] font-semibold hover:underline">Talk to our team.</a>
          </p>
        </div>
      </div>
    </section>

     <!-- CLIENT SUCCESS STORIES CAROUSEL (auto-running) -->
    <section id="reviews" class="py-20 bg-[#0e080b]">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Client Success Stories
          </h2>
          <p class="text-gray-300 mt-3">
            Trusted by industry leaders · real results
          </p>
        </div>
        <div class="relative max-w-6xl mx-auto">
          <div class="carousel-container overflow-hidden">
            <div id="testimonialTrack" class="carousel-track">
              <div class="carousel-card">
                <div class="testimonial-card p-6 rounded-xl h-full">
                  <div class="flex items-center gap-4 mb-3">
                    <div
                      class="w-12 h-12 rounded-full bg-[#195f95] flex items-center justify-center text-white font-bold"
                    >
                      AK
                    </div>
                    <div>
                      <h4 class="font-bold text-white">MD. Rowshon</h4>
                      <p class="text-sm text-gray-400">Founder, Rowshon Traders</p>
                    </div>
                  </div>
                  <div class="star-gold flex mb-2">★★★★★</div>
                  <p class="text-gray-300">
                    “LAS built our Inventory Management system & ran Facebook campaigns. This is absolutely phenomenal!”
                  </p>
                </div>
              </div>
              <div class="carousel-card">
                <div class="testimonial-card p-6 rounded-xl h-full">
                  <div class="flex items-center gap-4 mb-3">
                    <div
                      class="w-12 h-12 rounded-full bg-[#195f95] flex items-center justify-center text-white font-bold"
                    >
                      PM
                    </div>
                    <div>
                      <h4 class="font-bold text-white">MD Salim Hossain</h4>
                      <p class="text-sm text-gray-400">CEO, Modern Garments</p>
                    </div>
                  </div>
                  <div class="star-gold flex mb-2">★★★★★</div>
                  <p class="text-gray-300">
                    “ আমি তাদের সার্ভিসে অত্যন্ত সন্তুষ্ট। তারা খুবই প্রফেশনাল, দায়িত্বশীল এবং আমার সব রিকোয়ারমেন্ট সুন্দরভাবে পূরণ করেছে। সফটওয়্যারটি স্মুথ ও ইউজার-ফ্রেন্ডলি। এছাড়া তাদের আফটার-সার্ভিস সাপোর্টও অসাধারণ—যেকোনো প্রয়োজনে দ্রুত সহায়তা পাওয়া যায়। অবশ্যই তাদের সার্ভিস রিকমেন্ড করবো। ”
                  </p>
                </div>
              </div>
              <div class="carousel-card">
                <div class="testimonial-card p-6 rounded-xl h-full">
                  <div class="flex items-center gap-4 mb-3">
                    <div
                      class="w-12 h-12 rounded-full bg-[#195f95] flex items-center justify-center text-white font-bold"
                    >
                      RJ
                    </div>
                    <div>
                      <h4 class="font-bold text-white">Mr. Susanto</h4>
                      <p class="text-sm text-gray-400">Founder, Nimi Enterprise</p>
                    </div>
                  </div>
                  <div class="star-gold flex mb-2">★★★★★</div>
                  <p class="text-gray-300">
                    “ আমি তাদের ফার্মাসিউটিক্যাল সফটওয়্যার সার্ভিসে খুবই সন্তুষ্ট। সফটওয়্যারটি অত্যন্ত স্মুথ, নির্ভরযোগ্য এবং ব্যবহারবান্ধব। আমার প্রয়োজন অনুযায়ী সব গুরুত্বপূর্ণ ফিচার সুন্দরভাবে যুক্ত করা হয়েছে, যা দৈনন্দিন কাজ অনেক সহজ করে দিয়েছে। তাদের টিম খুবই প্রফেশনাল এবং সাপোর্টও অসাধারণ। যেকোনো সমস্যায় দ্রুত সমাধান পাওয়া যায়। ”
                  </p>
                </div>
              </div>
              <div class="carousel-card">
                <div class="testimonial-card p-6 rounded-xl h-full">
                  <div class="flex items-center gap-4 mb-3">
                    <div
                      class="w-12 h-12 rounded-full bg-[#195f95] flex items-center justify-center text-white font-bold"
                    >
                      SL
                    </div>
                    <div>
                      <h4 class="font-bold text-white">Samira L.</h4>
                      <p class="text-sm text-gray-400">Ecom Founder</p>
                    </div>
                  </div>
                  <div class="star-gold flex mb-2">★★★★★</div>
                  <p class="text-gray-300">
                    “Mobile app reached 100k downloads within 3 months.
                    Exceptional team.”
                  </p>
                </div>
              </div>
              <div class="carousel-card">
                <div class="testimonial-card p-6 rounded-xl h-full">
                  <div class="flex items-center gap-4 mb-3">
                    <div
                      class="w-12 h-12 rounded-full bg-[#195f95] flex items-center justify-center text-white font-bold"
                    >
                      TD
                    </div>
                    <div>
                      <h4 class="font-bold text-white">Tanvir D.</h4>
                      <p class="text-sm text-gray-400">CEO, LogisticsX</p>
                    </div>
                  </div>
                  <div class="star-gold flex mb-2">★★★★★</div>
                  <p class="text-gray-300">
                    “ERP streamlined operations, saved 30% cost. Highly
                    recommend.”
                  </p>
                </div>
              </div>
            </div>
          </div>
          <button
            id="carouselPrev"
            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-6 bg-black/60 hover:bg-[#195f95] text-white w-10 h-10 rounded-full flex items-center justify-center z-10 transition"
          >
            <i class="fas fa-chevron-left"></i>
          </button>
          <button
            id="carouselNext"
            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-6 bg-black/60 hover:bg-[#195f95] text-white w-10 h-10 rounded-full flex items-center justify-center z-10 transition"
          >
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- PROJECTS SHOWCASE -->
    <section id="projects" class="py-20 bg-[#0e080b]">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Recent Software Masterpieces
          </h2>
          <p class="text-gray-300 text-lg mt-3">
            Real impact, across industries
          </p>
        </div>
        <div class="text-center mt-10">
          <p class="text-[#e0bc7c] italic">
            + SaaS platforms, custom CRMs, NFT marketplaces — ask us anything.
          </p>
        </div>
      </div>
    </section>

    <!-- dynamic projects filler from existing (preserve structure) -->
    <div class="container mx-auto px-6 -mt-8">
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="project-card rounded-2xl overflow-hidden">
          <div
            class="h-52 bg-gradient-to-br from-[#195f95] to-[#0f354f] flex items-center justify-center"
          >
            <i class="fas fa-chart-simple text-[#e0bc7c] text-7xl"></i>
          </div>
          <div class="p-6">
            <h3 class="text-2xl font-bold text-white mb-2">
              AI Predictive Analytics Suite
            </h3>
            <p class="text-gray-300 mb-4">
              Retail chain demand forecasting + custom dashboards.
            </p>
            <div class="flex gap-2">
              <span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >Python/TensorFlow</span
              ><span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >React</span
              >
            </div>
          </div>
        </div>
        <div class="project-card rounded-2xl overflow-hidden">
          <div
            class="h-52 bg-gradient-to-br from-[#1c4a6e] to-[#0f2c3f] flex items-center justify-center"
          >
            <i class="fas fa-truck-fast text-[#e0bc7c] text-7xl"></i>
          </div>
          <div class="p-6">
            <h3 class="text-2xl font-bold text-white mb-2">
              Logistics ERP System
            </h3>
            <p class="text-gray-300 mb-4">
              Fleet, route optimization & warehouse management.
            </p>
            <div class="flex gap-2">
              <span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >Node.js</span
              ><span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >PostgreSQL</span
              >
            </div>
          </div>
        </div>
        <div class="project-card rounded-2xl overflow-hidden">
          <div
            class="h-52 bg-gradient-to-br from-[#195f95] to-[#0e2a40] flex items-center justify-center"
          >
            <i class="fas fa-hand-holding-heart text-[#e0bc7c] text-7xl"></i>
          </div>
          <div class="p-6">
            <h3 class="text-2xl font-bold text-white mb-2">
              Telemedicine Platform
            </h3>
            <p class="text-gray-300 mb-4">
              Video calls, prescriptions & patient portal.
            </p>
            <div class="flex gap-2">
              <span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >Flutter</span
              ><span
                class="bg-[#195f95]/40 px-3 py-1 rounded-full text-xs text-[#e0bc7c]"
                >Firebase</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- DIGITAL MARKETING -->
    <section id="digital-marketing" class="py-20 bg-[#0c070a]">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Data-Driven Growth Marketing
          </h2>
          <p class="text-gray-300 text-lg mt-2">
            Scale your brand with premium visibility & conversions
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="marketing-card rounded-2xl p-8 text-center">
            <div
              class="w-20 h-20 bg-[#195f95] rounded-2xl flex items-center justify-center mx-auto mb-5"
            >
              <i class="fab fa-searchengin text-4xl text-[#e0bc7c]"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">SEO Domination</h3>
            <p class="text-gray-300 mb-4">
              Rank #1, organic traffic, technical audits & link building.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Keyword research + content strategy</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Monthly ranking reports</span>
              </li>
            </ul>
          </div>
          <div class="marketing-card rounded-2xl p-8 text-center">
            <div
              class="w-20 h-20 bg-[#195f95] rounded-2xl flex items-center justify-center mx-auto mb-5"
            >
              <i class="fab fa-facebook-f text-4xl text-[#e0bc7c]"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">
              Facebook & Instagram Ads
            </h3>
            <p class="text-gray-300 mb-4">
              Hyper-targeting, lookalike audiences, ROAS focus.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Creative & copywriting A/B tests</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Scaling & daily optimization</span>
              </li>
            </ul>
          </div>
          <div class="marketing-card rounded-2xl p-8 text-center">
            <div
              class="w-20 h-20 bg-[#195f95] rounded-2xl flex items-center justify-center mx-auto mb-5"
            >
              <i class="fas fa-chart-simple text-4xl text-[#e0bc7c]"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">
              Boosting & Social Growth
            </h3>
            <p class="text-gray-300 mb-4">
              Viral campaigns, influencer partnerships & post amplification.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Post boosting & community mgmt</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-[#e0bc7c]"></i
                ><span>Follower growth strategy</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- PRICING SECTION (unchanged but with new accent) -->
    <section
      id="pricing"
      class="py-20 bg-gradient-to-b from-[#0b0608] to-[#120a0e]"
    >
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Transparent Pricing Plans
          </h2>
          <p class="text-gray-300 text-lg">
            Flexible options for software + marketing
          </p>
        </div>
        <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">
          <div class="pricing-card rounded-2xl p-8 relative">
            <div
              class="bg-[#195f95] p-1 rounded-xl inline-block px-5 py-1 text-[#e0bc7c] text-sm font-bold"
            >
              Setup & Launch
            </div>
            <div class="mt-4">
              <span class="text-3xl font-black text-white">৳25,000</span
              ><span class="text-gray-400">+</span>
              <p class="text-gray-400">one-time (custom scope)</p>
            </div>
            <ul class="mt-6 space-y-3">
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Software requirements & architecture design</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>UI/UX prototyping for new software</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>SEO audit + FB Ads account setup</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Ad creatives & landing page suggestions</span>
              </li>
            </ul>
            <a
              href="#contact"
              class="mt-8 block text-center py-3 bg-[#195f95] border border-[#e0bc7c]/50 text-white font-bold rounded-xl hover:bg-[#2378b3]"
              >Start Setup →</a
            >
          </div>
          <div
            class="pricing-card rounded-2xl p-8 relative border-2 border-[#e0bc7c]"
          >
            <div
              class="absolute -top-3 right-6 badge-popular px-4 py-1 rounded-full text-sm"
            >
              Most Popular
            </div>
            <div
              class="bg-gradient-to-r from-[#195f95] to-[#0f4c72] p-1 rounded-xl inline-block px-5 py-1 text-[#e0bc7c] text-sm font-bold"
            >
              Monthly Growth Plan
            </div>
            <div class="mt-4">
              <span class="text-3xl font-black text-white">৳8,000</span
              ><span class="text-gray-400">/month</span>
              <p class="text-gray-400">
                starting from (higher tiers for software dev)
              </p>
            </div>
            <ul class="mt-6 space-y-3">
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Monthly SEO content & backlinks</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Facebook/Instagram ad management</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Post boosting & engagement campaigns</span>
              </li>
              <li class="flex gap-3">
                <i class="fas fa-check-circle text-[#e0bc7c] mt-1"></i
                ><span>Priority support + optional software upgrades</span>
              </li>
            </ul>
            <a
              href="#contact"
              class="mt-8 block text-center py-3 bg-gradient-to-r from-[#e0bc7c] to-[#c59e5a] text-black font-extrabold rounded-xl hover:opacity-90"
              >Get Monthly Plan →</a
            >
          </div>
        </div>
        <p class="text-center mt-8 text-[#e0bc7c]">
          <i class="fas fa-gem mr-2"></i> Software + marketing bundle? Contact
          for custom quote. Any software, any budget.
        </p>
      </div>
    </section>

   <!-- CLIENT & PARTNER SECTION -->
<section
  id="partners"
  class="py-20 bg-gradient-to-r from-[#170b10] to-[#0d2a3b]"
>
  <div class="container mx-auto px-6 text-center">
    <h2
      class="text-3xl md:text-5xl font-bold text-white section-title mb-4"
    >
      Trusted Partners & Clients
    </h2>

    <p class="text-gray-200 max-w-2xl mx-auto mb-12">
      Collaborating with forward-thinking brands worldwide
    </p>

    <div
      class="flex flex-wrap justify-center items-center gap-12 md:gap-20"
    >
      @if ($clients->count())
        @foreach ($clients as $client)
          <div
            class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
          >
            @if (!empty($client->link))
              <a href="{{ $client->link }}" target="_blank" rel="noopener">
                <img
                  src="{{ asset('uploads/resource-images/' . $client->image) }}"
                  alt="{{ $client->title ?? 'Client' }}"
                  class="max-h-14 object-contain client-logo-grayscale"
                />
              </a>
            @else
              <img
                src="{{ asset('uploads/resource-images/' . $client->image) }}"
                alt="{{ $client->title ?? 'Client' }}"
                class="max-h-14 object-contain client-logo-grayscale"
              />
            @endif
          </div>
        @endforeach
      @else
        <!-- Logo 1 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >
          <img
            src="mg.png"
            alt="Modern Garments"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>

        <!-- Logo 2 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >
          <img
            src="mts.png"
            alt="machinetools"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>

        <!-- Logo 3 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >
          <img
            src="las.png"
            alt="LAS Gadgets Zone"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>

        <!-- Logo 4 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >
          <img
            src="masnad.jpeg"
            alt="Masnad"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>

        <!-- Logo 5 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >

          <img
            src="nimi.png"
            alt="Nimi Enterprise"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>

        <!-- Logo 6 -->
        <div
          class="client-card p-4 rounded-2xl w-40 h-24 flex items-center justify-center"
        >
          <img
            src="RT.png"
            alt="Rowshon Traders"
            class="max-h-14 object-contain client-logo-grayscale"
          />
        </div>
      @endif

    </div>

    <p
      class="text-sm text-gray-300 mt-12 border-t border-[#195f95] inline-block pt-4"
    >
      Join 80+ successful companies accelerating with LAS
    </p>
  </div>
</section>

    <!-- CONTACT SECTION (EmailJS integrated original) -->
    <section id="contact" class="py-20 bg-[#0a0608]">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-5xl font-bold text-white section-title">
            Let's Build Your Vision
          </h2>
          <p class="text-gray-300 text-lg mt-3">
            Free consultation — we respond within 24h
          </p>
        </div>
        <div class="flex flex-col lg:flex-row gap-12 max-w-5xl mx-auto">
          <div
            class="lg:w-1/2 bg-[#0f0a0d] p-8 rounded-2xl border border-[#195f95]"
          >
            <h3 class="text-2xl font-bold text-white mb-6">Connect With Us</h3>
            <div class="space-y-5">
              <div class="flex items-center gap-4">
                <i class="fas fa-envelope text-[#e0bc7c] w-6 text-xl"></i
                ><span class="text-gray-200"
                  >{{ $content['email'] }}</span
                >
              </div>
              <div class="flex items-center gap-4">
                <i class="fas fa-phone-alt text-[#e0bc7c] w-6 text-xl"></i
                ><span class="text-gray-200">{{ $content['phone'] }}</span>
              </div>
              <div class="flex items-center gap-4">
                <i class="fas fa-map-marker-alt text-[#e0bc7c] w-6 text-xl"></i
                ><span class="text-gray-200">Bangladesh | USA | Remote</span>
              </div>
            </div>
            <hr class="my-6 border-[#2a1e24]" />
            <div>
              <p class="text-white">
                <i class="fas fa-check-circle text-[#e0bc7c] mr-2"></i> Any
                software: AI, SaaS, Mobile, Web
              </p>
              <p class="text-white mt-2">
                <i class="fas fa-chart-line text-[#e0bc7c] mr-2"></i> SEO +
                Facebook Ads + Boosting inclusive
              </p>
            </div>
          </div>
          <div
            class="lg:w-1/2 bg-[#0f0a0d] p-8 rounded-2xl border border-[#195f95]"
          >
            <h3 class="text-2xl font-bold text-white mb-4">Request Quote</h3>
            <form id="contactForm">
              <input
                type="text"
                id="name"
                name="from_name"
                placeholder="Full Name*"
                class="w-full border border-[#3d1e28] bg-[#181012] p-3 rounded-lg mb-3"
                required
              /><input
                type="email"
                id="email"
                name="from_email"
                placeholder="Email*"
                class="w-full border border-[#3d1e28] bg-[#181012] p-3 rounded-lg mb-3"
                required
              /><select
                id="interest"
                name="interest"
                class="w-full border border-[#3d1e28] bg-[#181012] p-3 rounded-lg mb-3"
                required
              >
                <option value="">Select Service</option>
                <option>Custom Software Development</option>
                <option>SEO & Digital Marketing</option>
                <option>Facebook Ads & Boosting</option>
                <option>Software + Marketing Bundle</option></select
              ><textarea
                id="message"
                name="message"
                rows="3"
                placeholder="Tell us about your software idea or marketing goals..."
                class="w-full border border-[#3d1e28] bg-[#181012] p-3 rounded-lg mb-4"
                required
              ></textarea
              ><button
                type="submit"
                id="submitBtn"
                class="w-full py-3 bg-gradient-to-r from-[#195f95] to-[#103f63] text-white font-bold rounded-lg hover:shadow-lg transition"
              >
                Send Message →
              </button>
            </form>
            <div id="statusMessage" class="mt-4 text-center hidden"></div>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer-maroon py-10 text-center">
      <div class="container mx-auto">
        <p class="text-gray-400">
          © {{ date('Y') }} {{ $content['application_name'] }} — Custom Software (any kind) & Growth
          Marketing Agency. Maroon & Blue Identity
        </p>
        <div class="flex justify-center space-x-6 mt-4">
          <a href="#" class="text-gray-500 hover:text-[#e0bc7c] text-xl"
            ><i class="fab fa-linkedin"></i></a
          ><a href="#" class="text-gray-500 hover:text-[#e0bc7c] text-xl"
            ><i class="fab fa-twitter"></i></a
          ><a href="#" class="text-gray-500 hover:text-[#e0bc7c] text-xl"
            ><i class="fab fa-instagram"></i
          ></a>
        </div>
      </div>
    </footer>

    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"
    ></script>
    <script>


      // HERO IMAGE CAROUSEL
      // ---------------------------------------------------------
      // To add more images, simply add another .hero-slide block
      // inside #heroCarousel. Dots are generated automatically.
      // ---------------------------------------------------------
      const heroCarousel = document.getElementById("heroCarousel");
      const heroSlides = heroCarousel
        ? Array.from(heroCarousel.querySelectorAll(".hero-slide"))
        : [];
      const heroDotsContainer = document.getElementById("heroDots");
      const heroPrev = document.getElementById("heroPrev");
      const heroNext = document.getElementById("heroNext");

      let heroCurrentIndex = 0;
      let heroAutoTimer = null;
      let heroTouchStartX = 0;
      let heroTouchEndX = 0;

      function renderHeroDots() {
        if (!heroDotsContainer || !heroSlides.length) return;

        heroDotsContainer.innerHTML = "";

        heroSlides.forEach((_, index) => {
          const dot = document.createElement("button");
          dot.type = "button";
          dot.className = `hero-carousel-dot${index === heroCurrentIndex ? " active" : ""}`;
          dot.setAttribute("aria-label", `Go to hero slide ${index + 1}`);
          dot.addEventListener("click", () => {
            showHeroSlide(index);
            restartHeroAuto();
          });
          heroDotsContainer.appendChild(dot);
        });
      }

      function showHeroSlide(index) {
        if (!heroSlides.length) return;

        heroCurrentIndex = (index + heroSlides.length) % heroSlides.length;

        heroSlides.forEach((slide, slideIndex) => {
          slide.classList.toggle("active", slideIndex === heroCurrentIndex);
          slide.setAttribute(
            "aria-hidden",
            slideIndex === heroCurrentIndex ? "false" : "true",
          );
        });

        heroDotsContainer
          ?.querySelectorAll(".hero-carousel-dot")
          .forEach((dot, dotIndex) => {
            dot.classList.toggle("active", dotIndex === heroCurrentIndex);
          });
      }

      function heroNextSlide() {
        showHeroSlide(heroCurrentIndex + 1);
      }

      function heroPrevSlide() {
        showHeroSlide(heroCurrentIndex - 1);
      }

      function startHeroAuto() {
        if (heroAutoTimer) clearInterval(heroAutoTimer);
        if (heroSlides.length <= 1) return;
        heroAutoTimer = setInterval(heroNextSlide, 4500);
      }

      function stopHeroAuto() {
        if (heroAutoTimer) {
          clearInterval(heroAutoTimer);
          heroAutoTimer = null;
        }
      }

      function restartHeroAuto() {
        stopHeroAuto();
        startHeroAuto();
      }

      renderHeroDots();
      showHeroSlide(0);
      startHeroAuto();

      heroPrev?.addEventListener("click", () => {
        heroPrevSlide();
        restartHeroAuto();
      });

      heroNext?.addEventListener("click", () => {
        heroNextSlide();
        restartHeroAuto();
      });

      // Pause while the user is interacting with the carousel.
      heroCarousel?.addEventListener("mouseenter", stopHeroAuto);
      heroCarousel?.addEventListener("mouseleave", startHeroAuto);
      heroCarousel?.addEventListener("focusin", stopHeroAuto);
      heroCarousel?.addEventListener("focusout", startHeroAuto);

      // Mobile swipe support.
      heroCarousel?.addEventListener(
        "touchstart",
        (event) => {
          heroTouchStartX = event.changedTouches[0].screenX;
          stopHeroAuto();
        },
        { passive: true },
      );

      heroCarousel?.addEventListener(
        "touchend",
        (event) => {
          heroTouchEndX = event.changedTouches[0].screenX;
          const distance = heroTouchEndX - heroTouchStartX;

          if (Math.abs(distance) > 50) {
            if (distance < 0) heroNextSlide();
            else heroPrevSlide();
          }

          startHeroAuto();
        },
        { passive: true },
      );

      // Pause auto-play when the browser tab is hidden.
      document.addEventListener("visibilitychange", () => {
        if (document.hidden) stopHeroAuto();
        else startHeroAuto();
      });

      // EmailJS init
      (function () {
        emailjs.init("Uz-kDD1GTyxnL0cK5");
      })();
      const form = document.getElementById("contactForm");
      if (form) {
        form.addEventListener("submit", function (e) {
          e.preventDefault();
          const btn = document.getElementById("submitBtn"),
            original = btn.innerHTML;
          const statusDiv = document.getElementById("statusMessage");
          btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
          btn.disabled = true;
          const params = {
            from_name: document.getElementById("name").value,
            from_email: document.getElementById("email").value,
            interest: document.getElementById("interest").value,
            message: document.getElementById("message").value,
            to_email: "armanlizon.dev@gmail.com",
          };
          emailjs
            .send("service_ee4vj1h", "template_knfso2m", params)
            .then(() => {
              statusDiv.innerHTML =
                '<div class="bg-green-500/20 border border-green-500 text-green-300 p-3 rounded-lg">✅ Thank you! Our team will contact you within 24 hours.</div>';
              statusDiv.classList.remove("hidden");
              form.reset();
              setTimeout(() => statusDiv.classList.add("hidden"), 5000);
            })
            .catch(() => {
              statusDiv.innerHTML =
                '<div class="bg-red-500/20 border border-red-500 text-red-300 p-3 rounded-lg">❌ Failed. Call +88 01515664497</div>';
              statusDiv.classList.remove("hidden");
              setTimeout(() => statusDiv.classList.add("hidden"), 8000);
            })
            .finally(() => {
              btn.innerHTML = original;
              btn.disabled = false;
            });
        });
      }
      // carousel auto-run + manual
      const track = document.getElementById("testimonialTrack");
      const cards = Array.from(document.querySelectorAll(".carousel-card"));
      let currentIdx = 0,
        visibleCards = 1,
        intervalId;
      function updateCarousel() {
        if (!track) return;
        let cardWidthPercent = 100 / visibleCards;
        track.style.transform = `translateX(-${currentIdx * cardWidthPercent}%)`;
      }
      function setVisibleCards() {
        if (window.innerWidth >= 1024) visibleCards = 3;
        else if (window.innerWidth >= 768) visibleCards = 2;
        else visibleCards = 1;
        updateCarousel();
      }
      function nextSlide() {
        if (cards.length) {
          currentIdx =
            (currentIdx + 1) % Math.ceil(cards.length / visibleCards);
          updateCarousel();
        }
      }
      function prevSlide() {
        if (cards.length) {
          currentIdx =
            (currentIdx - 1 + Math.ceil(cards.length / visibleCards)) %
            Math.ceil(cards.length / visibleCards);
          updateCarousel();
        }
      }
      function startAutoRun() {
        if (intervalId) clearInterval(intervalId);
        intervalId = setInterval(nextSlide, 4000);
      }
      window.addEventListener("resize", () => {
        setVisibleCards();
        startAutoRun();
      });
      setVisibleCards();
      startAutoRun();
      document.getElementById("carouselPrev")?.addEventListener("click", () => {
        prevSlide();
        startAutoRun();
      });
      document.getElementById("carouselNext")?.addEventListener("click", () => {
        nextSlide();
        startAutoRun();
      });
      document.querySelectorAll('a[href^="#"]').forEach((anchor) =>
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          const targetId = this.getAttribute("href");
          if (targetId === "#") return;
          const target = document.querySelector(targetId);
          if (target)
            window.scrollTo({ top: target.offsetTop - 80, behavior: "smooth" });
          document.querySelector(".mobile-nav")?.classList.add("hidden");
        }),
      );
      document
        .querySelector(".mobile-menu-btn")
        ?.addEventListener("click", () =>
          document.querySelector(".mobile-nav")?.classList.toggle("hidden"),
        );
    </script>
  </body>
</html>
