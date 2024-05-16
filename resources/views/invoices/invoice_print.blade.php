<!doctype html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'فاتورة') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="">

            <div class="row navbar-brand my-5 flex align-items-center">
                <div class="col-sm-6">
                    <a class="" href="{{ url('/') }}">
                        <img class="" style="height: 4em" src="{{ url('images/logo.jpg') }}">
                    </a>
                </div>
                <div class="col-sm-6">
                    <h3 class="bold">منظم الفاتورة:  {{ \Illuminate\Support\Facades\Auth::user()->name }}</h3>
                </div>
            </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>التاريخ</th>
                    <th class="w-20">عنوان الفاتورة</th>
                    <th class="w-20">استلام</th>
                    <th class="w-20">دفع</th>
                    <th class="w-20">الرصيد</th>
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
                        <td class="">{{ $invoice->name }}</td>
                        <td class="">{{ $invoice->type == 2 ? $invoice->amount : 0 }}</td>
                        <td class="">{{ $invoice->type == 1 ? $invoice->amount : 0 }}</td>
                        <td class="">{{ $total_receive - $total_pay }}</td>
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
                    <th class="text-center" colspan="3">الرصيد الجمالي - استلام</th>
                    <th colspan="2" class="text-center">{{ $total_receive - $total_pay }} ل . س </th>
                </tr>
                </tfoot>
            </table>
        </div>
        @if(count($invoices) == 0)
            <h1 class="text-center"> لا يوجد فواتير</h1>
        @endif
    </div>
</body>
<script>
    window.print()
</script>
</html>
