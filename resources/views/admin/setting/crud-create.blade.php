@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Setting</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Form Tambah Setting</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.settings-crud.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Key</label>
                        <input type="text"
                               name="key"
                               class="form-control @error('key') is-invalid @enderror"
                               value="{{ old('key') }}"
                               placeholder="Contoh: site_name">

                        @error('key')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Value</label>
                        <textarea name="value"
                                  class="form-control @error('value') is-invalid @enderror"
                                  rows="6"
                                  placeholder="Masukkan value setting">{{ old('value') }}</textarea>

                        @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>

                    <a href="{{ route('admin.settings-crud.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </form>
            </div>
        </div>
    </section>
@endsection