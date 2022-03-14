@extends('layout')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">{{ __('views.urls.index.title') }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>{{ __('views.urls.index.id') }}</th>
                        <th>{{ __('views.urls.index.name') }}</th>
                        <th>{{ __('views.urls.index.last_check') }}</th>
                        <th>{{ __('views.urls.index.response_code') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($urls as $url)
                        <tr>
                            <td>{{ $url->id }}</td>
                            <td>
                                <a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a>
                            </td>
                            <td>{{ $url->last_check }}</td>
                            <td>{{ $url->status_code }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $urls->links() }}
    </div>
@endsection
