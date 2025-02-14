@extends('layout')

@section('content')
<style>
.image {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    margin-bottom: 10px;
}

.logo1 {
    width: 200px;
}

.title {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #020364;
}

.box {
    width: 600px;
    padding: 45px;
    border: none;
    border-radius: 10px;
    background-color: #020364;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    color: #fff;
    font-size: 15px;

}

.box button {
    display: block;
    margin: 10px auto 0;
    padding: 10px 20px;
    background-color: #7DA7D8;
    color: #020364;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
}

.box button:hover {
    background-color: #5C93D3;
}

.line-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.line {
    flex: 1;
    height: 2px;
    background: white;
    margin-top: 20px;

}

.text {
    margin: 0 10px;
    font-size: 18px;
    color: #fff;
    margin-top: 20px;

}

.button-container {
    text-align: center
}

.button {
    display: inline-block;
    padding: 10px 50px;
    background-color: #020364;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
    margin-top: 10px;
    margin-bottom: 60px;
    text-decoration: none;
}

.button:hover {
    background-color: #000145;
}
</style>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<div class="image">
    <img class="logo1" src="/logo.png" alt="Logo">
</div>

<div class="title">
    <p><strong>ลืมรหัสผ่าน</storng>
    </p>
</div>

<div class="box">
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email" style="margin-bottom: 5px; text-align: left;">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="อีเมล" required>
        <br>
        <button type="submit">ส่งลิงค์รีเซ็ตรหัสผ่าน</button>
    </form>
</div>

@endsection