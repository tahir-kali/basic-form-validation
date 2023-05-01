<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Global Form</title>
</head>
<body>
<div style="display: flex">
    <div style="flex:1">
        <form action="/form1" class="form" method="post" name="fields" enctype='multipart/form-data'>
            <h1>Form 1</h1>
            @if(isset($success))
                <div>
                    {{ $success  }}
                </div>
            @endif
            <div>
                <input type="hidden" name="formName" value="form1" />
                @csrf
                @foreach ($data as $field)
                    @if(in_array($field['id'],$form1))
                        <div class="inputContainer">
                            <div class="formInput">
                                <div class="inputLabel">
                                    {{ $field['id'].". "}} {{ $field['label']  }}
                                </div>
                                <div class="input">
                                    {{--                    Input Type rendering Start --}}
                                    @if($field['slug'] === 'input')
                                        <input type="{{$field['data_type'] =='integer'?'number':'text'}}"
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
                                        <select name="fields[{{$field['id']}}]">
                                            @foreach($field['values'] as $opt)
                                                <option value="{{$opt['value']}}">
                                                    {{ $opt['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if($field['slug'] === 'checkbox')

                                        @if(isset($field['values']))
                                            @foreach($field['values'] as $key=>$val)
                                                <div>
                                                    <input type="checkbox" name="fields[{{$field['id']}}][{{$key}}]"/>
                                                    <span>{{print_r($val['label'])}}</span>
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
                                                           value="{{$val['value']}}"/>
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
                                    @if($field['slug'] === 'location')
                                        <div style="display:flex">
                                            <input name="fields[{{$field['id']}}][0]" style="flex:1"
                                                   placeholder="Logtitude">
                                            <input name="fields[{{$field['id']}}][1]" style="flex:1"
                                                   placeholder="Latitude">
                                        </div>
                                        <div>
                                            @error("fields.".$field['id']."0")
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @error("fields.".$field['id']."1")
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
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
            <div style="padding-bottom:20px">
                <input type="submit" style="float:right"/>
            </div>
        </form>
    </div>
    <div style="flex:1">
        <form action="/form2" class="form" method="post" name="fields" enctype='multipart/form-data'>
            <h1>Form 2</h1>
            @if(isset($success))
                <div>
                    {{ $success  }}
                </div>
            @endif
            <div>
                <input type="hidden" name="formName" value="form2" />
                @csrf
                @foreach ($data as $field)
                    @if(in_array($field['id'],$form2))
                        <div class="inputContainer">
                            <div class="formInput">
                                <div class="inputLabel">
                                    {{ $field['id'].". "}} {{ $field['label']  }}
                                </div>
                                <div class="input">
                                    {{--                    Input Type rendering Start --}}
                                    @if($field['slug'] === 'input')
                                        <input type="{{$field['data_type'] =='integer'?'number':'text'}}"
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
                                        <select name="fields[{{$field['id']}}]">
                                            @foreach($field['values'] as $opt)
                                                <option value="{{$opt['value']}}">
                                                    {{ $opt['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if($field['slug'] === 'checkbox')

                                        @if(isset($field['values']))
                                            @foreach($field['values'] as $key=>$val)
                                                <div>
                                                    <input type="checkbox" name="fields[{{$field['id']}}][{{$key}}]"/>
                                                    <span>{{print_r($val['label'])}}</span>
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
                                                           value="{{$val['value']}}"/>
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
                                    @if($field['slug'] === 'location')
                                        <div style="display:flex">
                                            <input name="fields[{{$field['id']}}][0]" style="flex:1"
                                                   placeholder="Logtitude">
                                            <input name="fields[{{$field['id']}}][1]" style="flex:1"
                                                   placeholder="Latitude">
                                        </div>
                                        <div>
                                            @error("fields.".$field['id']."0")
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            @error("fields.".$field['id']."1")
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
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
            <div style="padding-bottom:20px">
                <input type="submit" style="float:right"/>
            </div>
        </form>
    </div>
</div>
</body>
<style>
    .form {
        border-radius: 10px;
        padding: 20px;
        margin-block: 100px;
        background-color: rgba(200, 200, 200, 0.2);
        margin-inline: auto;
        width: min(600px, 99%)
    }

    .inputContainer {

        margin-block: 1px;
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
</style>
</html>
