@extends('user.layouts.templates')

@section('konten')
    <div class="bg-light" style="padding-bottom:15vh">
        <div class="container mt-5">
            <div class="py-5">
                <div class="bg-white p-5 shadow-sm rounded">
                    <div class="row">
                        <div class="col-md-2 border-2">
                            <a href="{{ route('user-profile') }}" class="text-decoration-none">
                                <p class="{{ request()->routeIs('user-profile') ? 'fw-bold text-dark-blue' : 'text-dark' }}">
                                    Profile
                                </p>
                            </a>
                            <a href="{{ route('user-reservasi') }}" class="text-decoration-none">
                                <p
                                    class="{{ request()->routeIs('user-reservasi') ? 'fw-bold text-dark-blue' : 'text-dark' }}">
                                    Reservasi
                                </p>
                            </a>
                        </div>
                        <div class="col-md-10 px-5 border-start border-2">
                            <p class="fs-3 fw-bold">Profile</p>
                            <div class="bg-white border rounded px-3 pt-3">
                                <div class="row">
                                    <div class="col">
                                        <p>
                                            <span class="fw-bold">{{ ucfirst(auth()->user()->name) }}</span> |
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p>{{ Str::upper(auth()->user()->status) }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mt-4">
                                <form action="{{ route('ubah-profile') }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" name="name"
                                        value="{{ auth()->user()->name }}">
                                    <input type="text" class="form-control my-2" name="email"
                                        value="{{ auth()->user()->email }}">
                                    <select id="status" class="form-control" name="status" required>
                                        <option hidden value="{{ auth()->user()->status }}">
                                            {{ ucfirst(auth()->user()->status) }}
                                        </option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="umum">Umum</option>
                                    </select>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-dark-blue">UPDATE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
