@extends('backend.layout.app')
@section('title', 'Settings | '.Helper::getSettings('application_name') ?? 'Machine Tool Solution' )
@section('content')
    @php
        $lasLanding = json_decode(Helper::getSettings('las_digital_content') ?: '{}', true) ?: [];
        $amarLanding = json_decode(Helper::getSettings('amar_hishab_content') ?: '{}', true) ?: [];
        $settingAsset = static function ($path) {
            return $path ? asset(ltrim($path, '/')) : asset('assets/img/no-img.jpg');
        };
    @endphp
    <div class="container-fluid px-4">
        <h4 class="mt-2">Settings</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center"><h5 class="m-0">Static Content</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('admin.setting.update') }}" id="settingForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">About Us:</label>
                        <div class="col-sm-9">
                            <textarea name="about_us" id="" class="tinymceText form-control" cols="30" rows="20">{!! Helper::getSettings('about_us') !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">About Page Images:</label>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_1', 'settingForm .about_image_1_image')" name="about_image_1" id="about_image_1">
                            <img src="{{ Helper::getSettings('about_image_1') ? asset('uploads/settings/'.Helper::getSettings('about_image_1')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_1_image mt-1 border" alt="">
                        </div>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_2', 'settingForm .about_image_2_image')" name="about_image_2" id="about_image_2">
                            <img src="{{ Helper::getSettings('about_image_2') ? asset('uploads/settings/'.Helper::getSettings('about_image_2')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_2_image mt-1 border" alt="">
                        </div>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_3', 'settingForm .about_image_3_image')" name="about_image_3" id="about_image_3">
                            <img src="{{ Helper::getSettings('about_image_3') ? asset('uploads/settings/'.Helper::getSettings('about_image_3')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_3_image mt-1 border" alt="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="las_digital_content" class="col-sm-3 col-form-label">LAS Digital Landing Page:</label>
                        <div class="col-sm-9">
                            <textarea name="las_digital_content" id="las_digital_content" class="form-control" rows="12">{{ Helper::getSettings('las_digital_content') ?: json_encode(['application_name' => 'LAS Digital Solutions', 'logo' => 'assets/img/Logo.png', 'hero_badge' => 'Custom software • AI to ERP • Marketing Suite', 'hero_title' => 'Build <span class="text-[#e0bc7c]">Powerful</span> Software & Dominate With <span class="text-[#f5d99b]">Growth Marketing</span>', 'hero_copy' => 'From AI platforms, mobile apps to complex ERPs, we craft high-performance solutions. Plus SEO, Facebook Ads & viral boosting — all under one roof.', 'phone' => '+88 01515664497', 'email' => 'armanlizon.dev@gmail.com', 'hero_images' => ['ahs_covee.png', 'ahk2.png', 'ahk3.png'], 'product_link' => '/amar-hishab'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                            <small class="form-text text-muted">Valid JSON. Image values may be a public path, uploaded settings path, or full URL.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">LAS Digital Media Uploads:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Logo</label>
                                    <input type="file" name="las_logo" class="form-control" accept="image/*">
                                    <img src="{{ $settingAsset($lasLanding['logo'] ?? null) }}" class="mt-2 border" height="60" width="110" alt="LAS logo">
                                </div>
                                @foreach ([1, 2, 3] as $heroIndex)
                                    <div class="col-md-3 mb-3">
                                        <label>Hero image {{ $heroIndex }}</label>
                                        <input type="file" name="las_hero_{{ $heroIndex }}" class="form-control" accept="image/*">
                                        <img src="{{ $settingAsset($lasLanding['hero_images'][$heroIndex - 1] ?? null) }}" class="mt-2 border" height="60" width="110" alt="LAS hero {{ $heroIndex }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amar_hishab_content" class="col-sm-3 col-form-label">Amar Hishab Landing Page:</label>
                        <div class="col-sm-9">
                            <textarea name="amar_hishab_content" id="amar_hishab_content" class="form-control" rows="12">{{ Helper::getSettings('amar_hishab_content') ?: json_encode(['application_name' => 'Amar Hishab Keeper', 'logo' => 'assets/img/Logo.png', 'hero_title' => 'আমার হিসাব Keeper', 'hero_copy' => 'আধুনিক ব্যবসার জন্য স্মার্ট ইনভেন্টরি, বিক্রয়, ক্রয়, ক্লায়েন্ট ও রিপোর্ট ম্যানেজমেন্ট — সব এক প্ল্যাটফর্মে।', 'starting_price' => '899', 'hero_images' => ['ahs_covee.png', 'ahk2.png', 'ahk3.png'], 'demo_video' => 'amar-hishab-keeper-demo.mp4', 'demo_poster' => 'demo-poster.jpg'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                            <small class="form-text text-muted">Valid JSON. Changes are visible on the frontend after saving.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Amar Hishab Media Uploads:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Logo</label>
                                    <input type="file" name="ah_logo" class="form-control" accept="image/*">
                                    <img src="{{ $settingAsset($amarLanding['logo'] ?? null) }}" class="mt-2 border" height="60" width="110" alt="Amar Hishab logo">
                                </div>
                                @foreach ([1, 2, 3] as $heroIndex)
                                    <div class="col-md-3 mb-3">
                                        <label>Hero image {{ $heroIndex }}</label>
                                        <input type="file" name="ah_hero_{{ $heroIndex }}" class="form-control" accept="image/*">
                                        <img src="{{ $settingAsset($amarLanding['hero_images'][$heroIndex - 1] ?? null) }}" class="mt-2 border" height="60" width="110" alt="Amar Hishab hero {{ $heroIndex }}">
                                    </div>
                                @endforeach
                                <div class="col-md-6 mb-3">
                                    <label>Demo video</label>
                                    <input type="file" name="ah_demo_video" class="form-control" accept="video/mp4,video/webm,video/quicktime">
                                    @if (!empty($amarLanding['demo_video']))
                                        <a href="{{ $settingAsset($amarLanding['demo_video']) }}" target="_blank" class="d-block mt-2">View current demo video</a>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Demo poster</label>
                                    <input type="file" name="ah_demo_poster" class="form-control" accept="image/*">
                                    <img src="{{ $settingAsset($amarLanding['demo_poster'] ?? null) }}" class="mt-2 border" height="60" width="110" alt="Demo poster">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('footer')
        <script type="text/javascript">
            
        </script>
    @endpush
@endsection