@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <h1 class="mb-4">ユーザ一覧</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="bg-gray">表示名</th>
                                <th class="bg-gray">メールアドレス</th>
                                <th class="bg-gray">見積</th>
                                <th class="bg-gray"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="align-middle">
                                    <td>{{ $user['user']->name }}</td>
                                    <td>{{ $user['user']->email }}</td>
                                    <td class="text-end">{{$user['estimates_count']}}</td>
                                    <td class="text-center">
                                        <form action="{{ route('users.destroy', $user['user']->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary" onClick="return deleteAlert();">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
function deleteAlert(){
    if(window.confirm('削除してよろしいですか？')){

    }else{
        return false;
    }
}
</script>
@endsection
