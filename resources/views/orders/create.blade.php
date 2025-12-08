@extends('layouts.app')

@section('title', 'Buat Pesanan - Aplikasi UMKM')
@section('page-title', 'Buat Pesanan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
<li class="breadcrumb-item active">Buat</li>
@endsection

@section('page-actions')
<a href="{{ route('orders.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>
    Kembali
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Form Pesanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    
                    <!-- Customer Information -->
                    <h6 class="mb-3">
                        <i class="fas fa-user me-2"></i>
                        Informasi Pelanggan
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                               id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                        @error('customer_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                  id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Product Selection -->
                    <h6 class="mb-3 mt-4">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Pilih Produk
                    </h6>
                    
                    <div id="productList">
                        <div class="product-item border rounded p-3 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Produk <span class="text-danger">*</span></label>
                                        <select class="form-select product-select" name="products[0][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->price }}" 
                                                        data-stock="{{ $product->stock }}">
                                                    {{ $product->name }} - Rp {{ number_format($product->price) }} (Stok: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control quantity-input" 
                                               name="products[0][quantity]" min="1" value="1" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control subtotal-display" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="addProduct">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Produk
                    </button>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Buat Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calculator me-2"></i>
                    Ringkasan Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total Item: </strong>
                    <span id="totalItems">0</span>
                </div>
                <div class="mb-3">
                    <strong>Total Harga: </strong>
                    <span id="totalAmount" class="text-primary fw-bold">Rp 0</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let productIndex = 1;

document.getElementById('addProduct').addEventListener('click', function() {
    const productList = document.getElementById('productList');
    const newProduct = document.querySelector('.product-item').cloneNode(true);
    
    // Update names and clear values
    newProduct.querySelector('.product-select').name = `products[${productIndex}][product_id]`;
    newProduct.querySelector('.product-select').value = '';
    newProduct.querySelector('.quantity-input').name = `products[${productIndex}][quantity]`;
    newProduct.querySelector('.quantity-input').value = '1';
    newProduct.querySelector('.subtotal-display').value = '';
    
    productList.appendChild(newProduct);
    productIndex++;
    
    // Reattach event listeners
    attachEventListeners();
});

function attachEventListeners() {
    // Product selection change
    document.querySelectorAll('.product-select').forEach(select => {
        select.addEventListener('change', calculateSubtotal);
    });
    
    // Quantity change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', calculateSubtotal);
    });
}

function calculateSubtotal() {
    let totalItems = 0;
    let totalAmount = 0;
    
    document.querySelectorAll('.product-item').forEach(item => {
        const select = item.querySelector('.product-select');
        const quantityInput = item.querySelector('.quantity-input');
        const subtotalDisplay = item.querySelector('.subtotal-display');
        
        if (select.value && quantityInput.value) {
            const price = parseFloat(select.options[select.selectedIndex].dataset.price);
            const quantity = parseInt(quantityInput.value);
            const subtotal = price * quantity;
            
            subtotalDisplay.value = `Rp ${subtotal.toLocaleString()}`;
            totalItems += quantity;
            totalAmount += subtotal;
        } else {
            subtotalDisplay.value = '';
        }
    });
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalAmount').textContent = `Rp ${totalAmount.toLocaleString()}`;
}

// Initial event listeners
attachEventListeners();
</script>
@endpush
