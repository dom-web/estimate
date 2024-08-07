@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="d-grid gap-2 col-md-4 mb-4">
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">新規作成</a>
            </div>
            <div class="d-grid gap-2 col-md-4 mb-4">
            <div class="btn-group">
                <button class="btn btn-lg btn-info" data-filter="all">All</button>
                <button class="btn btn-lg btn-info" data-filter=".issued">発行</button>
                <button class="btn btn-lg btn-info" data-filter=".ordered">受注</button>
                <button class="btn btn-lg btn-info" data-filter=".on_hold">保留</button>
            </div>
            </div>
            <div class="d-grid gap-2 col-md-2 mb-4">
                <div class="btn-group">
                    <button class="btn btn-lg btn-success" data-filter="all">All</button>
                    <button class="btn btn-lg btn-success" data-filter=".user{{ Auth::user()->id }}">自分</button>
                </div>
            </div>
            <div class="col-md-2 d-grid mb-4 justify-content-end">
                <div class="btn-group">
                    <button class="btn btn-lg btn-secondary" data-sort="default:asc">▲</button>
                    <button class="btn btn-lg btn-secondary" data-sort="default:desc">▼</button>
                </div>
            </div>
        </div>
        <div class="estimate-list row">
        @foreach ($estimates as $estimate)
            <div class="col-xl-6 mb-4 mix user{{ $estimate->user->id }}{{$estimate->issued?' issued':''}}{{$estimate->ordered?' ordered':''}}{{$estimate->on_hold?' on_hold':''}}">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('estimate.show', $estimate->id) }}" class="btn-estimate">
                        <div class="row align-items-center">
                            <div class="col-sm-6 text-truncate">
                                <small>{{ $estimate->updated_at->format('Y年m月d日') }}({{ $estimate->user->name }})</small>
                                <div class="fw-bold customer_name">{{ $estimate->customer->name }}</div>
                                <h4 class="fs-5 text-truncate">{{ $estimate->name }}</h4>
                            </div>
                            <div class="col-sm-2">
                                <i>{{ $estimate->max_version }}</i>
                                @if ($estimate->issued)
                                    <span class="text-warning">済</span>
                                @endif
                                @if ($estimate->ordered)
                                    <span class="text-success">受</span>
                                @endif
                                @if ($estimate->on_hold)
                                    <span class="text-danger">保</span>
                                @endif
                            </div>
                            <div class="col-sm-4 text-end fs-4 fs-md-3 fw-bold">￥{{ number_format($estimate->total_cost) }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/mixitup.min.js')}}"></script>
<script>
    var containerEl = document.querySelector('.estimate-list');

    var mixer = mixitup(containerEl);
</script>
@endsection
