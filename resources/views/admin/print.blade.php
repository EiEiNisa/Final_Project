<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดของ {{ $recorddata->name }}</title>
</head>

<body>
    <h1>รายละเอียดของ {{ $recorddata->name }} {{ $recorddata->surname }}</h1>
    <p>เลขบัตรประจำตัวประชาชน: {{ $recorddata->id_card }}</p>
    <p>บ้านเลขที่: {{ $recorddata->housenumber }}</p>
    <p>โรคประจำตัว: {{ $recorddata->disease->name ?? 'ไม่มีโรค' }}</p>
</body>

</html>