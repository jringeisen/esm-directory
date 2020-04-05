@extends('layouts.app')

@section('content')
<div class="container">
    <listings-page :listings="{{ $listings }}"></listings-page>
</div>
@endsection
