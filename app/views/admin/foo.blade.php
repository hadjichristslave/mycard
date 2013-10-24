@extends('templates.interface')
@section('content')


@foreach($data as $dat)
	{{$dat->id . '<br>'}} 
@endforeach


@stop