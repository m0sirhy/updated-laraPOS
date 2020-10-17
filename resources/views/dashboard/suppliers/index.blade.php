@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.suppliers')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.suppliers')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-bpurchace">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.suppliers') <small>{{ $suppliers->total() }}</small></h3>

                    <form action="{{ route('dashboard.suppliers.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if (auth()->user()->hasPermission('create_suppliers'))
                                    <a href="{{ route('dashboard.suppliers.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($suppliers->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>اجمالي المشتريات</th>
                                <th>اجمالي الدفعات</th>
                                <th>اجمالي المطلوب</th>


                                <th>@lang('site.add_purchace')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($suppliers as $index=>$supplier)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ is_array($supplier->phone) ? implode($supplier->phone, '-') : $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>{{ $supplier->purchaces->sum('total_price')}}  </td>
                                    <td>{{ $supplier->payments->sum('amount') }}</td>
                                    <td>{{ $supplier->purchaces->sum('total_price')  - $supplier->payments->sum('amount')}}</td>



                                    <td>
                                        @if (auth()->user()->hasPermission('create_purchaces'))
                                            <a href="{{ route('dashboard.suppliers.purchaces.create', $supplier->id) }}" class="btn btn-primary btn-sm">@lang('site.add_purchace')</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-sm disabled">@lang('site.add_purchace')</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_suppliers'))
                                            <a href="{{ route('dashboard.suppliers.edit', $supplier->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_suppliers'))
                                            <form action="{{ route('dashboard.suppliers.destroy', $supplier->id) }}" method="post" style="display: inline-block">
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
                        
                        {{ $suppliers->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>@lang('site.no_data_found')</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
