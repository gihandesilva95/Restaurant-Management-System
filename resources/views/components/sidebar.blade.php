<aside class="bg-gray-400 border-end shadow-sm d-flex flex-column" style="width: 250px; min-height: 100vh;">
    <div class="p-3 border-bottom text-center fw-bold fs-5">
        
    </div>

    <div class="list-group list-group-flush">
        <a href="{{ route('concessions.index') }}" class=" bg-gray-400 list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-utensils me-2"></i> Concessions
        </a>
        <a href="{{ route('orders.index') }}" class="bg-gray-400 list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-receipt me-2"></i> Orders
        </a>
        <a href="{{ route('kitchen.index') }}" class="bg-gray-400 list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-hamburger me-2"></i> Kitchen
        </a>
        <a href="#" class="bg-gray-400 list-group-item list-group-item-action d-none align-items-center">
      
        </a>
    </div>
</aside>

