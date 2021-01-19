<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Images
        </h2>
    </x-slot>

    <div class="py-12">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card-group">
                    @foreach($images as $picture)
                        <div class="col-md-4 mt-5">
                            <div class="card">
                                <img src="{{ asset($picture->image) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Multi Images</div>
                    <div class="card-body">
                        <form action="{{ route('store.image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="brand_image">Images</label>
                                <input type="file" name="images[]" class="form-control" id="images" aria-describedby="brandImage" multiple="">
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Image</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
