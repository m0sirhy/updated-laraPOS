@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.payments')
            <small> @lang('site.payments') {{ $payments->total() }} </small>
            اجمالي الدفعات : {{$total}}
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active">@lang('site.payments')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">

                <h3 class="box-title" style="margin-bottom: 15px">@lang('site.payments') <small>{{ $payments->total() }}</small></h3>

                <form action="{{ route('dashboard.payments.index') }}" method="get">

                    <div class="row">

                     
                    <div class="col-md-4">
                                <select name="search" class="form-control">
                                    <option value="">@lang('site.all_suppliers')</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ request()->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            @if (auth()->user()->hasPermission('create_payments'))
                            <a href="{{ route('dashboard.payments.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif
                        </div>

                    </div>
                </form><!-- end of form -->

            </div><!-- end of box header -->

            <div class="box-body">

                @if ($payments->count() > 0)

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.payee')/@lang('site.supplier_name')</th>
                            <th>@lang('site.amount')</th>
                            <th>@lang('site.description')/البيان</th>
                            <th>@lang('site.created_at')</th>


                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($payments as $index=>$payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->user->first_name}} {{ $payment->user->last_name }}</td>
                            <td>{{ $payment->supplier->name}}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{!! $payment->statment !!}</td>
                            <td>{{ $payment->created_at->toFormattedDateString() }}</td>



                            <td>
                                @if (auth()->user()->hasPermission('update_payments'))
                                <a href="{{ route('dashboard.payments.edit', $payment->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif
                                @if (auth()->user()->hasPermission('delete_payments'))
                                <form action="{{ route('dashboard.payments.destroy', $payment->id) }}" method="post" style="display: inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                </form><!-- end of form -->
                                @else
                                <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                </table><!-- end of table -->

                {{ $payments->appends(request()->query())->links() }}

                @else

                <h2>@lang('site.no_data_found')</h2>

                @endif

            </div><!-- end of box body -->


        </div><!-- end of box -->

    </section><!-- end of content -->

</div><!-- end of content wrapper -->


@endsection
