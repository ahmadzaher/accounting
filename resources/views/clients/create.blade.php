@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">اضافة عميل جديد</div>

                    <div class="card-body">
                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">الاسم</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" placeholder="مثال: مهند ريس" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phonenumber" class="col-md-4 col-form-label text-md-end">رقم الهاتف</label>

                                <div class="col-md-6">
                                    <input id="phonenumber" placeholder="09********" type="text" class="form-control @error('phonenumber') is-invalid @enderror" name="phonenumber" value="{{ old('phonenumber') }}" required autocomplete="phonenumber" autofocus>

                                    @error('phonenumber')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
