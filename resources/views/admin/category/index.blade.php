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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-header">
                        All Category
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Category Name</th>
                            <th scope="col">User</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }} </td>
                            <td>{{ $category->user->name }}</td>
                            <td>{{ $category->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('edit.category', ['id' => $category->id ]) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('delete.category', ['id' => $category->id]) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Add Category</div>
                    <div class="card-body">
                        <form action="{{ route('store.category') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="categoryName">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trash part -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Trash List
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Category Name</th>
                            <th scope="col">User</th>
                            <th scope="col">Deleted At</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($trashCategories as $trash)
                            <tr>
                                <td>{{ $trash->name }} </td>
                                <td>{{ $trash->user->name }}</td>
                                <td>{{ $trash->deleted_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('restore.category', ['id' => $category->id ]) }}" class="btn btn-info">Restore</a>
                                    <a href="{{ route('permanentDelete.category', ['id' => $trash->id]) }}" class="btn btn-danger">Permanent Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $trashCategories->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
