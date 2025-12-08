@extends('layouts.app')

@section('title', 'Produk - Aplikasi UMKM')
@section('page-title', 'Produk')

@section('breadcrumb')
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('page-actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Produk
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-box me-2"></i>
                Daftar Produk
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if ($product->is_featured)
                                        <span class="badge bg-warning ms-1">Unggulan</span>
                                    @endif
                                    <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp {{ number_format($product->price) }}</strong>
                                </td>
                                <td>
                                    @if ($product->stock > 0)
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
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
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada produk</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i>
                                        Tambah Produk Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($products->hasPages())
            <div class="card-footer bg-white">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
