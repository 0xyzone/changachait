<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .area {
            background: rgb(23 23 23 / 1);
            background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);
            width: 100%;
            height: 100vh;


        }

        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            animation: animate 25s linear infinite;
            bottom: -150px;

        }

        .circles li:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }


        .circles li:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }



        @keyframes animate {

            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }

            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }

        }

    </style>
</head>
<body class="w-screen h-screen">
    <div class="area absolute top-0 -z-10">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <p class="animate-pulse px-4 py-2 rounded-lg bg-amber-400 font-bold text-2xl text-neutral-800 absolute top-4 left-4 max-w-64 text-center">We offer take aways and home delivery from our store as well!</p>
    <p class="animate-pulse px-4 py-2 rounded-lg bg-amber-400 font-bold text-2xl text-neutral-800 absolute top-4 right-4 max-w-64 text-center">We offer take aways and home delivery from our store as well!</p>
    <div class="text-white flex justify-center items-center pt-10 flex-col gap-2">
        <h1 class="text-6xl font-bold text-amber-400">Star Newari Khaja Ghar</h1>
        <p class="text-3xl">Chagal, Kathmandu, Nepal</p>
        <p class="text-amber-400"><span class="font-bold text-white">M: </span>9861748449 | <span class="font-bold text-white">E: </span> nabin1969@gmail.com</p>
        <p class="px-4 py-2 rounded-lg bg-amber-400 font-bold text-lg text-neutral-800">Order once placed is not refundable!</p>
    </div>
    <div class="text-6xl font-bold text-white flex justify-center pt-5">
        Menu
    </div>
    <div class="grid grid-cols-5 gap-4 max-w-7xl mx-auto pt-5">
        @foreach ($items as $item)
        <div class="bg-gray-300 p-4 rounded-lg">
            <img src="{{ $item->photo ? asset('storage/' . $item->photo) : asset('img/defaultImage.png') }}" alt="{{ $item->name . ' photo' }}" class="aspect-square rounded-lg shadow-xl {{ $item->photo ? 'object-cover' : 'object-scale-down bg-white' }}">
            <p class="text-xl font-bold pt-2">{{ $item->name }}</p>
            <p class="text-lg font-bold">रु {{ $item->price }}</p>
        </div>
        @endforeach
    </div>
</body>
</html>
