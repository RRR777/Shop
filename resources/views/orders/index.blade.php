@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            <i class="fa fa-shopping-cart"></i>
            Orders
            <small>
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                All orders
            </small>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('orders.table')
            </div>
        </div>
        <div class="text-center"></div>
    </div>
@endsection
