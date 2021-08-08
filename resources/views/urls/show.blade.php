@extends('layout')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Site: {{ $url->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $url->id }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $url->name }}</td>
                    </tr>
                    <tr>
                        <td>Created at</td>
                        <td>{{ $url->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Updated at</td>
                        <td>{{ $url->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Checks</h2>
        <form method="post" action="{{ route('urls.checks.store', $url->id) }}">
            @csrf
           <input type="submit" class="btn btn-primary mb-3" value="Run check">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Response code</th>
                        <th>h1</th>
                        <th>keywords</th>
                        <th>description</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checks as $check)
                        <tr>
                            <td>{{ $check->id }}</td>
                            <td>{{ $check->status_code }}</td>
                            <td>{{ $check->h1 }}</td>
                            <td>{{ $check->keywords }}</td>
                            <td>{{ $check->description }}</td>
                            <td>{{ $check->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
