@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center h1">الفواتير</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">اضافة فاتورة جديدة</a>
        <div class="row">
            <div class="col-md-3">
                <div class="row my-2">
                    <label for="filter_client" class="col-md-3 col-form-label text-md-end">العميل</label>

                    <div class="col-md-9">
                        <select v-on:change="change_filter_client()" name="filter_client" required id="filter_client" class="form-control form-select">
                            <option value="">اختر العميل</option>
                            @foreach($clients as $client)
                                <option {{ $client_id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row my-2">
                    <label for="filter_type" class="col-md-3 col-form-label text-md-end">النوع</label>

                    <div class="col-md-9">
                        <select v-on:change="change_filter_type()" name="filter_type" required id="filter_type" class="form-control">
                            <option value="">اختر النوع ( دفع, استلام )</option>
                            <option {{ $type == 1 ? 'selected' : '' }} value="1">دفع</option>
                            <option {{ $type == 2 ? 'selected' : '' }} value="2">استلام</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="w-20">عنوان الفاتورة</th>
                    <th class="w-20">المبلغ</th>
                    <th class="w-20">النوع</th>
                    @if(!$client_id)
                        <th class="w-20">العميل</th>
                    @endif
                    <th class="w-20">التحكم</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td class="w-20">{{ $invoice->name }}</td>
                        <td class="w-20">{{ $invoice->amount }}</td>
                        <td class="w-20">{{ $invoice->type == 1 ? 'دفع' : 'استلام' }}</td>
                        @if(!$client_id)
                            <td class="w-20">{{ $invoice->client->name }}</td>
                        @endif
                        <td class="w-20">
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-success btn-sm mt-3">تعديل</a>
                            <a target="_blank" href="https://wa.me/+963{{ substr($invoice->client->phonenumber, 1) }}?text=تم {{ $invoice->type == 1 ? 'دفع' : 'استلام' }} فاتورة *{{ $invoice->name }}* بمبلغ {{ $invoice->amount }} بتاريخ {{ $invoice->created_at }}" class="btn btn-primary mt-3 btn-sm">واتساب</a>
                            <form onsubmit="return confirm('هل أنت متأكد من أنك تريد الحذف؟')" action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mt-3">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(count($invoices) == 0)
            <h1 class="text-center"> لا يوجد فواتير</h1>
        @endif
    </div>
@endsection
