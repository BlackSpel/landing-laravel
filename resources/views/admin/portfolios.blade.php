@extends('layouts.admin')

@section('header')
    @include('admin.header')
@endsection

@section('content')
    <div style="margin:0 50px 0 50px">
        @if($portfolios)
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Фильтр</th>
                    <th>Дата создания</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($portfolios as $k=>$portfolio)
                    <tr>
                        <td>{{ $portfolio->id }}</td>
                        <td>{!! Html::link(route('portfolioEdit',['portfolio'=>$portfolio->id]),$portfolio->name,['alt'=>$portfolio->name]) !!}</td>
                        <td>{{ $portfolio->filter }}</td>
                        <td>{{ $portfolio->created_at }}</td>
                        <td>
                            {!! Form::open(['url'=>route('portfolioEdit',['portfolio'=>$portfolio->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                            {{ method_field('GET') }}
                            {!! Form::button('Редактировать',['class'=>'btn btn-primary','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            {!! Form::open(['url'=>route('portfolioEdit',['portfolio'=>$portfolio->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                            {{ method_field('DELETE') }}
                            {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        {!! Form::open(['url'=>route('portfolioAdd'),'class'=>'form-horizontal','method'=>'POST']) !!}
        {{ method_field('GET') }}
        {!! Form::button('Новое портфолио',['class'=>'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>

@endsection