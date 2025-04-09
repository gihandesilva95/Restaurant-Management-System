<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders ') }}
        </h2>
    </x-slot>
    <div class="card mt-5">
        <div class="card-body">
          
            @session('success')
                <div class="alert alert-success" role="alert" id="success_message"> {{ $value }} </div>
            @endsession

            <div class="d-grid gap-2 d-md-flex justify-content-md-end"> 
                <a class="btn btn-success btn-sm" href="{{ route('orders.create') }}"> <i class="fa fa-plus"></i> Create Order</a>
            </div>
    
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Order No</th>
                        <th>Selected Concessions</th>
                        <th>Send to Kitchen Time</th>
                        <th>Status</th>
                        <th width="250px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $order->order_no }}</td>
                            <td>
                                @foreach ($order->concessions as $concession)
                                    <span>{{ $concession->name }} (Rs. {{ $concession->price }})</span><br>
                                @endforeach
                            </td>
                            <td>{{ $order->send_to_kitchen_time }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @if ($order->status === 'Pending')
                                    <form action="{{ route('orders.sendToKitchen', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to send this order to the kitchen?');">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i> Send to Kitchen
                                        </button>
                                    </form>

                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">There are no Orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $orders->links() !!}
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

