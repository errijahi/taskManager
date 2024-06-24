<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TaskManager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Save Project</h2>
    <form method="POST" action="{{ route('project.store', $projectId) }}" class="mb-4">
        @csrf
        <input type="text" name="name" placeholder="Name" required class="border border-gray-300 rounded px-2 py-1">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Project</button>
    </form>

    <h2 class="text-2xl font-bold mb-4">Select Project</h2>
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
        <select name="project_id" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </form>

    <h2 class="text-2xl font-bold mb-4">Save Task</h2>
    <form method="POST" action="{{ route('task.store', $projectId) }}" class="mb-4">
        @csrf
        <input type="text" name="name" placeholder="Name" required class="border border-gray-300 rounded px-2 py-1">
        <input type="number" name="priority" placeholder="Priority" required class="border border-gray-300 rounded px-2 py-1">
        <input type="date" name="timestamp" placeholder="Timestamp" required class="border border-gray-300 rounded px-2 py-1">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Task</button>
    </form>

    <h2 class="text-2xl font-bold mb-4">Show Task</h2>
    <p class="mb-4">Elements in table are draggable</p>
    <table class="w-full mb-4">
        <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Name</th>
            <th class="border border-gray-300 px-4 py-2">Priority</th>
            <th class="border border-gray-300 px-4 py-2">Timestamp</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody id="sortable">
        @foreach($tasks as $task)
            <tr class="ui-state-default" data-id="{{ $task->id }}">
                <td class="border border-gray-300 px-4 py-2">{{ $task->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $task->priority }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $task->created_at }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <form method="POST" action="{{ route('task.destroy', ['projectId' => $projectId, 'taskId' => $task->id]) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">Delete</button>
                    </form>
                    <form method="GET" action="{{ route('task.edit', ['projectId' => $projectId, 'taskId' => $task->id]) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Edit</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>

<script>
    $(function() {
        $("#sortable").sortable({
            update: function(event, ui) {
                var priority = [];
                $('#sortable tr').each(function(index) {
                    var id = $(this).data('id');
                    priority.push({ id: id, priority: index + 1 });
                });

                $.ajax({
                    url: '{{ route("tasks.reorder") }}',
                    method: 'POST',
                    data: {
                        priority: priority,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload(); // Refresh the page on successful update
                    },
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>
</body>
</html>
