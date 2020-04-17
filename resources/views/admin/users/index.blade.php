@extends('admin.layouts.app')

@section('content')
<div class="container">
    <users-page :users='@json($users)' />
</div>
@endsection
