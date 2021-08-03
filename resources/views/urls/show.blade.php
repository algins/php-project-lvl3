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
    </div>
@endsection
