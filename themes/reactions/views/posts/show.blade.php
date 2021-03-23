@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="p-5 card">
                    <h2>{{$post->title}}</h2>

                    <div>{{$post->body}}</div>

                    <reactions-component 
                        :reacted='@json($post->reacted())'
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
