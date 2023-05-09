<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear {{ $task->assignee->name }},</p>
    <p>This is a reminder that the following task is due today:</p>
    <ul>
        <li>Title: {{ $task->title }}</li>
        <li>Description: {{ $task->description }}</li>
        <li>Due Date: {{ $task->due_date }}</li>
    </ul>
    <p>Thank you for using our task management system.</p>
</body>
</html>
