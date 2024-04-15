<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Получение файла</title>
</head>
<body>
<p>Вы получили файл: {{ $file->name }}</p>
<p>Вы можете скачать его по ссылке: {{ route('download', ['file_id' => $file->id]) }}</p>
</body>
</html>
