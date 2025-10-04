@extends('frontend.user.profile')

@section('user_contents')

    @include('frontend.user.components.breadcrumb')

    @include('frontend.user.components.user-info')

    @include('frontend.user.components.quick-links')
@endsection
