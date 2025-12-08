@extends('layouts.app')

@section('title', 'Pesanan - Aplikasi UMKM')
@section('page-title', 'Pesanan')

@section('breadcrumb')
<li class="breadcrumb-item active">Pesanan</li>
@endsection

@section('page-actions')
<a href="{{ route('orders.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>
    Buat Pesanan
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-shopping-cart me-2"></i>
            Daftar Pesanan
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_email }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">Rp {{ number_format($order->total_amount) }}</strong>
                        </td>
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
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('orders.show', $order->id) }}" 
                                   class="btn btn-sm btn-outline-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}" 
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada pesanan</p>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>
                                Buat Pesanan Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
