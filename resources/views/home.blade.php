@extends('templates.header')

@section('content')
<!-- Main content -->
<section class="content">
    @include('templates.error')
    
    <div class="box box-primary">
        <div class="box-header with-border">
            @if (empty($user->cipher))
            <h3 class="box-title">Complete your items before game play!</h3>
            @else
            <h3 class="box-title">Helo <strong>{{ @$user->username }}</strong> - <label class="label label-success">{{ count(@$answered) }} Other Team's Cipher Answered</label> - <label class="label label-warning">{{ @$guessed }} Team(s) Guessed your Cipher</label></h3>
            @endif
        </div>
        
        <div class="box-body">
            <form class="form-horizontal" action="{{ url('/submit-cipher') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-sm-2">Team Name</label>
                    <div class="col-sm-8">
                        <textarea rows="4" name="team" class="form-control" placeholder="Type your team name and team mate (NIS_FullName)" disabled>{{ $user->team }}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Username</label>
                    <div class="col-sm-8">
                        <input name="username" class="form-control" placeholder="Type your username" value="{{ $user->username }}" disabled />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Kelas</label>
                    <div class="col-sm-8">
                        <input name="kelas" class="form-control" placeholder="Type your username" value="{{ $user->kelas }}" disabled />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Plain Text</label>
                    <div class="col-sm-8">
                        <input name="plain_text" class="form-control" placeholder="Type your Plain text" value="{{ old('plain_text', @$cipher->plain_text) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Shift Number</label>
                    <div class="col-sm-8">
                        <select name="shift_number" class="form-control">
                            <option value="" {{ old('shift_number', @$cipher->shift_number) == '' ? 'selected' : '' }}>[ Choose Shift Number ]</option>
                            @for ($i=1; $i <= 25; $i++)
                            <option value="{{ $i }}" {{ old('shift_number', @$cipher->shift_number) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Cipher Text Level 1</label>
                    <div class="col-sm-8">
                        <input name="cipher_text_1" class="form-control" placeholder="Type your Cipher Text Level 1" value="{{ old('cipher_text_1', @$cipher->cipher_text_1) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Cipher Text Level 2</label>
                    <div class="col-sm-8">
                        <input name="cipher_text_2" class="form-control" placeholder="Type your Cipher Text Level 2" value="{{ old('cipher_text_2', @$cipher->cipher_text_2) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Key</label>
                    <div class="col-sm-8">
                        <select name="key" class="form-control">
                            <option value="" {{ old('key', @$cipher->key) == '' ? 'selected' : '' }}>[ Choose Key ]</option>
                            @foreach ($key as $val)
                            <option value="{{ $val }}" {{ old('key', @$cipher->key) == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 8</label>
                    <div class="col-sm-8">
                        <input name="salt_8" class="form-control" placeholder="Salt 8" value="{{ old('salt_8', @$cipher->salt_8) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 16</label>
                    <div class="col-sm-8">
                        <input name="salt_16" class="form-control" placeholder="Salt 16" value="{{ old('salt_16', @$cipher->salt_16) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 24</label>
                    <div class="col-sm-8">
                        <input name="salt_24" class="form-control" placeholder="Salt 24" value="{{ old('salt_24', @$cipher->salt_24) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 32</label>
                    <div class="col-sm-8">
                        <input name="salt_32" class="form-control" placeholder="Salt 32" value="{{ old('salt_32', @$cipher->salt_32) }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Salt Any</label>
                    <div class="col-sm-8">
                        <input name="salt_any" class="form-control" placeholder="Salt any" value="{{ old('salt_any', @$cipher->salt_any) }}" />
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2">Real Salt</label>
                    <div class="col-sm-8">
                        <select name="real_salt" class="form-control">
                            <option value="" {{ old('real_salt', @$cipher->real_salt) == '' ? 'selected' : '' }}>[ Choose Real Salt ]</option>
                            <option value="salt_8" {{ old('real_salt', @$cipher->real_salt) == 'salt_8' ? 'selected' : '' }}>Salt 8</option>
                            <option value="salt_16" {{ old('real_salt', @$cipher->real_salt) == 'salt_16' ? 'selected' : '' }}>Salt 16</option>
                            <option value="salt_24" {{ old('real_salt', @$cipher->real_salt) == 'salt_24' ? 'selected' : '' }}>Salt 24</option>
                            <option value="salt_32" {{ old('real_salt', @$cipher->real_salt) == 'salt_32' ? 'selected' : '' }}>Salt 32</option>
                            <option value="salt_any" {{ old('real_salt', @$cipher->real_salt) == 'salt_any' ? 'selected' : '' }}>Salt Any</option>
                        </select>
                    </div>
                </div>
            
                @if (empty($user->cipher))
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-success btn-block btn-lg">Submit</button>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
    
    @if (@$start)    
    @foreach($enemies as $row)
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Team <strong>{{ @$row->username }}</strong> <small>({{ @$row->kelas }})</small></h3>
        </div>
        
        <div class="box-body">
            <form class="form-horizontal" action="{{ url('/submit-enemies') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-sm-2">Team Name</label>
                    <div class="col-sm-8">
                        <textarea rows="4" name="team" class="form-control" placeholder="Type your team name and team mate (NIS_FullName)" disabled>{{ $row->team }}</textarea>
                    </div>
                </div>
                
                @if(!in_array($row->id, $answered))
                <div class="form-group">
                    <label class="control-label col-sm-2">Cipher Text</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->cipher_text_2 }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 8</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->salt_8 }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 16</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->salt_16 }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 24</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->salt_24 }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Salt 32</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->salt_32 }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Salt Any</label>
                    <div class="col-sm-8">
                        <input class="form-control" disabled value="{{ $row->cipher->salt_any }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Answer</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id" value="{{ $row->id }}" />
                        <input name="answer" class="form-control" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-danger btn-block">Answer</button>
                    </div>
                </div>
                @else
                <div class="alert alert-success col-sm-offset-2 col-sm-8">Answered</div>
                @endif
            </form>
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-danger">
        <p>Game started at {{ $start_date->format('d/m/Y H:i:s') }}.</p>    
    </div>
    @endif
</section>
<!-- /.content -->
@endsection