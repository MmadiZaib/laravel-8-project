<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MultiPicture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Image;

class BrandController extends Controller
{
    public const BRAND_IMAGE_PATH = 'image/brand/';
    public const MULTI_PATH = 'image/multi/';

    public function allBrand()
    {
        $brands = Brand::latest()->paginate(5);

        return view('admin.brand.index', compact('brands'));
    }

    public function addBrand(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
        ] , [
            'name.required' => 'Please Input Brand Name',
        ]);

        if ($request->hasFile('brand_image')){
            $brand_image = $request->file('brand_image');

            $unique_name = sprintf('%s.%s',  hexdec(uniqid()), $brand_image->getClientOriginalExtension());
            Image::make($brand_image)->resize(300, 200)->save(sprintf('%s%s', self::BRAND_IMAGE_PATH, $unique_name));
            $lastImage = self::BRAND_IMAGE_PATH . $unique_name;

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->brand_image  = $lastImage;
            $brand->save();
        }

        return Redirect::back()->with('success', 'Brand added successfully');
    }


    public function editBrand(int $id)
    {
        $brand = Brand::find($id);

        return view('admin.brand.edit', compact('brand'));
    }

    public function updateBrand(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:brands|min:4',
        ] , [
            'name.required' => 'Please Input Brand Name',
        ]);


        if ($request->hasFile('brand_image'))
        {
            $brand_image = $request->file('brand_image');
            $extension = strtolower($brand_image->getClientOriginalExtension());
            $imageName = sprintf('%s.%s', hexdec(uniqid()), $extension);
            $location = self::BRAND_IMAGE_PATH;
            $image = sprintf('%s%s', $location, $imageName);
            $brand_image->move($location, $imageName);
            unlink($old_image);

            $brand = Brand::find($id);
            $brand->update([
                'name' => $request->name,
                'brand_image' => $image
            ]);

        } else {
            $brand = Brand::find($id);
            $brand->update([
                'name' => $request->name,
            ]);
        }

        return Redirect::back()->with('success', 'Brand updated successfully');
    }

    public function deleteBrand(Request $request, int $id)
    {
        $brand = Brand::find($id);
        unlink($brand->brand_image);
        $brand->delete();

        return Redirect::route('all.brand')->with('success', 'Brand deleted successfully');
    }

    public function multiPicture()
    {
        $images = MultiPicture::all();

        return view('admin.multipicture.index', compact('images'));
    }

    public function storeImages(Request $request)
    {

        if ($request->hasFile('images')){
            $images = $request->file('images');

            foreach ($images as $image) {
                $unique_name = sprintf('%s.%s',  hexdec(uniqid()), $image->getClientOriginalExtension());
                Image::make($image)->resize(300, 200)->save(sprintf('%s%s', self::MULTI_PATH, $unique_name));
                $lastImage = self::MULTI_PATH . $unique_name;

                $picture = new MultiPicture();
                $picture->image  = $lastImage;
                $picture->save();
            }
        }

        return Redirect::back()->with('success', 'Added successfully');
    }
}
