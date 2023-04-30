<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    
    <p>A new task has been assigned to you:</p>
    
    <p>Title: {{ $task->title }}</p>
    <p>Description: {{ $task->description }}</p>
    <p>Due Date: {{ $task->due_date }}</p>
    
    <p>Thank you!</p>
</body>
</html>
