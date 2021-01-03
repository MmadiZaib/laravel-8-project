<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brand
        </h2>
    </x-slot>

    <div class="py-12">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-header">
                        All Brand
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Brand Image</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }} </td>
                                <td><img src="{{ asset($brand->brand_image) }}" alt="" style="height: 70px; width: 70px;"></td>
                                <td>{{ $brand->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('edit.brand', ['id' => $brand->id ]) }}" class="btn btn-info">Edit</a>
                                    <a href="{{ route('delete.brand', ['id' => $brand->id]) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $brands->links() }}

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Add Brand</div>
                    <div class="card-body">
                        <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Brand Name</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="brandName">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="brand_image">Brand Image</label>
                                <input type="file" name="brand_image" class="form-control" id="brand_image" aria-describedby="brandImage">
                                @error('brand_image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
