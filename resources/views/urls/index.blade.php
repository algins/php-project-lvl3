@extends('layout')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Sites</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Last check</th>
                        <th>Response code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($urls as $url)
                        <tr>
                            <td>{{ $url->id }}</td>
                            <td>
                                <a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a>
                            </td>
                            <td>{{ $url->updated_at }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
