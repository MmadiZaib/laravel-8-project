<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Category
        </h2>
    </x-slot>

    <div class="py-12">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Category</div>
                    <div class="card-body">
                        <form action="{{ route('update.category', ['id' => $category->id ]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="categoryName" value="{{ $category->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
