<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>survey_app</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="py-4">
    <div class="container">        
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1>{{ $questionnaire->title }}</h1>

                <form action="/surveys/{{ $questionnaire->id }}-{{ Str::slug($questionnaire->title) }}" method="post">
                    @csrf

                    @foreach($questionnaire->questions as $key => $question)
                        <div class="card mt-4">
                            <div class="card-header"><strong>{{ $key + 1 }}</strong> {{ $question->question }}</div>

                            <div class="card-body">

                                @error('responses.' . $key . '.answer_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if (!isset($question->answers[0]))
                                    <label for="temp">Answer :</label> <br>
                                    <textarea name="normal_answer[{{ $key }}][answer]" id="temp" cols="40" rows="3" placeholder="Enter your answer"></textarea>
                                    <small  class="form-text text-muted">Your Answer Please!</small>
                                    <input type="hidden" name="normal_answer[{{ $key }}][question_id]" value="{{ $question->id }}">
                                    
                                @else
                                    <ul class="list-group">
                                        @foreach($question->answers as $answer)
                                            <label for="answer{{ $answer->id }}">
                                                <li class="list-group-item">
                                                    <input type="radio" name="responses[{{ $key }}][answer_id]" id="answer{{ $answer->id }}"
                                                        {{ (old('responses.' . $key . '.answer_id') == $answer->id) ? 'checked' : '' }}
                                                        class="mr-2" value="{{ $answer->id }}">
                                                    {{ $answer->answer }}

                                                    <input type="hidden" name="responses[{{ $key }}][question_id]" value="{{ $question->id }}">
                                                </li>
                                            </label>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="card mt-4">
                        <div class="card-header">Your Information</div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input name="survey[name]" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Enter Name">
                                <small id="nameHelp" class="form-text text-muted">Hello! What's your name?</small>

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input name="survey[email]" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter Email">
                                <small id="emailHelp" class="form-text text-muted">Your Email Please!</small>

                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <button class="btn btn-dark" type="submit">Complete Survey</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
