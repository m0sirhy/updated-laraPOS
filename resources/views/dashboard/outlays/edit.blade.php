@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.outlays')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.outlays.index') }}"> @lang('site.outlays')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

<<<<<<< HEAD
                    <form action="{{ route('dashboard.outlays.update', $outlay->id) }}" method="post" enctype="multipart/form-data">
=======
                    <form action="{{ route('dashboard.outlays.update', $product->id) }}" method="post" enctype="multipart/form-data">
>>>>>>> 61f508353c5a594b3dfc6b0eb1e0fa9fee19f33c

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>@lang('site.amount')</label>
                            <input type="number" name="amount" step="0.01" class="form-control" value="{{  $outlay->amount }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.payee')</label>
                            <input type="text" name="payee"  class="form-control" value="{{ $outlay->payee}}">
                        </div>

                        <div class="form-group">
                                <label>@lang('site.description')/البيان</label>
                                <textarea name="statment" class="form-control ckeditor">{{ $outlay->statment}}</textarea>
                            </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
