@extends('layouts.app')

@section('title', 'Detail Kategori - Aplikasi UMKM')
@section('page-title', 'Detail Kategori')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('page-actions')
<div class="btn-group" role="group">
    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>
        Edit
    </a>
    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Kategori
                </h5>
            </div>
            <div class="card-body">
                @if($category->image)
                    <div class="text-center mb-3">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" 
                             class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                @endif
                
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Slug:</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Produk:</strong></td>
                        <td><span class="badge bg-info">{{ $category->products->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
                
                @if($category->description)
                    <div class="mt-3">
                        <h6>Deskripsi:</h6>
                        <p class="text-muted">{{ $category->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-box me-2"></i>
                    Produk dalam Kategori Ini
                </h5>
            </div>
            <div class="card-body p-0">
                @if($category->products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->is_featured)
                                            <span class="badge bg-warning ms-1">Unggulan</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($product->price) }}</td>
                                    <td>
                                        @if($product->stock > 0)
                                            <span class="badge bg-success">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" 
                                           class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada produk dalam kategori ini</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>
                            Tambah Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
