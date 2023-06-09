{{--▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄         ▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄            ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄  --}}
{{--▐░░░░░░░░░░░▐░░░░░░░░░░░▐░▌       ▐░▐░░░░░░░░░░░▐░░░░░░░░░░░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌--}}
{{-- ▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▐░▌       ▐░▌▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▌           ▀▀▀▀▀▀▀▀▀█░▐░█░█▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌--}}
{{--     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌       ▐░▌                    ▐░▐░▌▐░▌    ▐░▌         ▐░▌         ▐░▌--}}
{{--     ▐░▌    ▐░█▄▄▄▄▄▄▄█░▐░█▄▄▄▄▄▄▄█░▌    ▐░▌    ▐░█▄▄▄▄▄▄▄█░▌                    ▐░▐░▌ ▐░▌   ▐░▌         ▐░▌▄▄▄▄▄▄▄▄▄█░▌--}}
{{--     ▐░▌    ▐░░░░░░░░░░░▐░░░░░░░░░░░▌    ▐░▌    ▐░░░░░░░░░░░▌           ▄▄▄▄▄▄▄▄▄█░▐░▌  ▐░▌  ▐░▌▄▄▄▄▄▄▄▄▄█░▐░░░░░░░░░░░▌--}}
{{--     ▐░▌    ▐░█▀▀▀▀▀▀▀█░▐░█▀▀▀▀▀▀▀█░▌    ▐░▌    ▐░█▀▀▀▀█░█▀▀           ▐░░░░░░░░░░░▐░▌   ▐░▌ ▐░▐░░░░░░░░░░░▌▀▀▀▀▀▀▀▀▀█░▌--}}
{{--     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌     ▐░▌            ▐░█▀▀▀▀▀▀▀▀▀▐░▌    ▐░▌▐░▐░█▀▀▀▀▀▀▀▀▀          ▐░▌--}}
{{--     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌▄▄▄▄█░█▄▄▄▄▐░▌      ▐░▌           ▐░█▄▄▄▄▄▄▄▄▄▐░█▄▄▄▄▄█░█░▐░█▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄█░▌--}}
{{--     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▐░░░░░░░░░░░▐░▌       ▐░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌--}}
{{--      ▀      ▀         ▀ ▀         ▀ ▀▀▀▀▀▀▀▀▀▀▀ ▀         ▀            ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀ ▀▀▀▀▀▀▀▀▀▀▀ --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Global Form</title>
</head>
<body>
<div style="display: flex">
    @foreach([$form1,$form2] as $key=>$form)
        <div style="flex:1">
            <form action="/" class="form" method="post" name="fields" enctype='multipart/form-data'>
                <h2>Form {{$key+1}} <input type="submit" style="float:right"/></h2>
                @if(isset($success))
                    <div class="success">
                        {{ $success  }}
                    </div>
                @endif
                <div>
                    <input type="hidden" name="formId" value="{{$key+1}}"/>
                    @csrf
                    @foreach ($data as $field)
                        @if(isset($form) && in_array($field['id'],$form))
                            <div class="inputContainer">
                                <div class="formInput">
                                    <div class="inputLabel">
                                        {{ $field['id'].". "}} {{ $field['label']  }}
                                    </div>
                                    <div class="input">

                                        @if($field['slug'] === 'extended_select')
                                            <select multiple="{{isset($field['element']['params']['multiple'])}}"
                                                    name="fields[{{$field['id']}}]">
                                                @foreach($field['values'] as $opt)
                                                    <option value="{{$opt['value']}}">
                                                        {{ $opt['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="warning">Please note that the multiple select does not
                                                work properly in frontend only. The backend validates though.
                                                Suggest you use postman
                                            </div>
                                        @endif
                                        {{--                    Input Type rendering Start --}}
                                        @if($field['slug'] === 'input')
                                            <input
                                                name="fields[{{$field['id']}}]"
                                                style="width:100%"/>
                                        @endif
                                        @if($field['slug'] === 'images')
                                            <div>
                                                @foreach(range($field['element']['params']['min'], $field['element']['params']['max']) as $number)
                                                    <input type="file" name="fields[{{ $field['id'] }}][{{ $number }}]"
                                                           style="width: 100%;"/>
                                                    <div class="error">
                                                        @error("fields.".$field['id'].".".$number)
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($field['slug'] === 'select')
                                            <select
                                                    name="fields[{{$field['id']}}]">
                                                @foreach($field['values'] as $opt)
                                                    <option value="{{intval($opt['value'])}}">
                                                        {{ $opt['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @if($field['slug'] === 'checkbox')

                                            @if(isset($field['values']))
                                                @foreach($field['values'] as $key=>$val)
                                                    <div>
                                                        <input value="{{$val['value']}}" type="checkbox"
                                                               name="fields[{{$field['id']}}][{{$key}}]"/>
                                                        <span>{{$val['label']}}</span>
                                                        <div class="error">
                                                            @error("fields.".$field['id'].".".$key)
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        @if($field['slug'] === 'radio')
                                            @if(isset($field['values']))
                                                @foreach($field['values'] as $key=>$val)
                                                    <div>
                                                        <input type="radio" name="fields[{{$field['id']}}]"
                                                               value="{{intval($val['value'])}}"/>
                                                        <span>{{$val['label']}}</span>
                                                        <div class="error">
                                                            @error("fields.".$field['id'].".".$key)
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        @if($field['slug'] === 'textarea')
                                            <textarea name="fields[{{$field['id']}}]"></textarea>
                                        @endif
                                        {{--                    Input Type rendering End--}}
                                    </div>
                                </div>
                                {{--            Hints start --}}
                                <div style="color:blue">
                                    {{$field['element']['label']['help']['text']}}
                                </div>
                                {{--            Hints end --}}
                                {{--            Errors Start --}}
                                <div class="error">

                                    <div style="width:30%">

                                    </div>
                                    <div style="width:70%">
                                        @error("fields.".$field['id'])
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{--            Errors End --}}
                            </div>
                        @endif
                    @endforeach
                </div>

            </form>
        </div>
    @endforeach
</div>
</body>
<style>
    .form {
        border-radius: 10px;
        padding: 20px;
        margin-block: 20px;
        background-color: rgba(200, 200, 200, 0.2);
        margin-inline: auto;
        width: 80%
    }

    .inputContainer {
        background: white;
        padding-inline: 20px;
        margin-bottom: 4px;
        border-radius: 10px;
    }

    .formInput {
        margin: 2px;
        display: flex;
    }

    .inputLabel {
        width: 30%;
    }

    .input {
        width: 70%
    }

    input[type="text"], select, textarea {
        width: 100%
    }

    .error {
        display: flex;
        width: 100%;
        color: red
    }

    input[type="submit"] {
        background: green;
        border: none;
        color: white;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        filter: brightness(80%);
    }

    .success {
        padding: 10px;
        color: green;
    }

    .warning {
        background: orange;
    }
</style>
</html>
