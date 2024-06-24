<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TaskManager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Edit Task</h2>
    <form method="POST" action="{{ route('task.update', ['projectId' => $projectId, 'taskId' => $task->id]) }}" class="mb-4">
        @csrf
        <input type="text" name="name" placeholder="Name" value="{{ $task->name }}" class="border border-gray-300 rounded px-2 py-1 mb-2 block w-full" required/>
        <input type="number" name="priority" placeholder="Priority" value="{{ $task->priority }}" class="border border-gray-300 rounded px-2 py-1 mb-2 block w-full" required/>
        <input type="date" name="timestamp" placeholder="Timestamp" value="{{ $task->created_at->format('Y-m-d') }}" class="border border-gray-300 rounded px-2 py-1 mb-2 block w-full" required/>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Save Changes</button>
    </form>
</div>

</body>
</html>
