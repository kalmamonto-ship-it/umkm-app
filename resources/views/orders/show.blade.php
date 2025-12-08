@extends('layouts.app')

@section('title', 'Detail Pesanan - Aplikasi UMKM')
@section('page-title', 'Detail Pesanan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('page-actions')
<div class="btn-group" role="group">
    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>
        Edit
    </a>
    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
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
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Item Pesanan
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
    
    <div class="col-md-4">
        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Pesanan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>No. Pesanan:</strong></td>
                        <td><code>{{ $order->order_number }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @break
                                @case('processing')
                                    <span class="badge bg-info">Diproses</span>
                                    @break
                                @case('shipped')
                                    <span class="badge bg-primary">Dikirim</span>
                                    @break
                                @case('delivered')
                                    <span class="badge bg-success">Diterima</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td><strong class="text-primary">Rp {{ number_format($order->total_amount) }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Customer Information -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>{{ $order->shipping_address }}</td>
                    </tr>
                </table>
                
                @if($order->notes)
                    <div class="mt-3">
                        <h6>Catatan:</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
