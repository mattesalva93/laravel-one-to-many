@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col text-center">
            <h1>Nuovo post</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ route('admin.posts.store') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" class="@error('title') is-invalid @enderror form-control" id="name" name="title"
                        value="{{ old('title') }}" placeholder="Titolone bello">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                
                <div class="form-group">
                    <label for="content">Contenuto</label>
                    <textarea class="@error('content') is-invalid @enderror form-control" id="content" name="content"
                        placeholder="Scrivi qui">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id">Categoria</label>
                    <select class="form-control form-control-md" id="category_id" name="category_id">
                        <option value="">
                            Seleziona una categoria del post
                        </option>
                        @foreach($categories as $elemento)
                        <option value="{{$elemento->id}}">
                            {{ $elemento->name }}
                        </option> 
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Crea</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection