@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Setting</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Form Edit Setting</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.settings-crud.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Key</label>
                        <input type="text"
                               name="key"
                               class="form-control @error('key') is-invalid @enderror"
                               value="{{ old('key', $setting->key) }}">

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
                                  rows="6">{{ old('value', $setting->value) }}</textarea>

                        @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>

                    <a href="{{ route('admin.settings-crud.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </form>
            </div>
        </div>
    </section>
@endsection