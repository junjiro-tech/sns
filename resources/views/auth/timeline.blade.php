<!DOCTYPE HTML>
<html lang="ja" style="height:100%;">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SNSを作成</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    </head>
    
    <body style="height:100%; background-color: #FF82B2;">
        
        <div class="wrapper" style="margin: 0 auto; width: 50%; height: 100%; background-color: white;">
            <form action="/timeline" method="post">
            {{ csrf_field() }}
                <div style="background-color: #E8F4FA; text-align: center;">
                    <input type="text" name="tweet" style="margin: 1rem; padding: 0 1rem; width: 70%; border-radius: 6px; border: 1px solid #ccc; height: 2.3rem;" placeholder="今どうしてる？">
                    <button type="submit" style="background-color: #2695E0; color: white; border-radius: 10px; padding: 0.5rem;">ツイート</button>
                </div>
                @if($errors->first('tweet')) 
                    <p style="font-size: 0.7rem; color: red; padding: 0 2rem;">※{{$errors->first('tweet')}}</p>
                @endif
            </form>

            <div class="tweet-wrapper">
                @foreach($tweets as $tweet)
                <div style="padding:2rem; border-top: solid 1px #E6ECF0; border-bottom: solid 1px #E6ECF0;">
                    <div>{{ $tweet->tweet }}</div>
                </div>
                @endforeach
            </div>
            
            <div class="row justify-content-center">
                {{ $tweets->appends(['keywords' => Request::get('keyword')])->links() }}
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
    
</html>