@extends('layout')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">{{ __('views.urls.show.site', ['urlName' => $url->name]) }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td>{{ __('views.urls.show.id') }}</td>
                        <td>{{ $url->id }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('views.urls.show.name') }}</td>
                        <td>{{ $url->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('views.urls.show.created_at') }}</td>
                        <td>{{ $url->created_at }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('views.urls.show.updated_at') }}</td>
                        <td>{{ $url->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="mt-5 mb-3">{{ __('views.urls.show.checks') }}</h2>
        <form method="post" action="{{ route('urls.checks.store', $url->id) }}">
            @csrf
           <input type="submit" class="btn btn-primary mb-3" value="{{ __('views.urls.show.run_check') }}">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>{{ __('views.urls.show.id') }}</th>
                        <th>{{ __('views.urls.show.response_code') }}</th>
                        <th>{{ __('views.urls.show.h1') }}</th>
                        <th>{{ __('views.urls.show.title') }}</th>
                        <th>{{ __('views.urls.show.description') }}</th>
                        <th>{{ __('views.urls.show.created_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checks as $check)
                        <tr>
                            <td>{{ $check->id }}</td>
                            <td>{{ $check->status_code }}</td>
                            <td>{{ $check->h1 }}</td>
                            <td>{{ $check->title }}</td>
                            <td>{{ $check->description }}</td>
                            <td>{{ $check->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
