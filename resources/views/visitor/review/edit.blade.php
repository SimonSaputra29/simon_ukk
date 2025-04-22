@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header bg-warning text-white text-center">
                <h4>Edit Ulasan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ulasans.update', $ulasan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="content" class="form-label">📝 Ulasan:</label>
                        <textarea name="content" id="content" class="form-control" rows="3" required>{{ $ulasan->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">⭐ Rating:</label>
                        <select name="rating" id="rating" class="form-select" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $ulasan->rating == $i ? 'selected' : '' }}>
                                    {{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
