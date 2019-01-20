@extends('layouts.admin')

@section('header')
    @include('admin.header')
@endsection

@section('content')
    <div style="margin:0 50px 0 50px">
        @if($pages)
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Псевдоним</th>
                        <th>Текст</th>
                        <th>Дата создания</th>
                        <th>Редактировать</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $k=>$page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{!! Html::link(route('pagesEdit',['page'=>$page->id]),$page->name,['alt'=>$page->name]) !!}</td>
                            <td>{{ $page->alias }}</td>
                            <td>{{ $page->text }}</td>
                            <td>{{ $page->created_at }}</td>
                            <td>
                                {!! Form::open(['url'=>route('pagesEdit',['pages'=>$page->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                                {{ method_field('GET') }}
                                {!! Form::button('Редактировать',['class'=>'btn btn-primary','type'=>'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(['url'=>route('pagesEdit',['pages'=>$page->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        {!! Form::open(['url'=>route('pagesAdd'),'class'=>'form-horizontal','method'=>'POST']) !!}
        {{ method_field('GET') }}
        {!! Form::button('Новая страница',['class'=>'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>

@endsection