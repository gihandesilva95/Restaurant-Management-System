<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Concessions ') }}
        </h2>
    </x-slot>
    <div class="card mt-5">
        <div class="card-body">
          
            @session('success')
                <div class="alert alert-success" role="alert" id="success_message"> {{ $value }} </div>
            @endsession

            <div class="d-grid gap-2 d-md-flex justify-content-md-end"> 
                <a class="btn btn-success btn-sm" href="{{ route('concessions.create') }}"> <i class="fa fa-plus"></i> Add New Concession</a>
            </div>
    
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th width="250px">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($concessions as $concession)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $concession->name }}</td>
                        <td>{{ $concession->description }}</td>
                        <td>
                            @if($concession->image)
                                <img src="{{ asset('storage/concessions/' . $concession->image) }}" alt="Concession Image" width="100">
                            @endif
                        </td>
                        <td>{{ $concession->price }}</td>
                        <td>
                            <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this concession?');">
                                <a class="btn btn-primary btn-sm" href="{{ route('concessions.edit', $concession->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">There are no data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {!! $concessions->links() !!}
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success_message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    });
</script>

