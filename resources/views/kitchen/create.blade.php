<x-app-layout>
    <div class="card mt-5">
        <h2 class="card-header">Create New Order</h2>
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <!-- Select Concessions -->
                <div class="mb-3">
                    <label for="concessions" class="form-label"><strong>Select Concessions:</strong></label>
                    <div class="multiple-select-container">
                        <div class="selected-items">
                            <!-- Selected items will appear here as tags -->
                        </div>
                        <select name="concessions[]" id="concessions" multiple class="d-none">
                            @foreach ($concessions as $concession)
                                <option value="{{ $concession->id }}">{{ $concession->name }} - Rs. {{ $concession->price }}</option>
                            @endforeach
                        </select>
                        <div class="dropdown">
                            <div class="multiple">
                                <div class="selected-tags">
                                    <!-- Selected tags will be inserted here by JavaScript -->
                                </div>
                                <input type="text" class="search-input" placeholder="Search...">
                            </div>
                            <div class="options-container">
                                <ul class="options-list">
                                    @foreach ($concessions as $concession)
                                        <li data-value="{{ $concession->id }}" class="option-item">
                                            {{ $concession->name }} - Rs. {{ $concession->price }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @error('concessions')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Send to Kitchen Time -->
                <div class="mb-3">
                    <label for="send_to_kitchen_time" class="form-label"><strong>Send to Kitchen Time:</strong></label>
                    <input type="datetime-local" name="send_to_kitchen_time" class="form-control @error('send_to_kitchen_time') is-invalid @enderror" id="send_to_kitchen_time" value="{{ old('send_to_kitchen_time') }}" required>
                    @error('send_to_kitchen_time')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary" href="{{ route('orders.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Create Order</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const multipleSelect = document.querySelector('.multiple');
            const optionsContainer = document.querySelector('.options-container');
            const optionItems = document.querySelectorAll('.option-item');
            const searchInput = document.querySelector('.search-input');
            const selectedTags = document.querySelector('.selected-tags');
            const hiddenSelect = document.getElementById('concessions');
            
            // Toggle dropdown
            multipleSelect.addEventListener('click', function() {
                optionsContainer.style.display = optionsContainer.style.display === 'block' ? 'none' : 'block';
                searchInput.focus();
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!multipleSelect.contains(e.target) && !optionsContainer.contains(e.target)) {
                    optionsContainer.style.display = 'none';
                }
            });
            
            // Filter options on search
            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                optionItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchText) ? 'block' : 'none';
                });
            });
            
            // Select/deselect option
            optionItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const value = this.dataset.value;
                    const text = this.textContent.trim();
                    
                    const option = Array.from(hiddenSelect.options).find(opt => opt.value === value);
                    
                    if (this.classList.contains('selected')) {
                        // Deselect
                        this.classList.remove('selected');
                        option.selected = false;
                        
                        // Remove tag
                        const tag = document.querySelector(`.tag[data-value="${value}"]`);
                        if (tag) tag.remove();
                    } else {
                        // Select
                        this.classList.add('selected');
                        option.selected = true;
                        
                        // Add tag
                        const tag = document.createElement('div');
                        tag.classList.add('tag');
                        tag.dataset.value = value;
                        tag.innerHTML = `${text.split(' - ')[0]} <span class="remove">×</span>`;
                        
                        tag.querySelector('.remove').addEventListener('click', function(e) {
                            e.stopPropagation();
                            tag.remove();
                            item.classList.remove('selected');
                            option.selected = false;
                        });
                        
                        selectedTags.appendChild(tag);
                    }
                });
            });
        });
    </script>
</x-app-layout>