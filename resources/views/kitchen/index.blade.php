<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kitchen ') }}
        </h2>
    </x-slot>
    <div class="card mt-5">
        <div class="card-body">
          
            @session('success')
                <div class="alert alert-success" role="alert" id="success_message"> {{ $value }} </div>
            @endsession

            <div class="d-grid gap-2 d-md-flex justify-content-md-end"> 
                
            </div>
    
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Order No</th>
                        <th>Selected Concessions</th>
                        <th>Total Price</th>
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
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($order->concessions as $concession)
                                    <span>{{ $concession->name }} (Rs. {{ $concession->price }})</span><br>
                                    @php
                                        $totalPrice += $concession->price;
                                    @endphp
                                @endforeach
                            </td>
                            <td>Rs. {{ $totalPrice }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @if ($order->status === 'In-Progress')
                                    <form action="{{ route('kitchen.completeOrder', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure this order is complete?');">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i> Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">There are no orders.</td>
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

