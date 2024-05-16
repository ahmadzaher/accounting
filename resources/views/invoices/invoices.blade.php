@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center h1">الفواتير</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">اضافة فاتورة جديدة</a>
        <form action="{{ route('invoices.index') }}" method="GET">
            <div class="row">

                <div class="col-md-3">
                    <div class="row my-2">
                        <label for="client_id" class="col-md-3 col-form-label text-md-end">العميل</label>

                        <div class="col-md-9">
                            <select name="client_id" id="client_id" class="form-control form-select">
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
                        <label for="type" class="col-md-3 col-form-label text-md-end">النوع</label>

                        <div class="col-md-9">
                            <select name="type" id="type" class="form-control form-select">
                                <option value="">الدفع والاستلام معاّ</option>
                                <option {{ $type == 1 ? 'selected' : '' }} value="1">دفع</option>
                                <option {{ $type == 2 ? 'selected' : '' }} value="2">استلام</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="row my-2">
                        <label for="year" class="col-md-3 col-form-label text-md-end">السنة</label>

                        <div class="col-md-9">
                            <select name="year" id="year" class="form-control form-select">
                                <option value="">الكل</option>
                                <option {{ $year == '2023' ? 'selected' : '' }} value="2023">2023</option>
                                <option {{ $year == '2024' ? 'selected' : '' }} value="2024">2024</option>
                                <option {{ $year == '2025' ? 'selected' : '' }} value="2025">2025</option>
                                <option {{ $year == '2026' ? 'selected' : '' }} value="2026">2026</option>
                                <option {{ $year == '2027' ? 'selected' : '' }} value="2027">2027</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row my-2">
                        <label for="month" class="col-md-3 col-form-label text-md-end">الشهر</label>

                        <div class="col-md-9">
                            <select name="month" id="month" class="form-control form-select">
                                <option value="">الكل</option>
                                <option {{ $month == '01' ? 'selected' : '' }} value="01">01</option>
                                <option {{ $month == '02' ? 'selected' : '' }} value="02">02</option>
                                <option {{ $month == '03' ? 'selected' : '' }} value="03">03</option>
                                <option {{ $month == '04' ? 'selected' : '' }} value="04">04</option>
                                <option {{ $month == '05' ? 'selected' : '' }} value="05">05</option>
                                <option {{ $month == '06' ? 'selected' : '' }} value="06">06</option>
                                <option {{ $month == '07' ? 'selected' : '' }} value="07">07</option>
                                <option {{ $month == '08' ? 'selected' : '' }} value="08">08</option>
                                <option {{ $month == '09' ? 'selected' : '' }} value="09">09</option>
                                <option {{ $month == '10' ? 'selected' : '' }} value="10">10</option>
                                <option {{ $month == '11' ? 'selected' : '' }} value="11">11</option>
                                <option {{ $month == '12' ? 'selected' : '' }} value="12">12</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary my-2">تحديث</button>
                </div>
                <div class="col-md-1">
                    <a target="_blank" href="{{ url($current_url . '?&print=1') }}" class="btn btn-primary my-2">طباعة</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>التاريخ</th>
                    @if(!$client_id)
                        <th class="w-20">العميل</th>
                    @endif
                    <th class="w-20">عنوان الفاتورة</th>
                    <th class="w-20">استلام</th>
                    <th class="w-20">دفع</th>
                    <th class="w-20">الرصيد</th>
                    <th class="w-20">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php $total_receive = 0 ?>
                <?php $total_pay = 0 ?>
                @foreach ($invoices as $invoice)
                    <?php $total_receive += $invoice->type == 2 ? $invoice->amount : 0  ?>
                    <?php $total_pay += $invoice->type == 1 ? $invoice->amount : 0  ?>
                    <tr>
                        <td class="">{{ $invoice->created_at }}</td>
                        @if(!$client_id)
                            <td class="">{{ $invoice->client->name }}</td>
                        @endif
                        <td class="">{{ $invoice->name }}</td>
                        <td class="">{{ $invoice->type == 2 ? $invoice->amount : 0 }}</td>
                        <td class="">{{ $invoice->type == 1 ? $invoice->amount : 0 }}</td>
                        <td class="">{{ $total_receive - $total_pay }}</td>
                        <td class="w-60">
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
                <tfoot>
                <tr>
                    <th class="text-center" colspan="3">اجمالي العمليات</th>
                    <th>{{ $total_receive }} ل . س </th>
                    <th>{{ $total_pay }} ل . س </th>
                </tr>
                <tr>
                    <th class="text-center" colspan="3">الرصيد الاجمالي - استلام</th>
                    <th colspan="2" class="text-center">{{ $total_receive - $total_pay }} ل . س </th>
                </tr>
                </tfoot>
            </table>
        </div>
        @if(count($invoices) == 0)
            <h1 class="text-center"> لا يوجد فواتير</h1>
        @endif
    </div>
@endsection
