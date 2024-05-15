@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">تعديل الفاتورة</div>

                    <div class="card-body">
                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">الاسم</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" placeholder="مثال: مهند ريس" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $invoice->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="amount" class="col-md-4 col-form-label text-md-end">المبلغ</label>

                                <div class="col-md-6">
                                    <input id="amount" placeholder="مثال: 12000" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount', $invoice->amount) }}" required autocomplete="amount" autofocus>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="client_id" class="col-md-4 col-form-label text-md-end">العميل</label>

                                <div class="col-md-6">
                                    <select name="client_id" required id="client_id" class="form-control">
                                        <option value="">اختر العميل</option>
                                        @foreach($clients as $client)
                                            <option {{ $invoice->client_id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('client')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-end">النوع</label>

                                <div class="col-md-6">
                                    <select name="type" required id="type" class="form-control">
                                        <option value="">اختر النوع ( دفع, استلام )</option>
                                        <option {{ $invoice->type == 1 ? 'selected' : '' }} value="1">دفع</option>
                                        <option {{ $invoice->type == 2 ? 'selected' : '' }} value="2">استلام</option>
                                    </select>

                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">الوصف</label>

                                <div class="col-md-6">
                                    <textarea id="description" placeholder="وصف الفاتورة ( غير ضروري )" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus>
                                        {{ old('description', $invoice->description) }}
                                    </textarea>

                                    @error('description')
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
