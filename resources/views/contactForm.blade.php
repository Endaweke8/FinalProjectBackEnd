<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>
</head>
<body>
    <h1>Hello dears</h1>
    <div>
        <form action="{{route('send.email')}}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Enter your name please" value="{{old('name')}}" id="">
            <br>
            <input type="email" name="email" placeholder="Enter your email please" value="{{old('email')}}" id="">
            <br>
            <input type="text" name="subject" placeholder="Enter your subject please" value="{{old('subject')}}" id="">
            <br>
            <textarea name="message" id="" cols="4" rows="4">{{old('message')}}</textarea>
            <br>
            <br>
            <button >Send</button>
        </form>
    </div>
</body>
</html>