@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">

                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">ユーザ編集</h2>
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <table class="table">
                                <tbody>
                                    <tr class="align-middle">
                                        <th>メールアドレス</th>
                                        <td>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" required>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th>パスワード</th>
                                        <td>
                                            <input type="text" class="form-control" id="password" name="password"
                                                value="{{ __($user->password) }}" required>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th>表示名</th>
                                        <td>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" required>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="text-center"><button type="submit" class="btn btn-primary btn-lg">編集</button></div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
