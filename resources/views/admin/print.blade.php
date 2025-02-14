<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดของ {{ $record->name }}</title>
</head>

<body>
    <h1>รายละเอียดของ {{ $record->name }} {{ $record->surname }}</h1>
    <p>เลขบัตรประจำตัวประชาชน: {{ $record->id_card }}</p>
    <p>บ้านเลขที่: {{ $record->housenumber }}</p>
    <p>โรคประจำตัว: {{ $record->disease->name ?? 'ไม่มีโรค' }}</p>
</body>

</html>