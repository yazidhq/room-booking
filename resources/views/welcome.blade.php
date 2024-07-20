@extends('user.layouts.templates')

@section('konten')
    @include('user.layouts.jumbroton')

    <div class="container">

        <section class="mb-5">
            <p class="fs-1 fw-bold text-dark text-center py-3">Ruang</p>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100 rounded-0 shadow border-0 card-pop">
                        <div class="card-body p-4 text-center border-top border-dark border-3">
                            <p class="card-text">
                                <strong class="display-6 fw-bold text-dark">test</strong>
                            </p>
                        </div>
                        <div class="d-grid px-3 pb-3">
                            <button class="btn btn-dark-blue text-white">Lihat Ruangan</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 rounded-0 shadow border-0 card-pop">
                        <div class="card-body p-4 text-center border-top border-dark border-3">
                            <p class="card-text">
                                <strong class="display-6 fw-bold text-dark">test</strong>
                            </p>
                        </div>
                        <div class="d-grid px-3 pb-3">
                            <button class="btn btn-dark-blue text-white">Lihat Ruangan</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 rounded-0 shadow border-0 card-pop">
                        <div class="card-body p-4 text-center border-top border-dark border-3">
                            <p class="card-text">
                                <strong class="display-6 fw-bold text-dark">test</strong>
                            </p>
                        </div>
                        <div class="d-grid px-3 pb-3">
                            <button class="btn btn-dark-blue text-white">Lihat Ruangan</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
