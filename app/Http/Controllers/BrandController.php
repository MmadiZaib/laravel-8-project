<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public const BRAND_IMAGE_PATH = 'image/brand/';

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

        $brand_image = $request->file('brand_image');
        $extension = strtolower($brand_image->getClientOriginalExtension());
        $imageName = sprintf('%s.%s', hexdec(uniqid()), $extension);
        $location = self::BRAND_IMAGE_PATH;
        $image = sprintf('%s%s', $location, $imageName);
        $brand_image->move($location, $imageName);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->brand_image  = $image;
        $brand->save();

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

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        if ($brand_image)
        {
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

    }
}
