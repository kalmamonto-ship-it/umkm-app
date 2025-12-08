@extends('layouts.app')

@section('title', 'Edit Pesanan - Aplikasi UMKM')
@section('page-title', 'Edit Pesanan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('page-actions')
<a href="{{ route('orders.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>
    Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Pesanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                                       id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                               id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" required>
                        @error('customer_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                  id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="2">{{ old('notes', $order->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Diterima</option>
                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Order Items Display -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Item Pesanan (Read Only)
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" 
                                                 class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name }}</strong>
                                            <br><small class="text-muted">{{ $item->product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>Rp {{ number_format($item->subtotal) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($order->total_amount) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
