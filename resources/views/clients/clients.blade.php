@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center h1">العملاء</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">اضافة عميل جديد</a>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="w-25">الاسم</th>
                        <th class="w-25">رقم الهاتف</th>
                        <th class="w-50">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td class="w-25">{{ $client->name }}</td>
                            <td class="w-25">{{ $client->phonenumber }}</td>
                            <td class="w-50">
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success btn-sm mt-3">تعديل</a>
                                <a href="{{ url('invoices?client_id=' . $client->id) }}" class="btn btn-primary btn-sm mt-3">الفواتير</a>

                                <form onsubmit="return confirm('هل أنت متأكد من أنك تريد الحذف؟');" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-3" >حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @if(count($clients) == 0)
            <h1 class="text-center"> لا يوجد عملاء</h1>
        @endif
    </div>
@endsection
