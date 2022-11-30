@extends('layouts.app')
@section('content')
    @auth
        <p>Welcome <b>{{ Auth::user()->name }}</b></p>

        <h3>Add new task</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('/todos') }}" method="POST">
            @csrf
            <input type="text" class="form-control" name="task" placeholder="Add new task">
            <button class="btn btn-primary" type="submit">Store</button>
        </form>

        @if (session('status'))
        <br>
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <hr>

        <h3>Pending tasks</h3>

        <ul class="list-group">
            @foreach ($todos as $todo)
                @if (!$todo->complete)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $todo->task }}
                        <div>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ url('todos/' . $todo->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                            <form action="{{ url('todos/complete/' . $todo->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('PUT')
                                <input type="number" name="complete" value="1" hidden>
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-check"></i></button>
                            </form>

                            <div class="collapse mt-2" id="collapse-{{ $loop->index }}">
                                <div class="card card-body">
                                    <form action="{{ url('todos/' . $todo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="task" value="{{ $todo->task }}">
                                        <button class="btn btn-secondary" type="submit">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        <hr>
        <h3>Complate tasks</h3>
        <ul class="list-group">
            @foreach ($todos as $todo)
                @if ($todo->complete)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $todo->task }}
                        <form action="{{ url('todos/' . $todo->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </li>
                @endif
            @endforeach
        </ul>



    @endauth
    @guest
        <p>To unlock all features, please login first</p>
        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
    @endguest
@endsection
