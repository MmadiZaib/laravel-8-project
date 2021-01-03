<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
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
        $location = 'image/brand/';
        $image = sprintf('%s%s', $location, $imageName);
        $brand_image->move($location, $imageName);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->brand_image  = $image;
        $brand->save();

        return Redirect::back()->with('success', 'Brand added successfully');
    }


    public function editBrand()
    {

    }

    public function deleteBrand()
    {

    }
}
