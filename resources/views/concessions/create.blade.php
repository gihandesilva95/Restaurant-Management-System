<x-app-layout>

<div class="card mt-5">
  <h2 class="card-header">Register New concession</h2>
  <div class="card-body">

    <form action="{{ route('concessions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label"><strong>Description:</strong></label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" value="{{ old('description') }}" placeholder="Description">
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label"><strong>Price:</strong></label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" placeholder="Price">
            @error('price')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="image" class="form-label"><strong>Image:</strong></label>
            <div class="relative">
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror border @if($errors->has('image')) border-danger @endif p-1" id="image">
                @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-primary" href="{{ route('concessions.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
        </div>
    </form>

  </div>
</div>

</x-app-layout>
