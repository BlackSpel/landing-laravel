@extends('layouts.admin')

@section('header')
    @include('admin.header')
@endsection

@section('content')
    <div style="margin:0 50px 0 50px">
        @if($services)
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Текст</th>
                    <th>Иконка</th>
                    <th>Дата создания</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $k=>$service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{!! Html::link(route('serviceEdit',['service'=>$service->id]),$service->name,['alt'=>$service->name]) !!}</td>
                        <td>{{ $service->text }}</td>
                        <td>{{ $service->icon }}</td>
                        <td>{{ $service->created_at }}</td>
                        <td>
                            {!! Form::open(['url'=>route('serviceEdit',['service'=>$service->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                            {{ method_field('GET') }}
                            {!! Form::button('Редактировать',['class'=>'btn btn-primary','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            {!! Form::open(['url'=>route('serviceEdit',['service'=>$service->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                            {{ method_field('DELETE') }}
                            {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        {!! Form::open(['url'=>route('serviceAdd'),'class'=>'form-horizontal','method'=>'POST']) !!}
        {{ method_field('GET') }}
        {!! Form::button('Новый сервис',['class'=>'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>

@endsection