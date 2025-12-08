@extends('layouts.app')

@section('title', 'Detail Produk - Aplikasi UMKM')
@section('page-title', 'Detail Produk')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('page-actions')
<div class="btn-group" role="group">
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>
        Edit
    </a>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-2"></i>
            Hapus
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-image me-2"></i>
                    Gambar Produk
                </h5>
            </div>
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                         class="img-fluid rounded" style="max-height: 300px;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                         style="height: 300px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Produk
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td><span class="badge bg-info">{{ $product->category->name }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Harga:</strong></td>
                                <td><strong class="text-primary">Rp {{ number_format($product->price) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Stok:</strong></td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Unggulan:</strong></td>
                                <td>
                                    @if($product->is_featured)
                                        <span class="badge bg-warning">Ya</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Slug:</strong></td>
                                <td><code>{{ $product->slug }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6>Deskripsi:</h6>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
            </div>
        </div>
        
        <!-- Order History -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Pesanan
                </h5>
            </div>
            <div class="card-body p-0">
                @if($product->orderItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->orderItems as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $item->order->id) }}" class="text-decoration-none">
                                            {{ $item->order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $item->order->customer_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->subtotal) }}</td>
                                    <td>{{ $item->order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada pesanan untuk produk ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
