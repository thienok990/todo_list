<!doctype html>
<html lang="en">

<head>
    <title>Todo list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<style>
    .gradient-custom {
        background: radial-gradient(50% 123.47% at 50% 50%, #00ff94 0%, #720059 100%),
            linear-gradient(121.28deg, #669600 0%, #ff0000 100%),
            linear-gradient(360deg, #0029ff 0%, #8fff00 100%),
            radial-gradient(100% 164.72% at 100% 100%, #6100ff 0%, #00ff57 100%),
            radial-gradient(100% 148.07% at 0% 0%, #fff500 0%, #51d500 100%);
        background-blend-mode: screen, color-dodge, overlay, difference, normal;
    }

    input:checked+label {
        text-decoration: line-through;
    }
</style>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card">
                        <div class="card-body p-5">
                            @if (session()->get('mode') == 'add')
                                <form class="d-flex justify-content-center align-items-center mb-4"
                                    action="{{ route('task.store') }}" method="POST">
                                @elseif(session()->get('mode') == 'edit' && isset($task))
                                    <form class="d-flex justify-content-center align-items-center mb-4"
                                        action="{{ route('task.update', $task->id) }}" method="POST">
                                        @method('PUT')
                            @endif
                            @csrf
                            <div class="form-outline flex-fill">
                                <input type="text" id="form2" class="form-control" name="name"
                                    @if (isset($task)) value="{{ $task->name }}" @endif />
                                @if (session()->get('mode') == 'add')
                                    <label class="form-label" for="form2">New task...</label>
                                @endif
                            </div>
                            @if (session()->get('mode') == 'edit')
                                <button type="submit" class="btn btn-info ms-2">Save
                                </button>
                            @else
                                <button type="submit" class="btn btn-info ms-2">Add
                                </button>
                            @endif
                            </form>
                            <ul class="nav nav-tabs mb-4 pb-2">
                                @php
                                    $currentTab = request('tab', 'All'); // mặc định 'All'
                                @endphp

                                <li class="nav-item">
                                    <a class="nav-link {{ $currentTab == 'All' ? 'active' : '' }}"
                                        href="{{ route('task.index', ['tab' => 'All']) }}">
                                        All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $currentTab == 'Pending' ? 'active' : '' }}"
                                        href="{{ route('task.index', ['tab' => 'Pending']) }}">
                                        Pending
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $currentTab == 'Completed' ? 'active' : '' }}"
                                        href="{{ route('task.index', ['tab' => 'Completed']) }}">
                                        Completed
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active">
                                    <ul class="list-group mb-0">
                                        @if (isset($tasks))
                                            @foreach ($tasks as $task)
                                                <li class="list-group-item d-flex align-items-center border-0 mb-2"
                                                    style="background-color: #f4f6f7;">
                                                    <form action="{{ route('task.updateStatus', $task->id) }}"
                                                        class="vw-100" method="post">
                                                        @csrf
                                                        <div class="justify-content-start col-6">
                                                            <input type="hidden" name="status" value="pending">
                                                            <input class="form-check-input me-2" type="checkbox"
                                                                {{ $task->status == 'completed' ? 'checked' : '' }}
                                                                onchange="this.form.submit()" value="checked"
                                                                name="status" id="taskName{{ $task->id }}" />
                                                            <label
                                                                for="taskName{{ $task->id }}">{{ $task->name }}</label>
                                                    </form>
                                </div>
                                <div class="justify-content-end d-flex col-6">
                                    <div class="div">
                                        <button class="btn btn-warning" type="button"
                                            onclick="window.location.href='{{ route('task.edit', $task->id) }}'">
                                            Edit</button>
                                    </div>
                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>

                                </li>
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
