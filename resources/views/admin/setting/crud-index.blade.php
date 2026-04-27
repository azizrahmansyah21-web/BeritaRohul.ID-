@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>CRUD Settings</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Daftar Settings</h4>

                <div class="card-header-action">
                    <a href="{{ route('admin.settings-crud.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Setting
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Key</th>
                                <th>Value</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($settingItems as $setting)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $setting->key }}</strong>
                                    </td>
                                    <td>
                                        {{ Str::limit($setting->value, 80) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.settings-crud.edit', $setting->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.settings-crud.destroy', $setting->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus setting ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Data setting belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="float-right">
                    {{ $settingItems->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection