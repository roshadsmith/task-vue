@extends('layout')

@section('content')
    <task-list></task-list>
    <div class="row justify-content-center">        
        @if ($errors->any())
            <div class="col-5 alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection