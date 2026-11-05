<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use Helper;
use Hash;
use Image;
use App\Models\User;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Product;
use Session;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if (!$this->user || $this->user->role == 2 || Helper::hasRight('user.view') == false) {
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function general(){
        return view('backend.pages.setting.general');
    }

    public function staticContent(){
        return view('backend.pages.setting.static-content');
    }

    public function legalContent (){
        return view('backend.pages.setting.legal-content');
    }

    public function update(Request $request){
		
        $request->validate([
            'las_digital_content' => ['nullable', 'json'],
            'amar_hishab_content' => ['nullable', 'json'],
            'las_logo' => ['nullable', 'image', 'max:5120'],
            'las_hero_1' => ['nullable', 'image', 'max:5120'],
            'las_hero_2' => ['nullable', 'image', 'max:5120'],
            'las_hero_3' => ['nullable', 'image', 'max:5120'],
            'ah_logo' => ['nullable', 'image', 'max:5120'],
            'ah_hero_1' => ['nullable', 'image', 'max:5120'],
            'ah_hero_2' => ['nullable', 'image', 'max:5120'],
            'ah_hero_3' => ['nullable', 'image', 'max:5120'],
            'ah_demo_video' => ['nullable', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:614400'],
            'ah_demo_poster' => ['nullable', 'image', 'max:5120'],
        ]);

        $data = [];
		$uploadedFiles = [];
        $uploadDirectory = public_path('uploads/settings');

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        foreach($request->file() as $key => $val){
            if ($request->hasFile($key)) {
                $image = $request->file($key);
                $filename = time().uniqid().'.'.$image->getClientOriginalExtension();
                $image->move($uploadDirectory, $filename);
                $uploadedFiles[$key] = 'uploads/settings/'.$filename;
            }
        }

        foreach ($request->input() as $key => $val) {
            if (!is_array($val)) {
                $request->validate([
                    $val => 'nullable'
                ]);
                $data[$key] = $val;
            } else {
                $data[$key] = implode(',', $val);
            }
        }
		
        unset($data['_token']);

        $lasJson = $data['las_digital_content'] ?? Helper::getSettings('las_digital_content');
        $lasContent = json_decode($lasJson ?: '{}', true);
        $lasContent = is_array($lasContent) ? $lasContent : [];
        $amarJson = $data['amar_hishab_content'] ?? Helper::getSettings('amar_hishab_content');
        $amarContent = json_decode($amarJson ?: '{}', true);
        $amarContent = is_array($amarContent) ? $amarContent : [];

        $lasFileMap = [
            'las_logo' => ['logo'],
            'las_hero_1' => ['hero_images', 0],
            'las_hero_2' => ['hero_images', 1],
            'las_hero_3' => ['hero_images', 2],
        ];
        foreach ($lasFileMap as $field => $path) {
            if (isset($uploadedFiles[$field])) {
                if (count($path) === 1) {
                    $lasContent[$path[0]] = $uploadedFiles[$field];
                } else {
                    $lasContent[$path[0]][$path[1]] = $uploadedFiles[$field];
                }
            }
        }

        $amarFileMap = [
            'ah_logo' => ['logo'],
            'ah_hero_1' => ['hero_images', 0],
            'ah_hero_2' => ['hero_images', 1],
            'ah_hero_3' => ['hero_images', 2],
            'ah_demo_video' => ['demo_video'],
            'ah_demo_poster' => ['demo_poster'],
        ];
        foreach ($amarFileMap as $field => $path) {
            if (isset($uploadedFiles[$field])) {
                if (count($path) === 1) {
                    $amarContent[$path[0]] = $uploadedFiles[$field];
                } else {
                    $amarContent[$path[0]][$path[1]] = $uploadedFiles[$field];
                }
            }
        }

        $data['las_digital_content'] = json_encode($lasContent, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $data['amar_hishab_content'] = json_encode($amarContent, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        foreach ($data as $key => $val) {
            $settings = Setting::updateOrCreate(
                ['key' =>  $key],
                ['value' => $val]
            );
        }
        session()->flash('success', 'Settings Successfully Updated!');
        return back();
    }

    public function changeLanguage(Request $request){
        $language = $request->input('language');
        Session::put('admin_language', $language);
        return true;
    }
	
	public function reorder(){
		$categories = Category::where('show_home', 1)
				->where('status', 1)
				->orderBy('short_number', 'asc')
				->get();
		return view('backend.pages.setting.reorder', compact('categories'));
	}
	
	public function reorderPost(Request $request){
		
		foreach($request->categories as $key => $value){
			$category = Category::find($value);
			$category->short_number = $key + 1;
			$category->save();
		}
		
		foreach($request->products as $key => $value){
			$product = Product::find($value);
			$product->short_number = $key + 1;
			$product->save();
		}
		
		session()->flash('success', 'Reorder updated!');
        return back();
	}
}
