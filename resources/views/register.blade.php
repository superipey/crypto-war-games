@extends('templates.header')

@section('content')
<!-- Main content -->
<section class="content">
    @include('templates.error')
    
    <div class="box box-primary">
        <form class="form-horizontal" method="POST" action="{{ url('register') }}">
        <div class="box-header with-border">
            <h3 class="box-title">Register your team mate before game play!</h3>
        </div>
        
        <div class="box-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label col-sm-2">Team Name</label>
                    <div class="col-sm-8">
                        <textarea rows="4" name="team" class="form-control" placeholder="Type your team name and team mate (NIS_FullName)">{{ old('team') }}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Username</label>
                    <div class="col-sm-8">
                        <input name="username" class="form-control" placeholder="Type your username" value="{{ old('username') }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control" placeholder="Type your password" value="{{ old('password') }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Retype Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="repassword" class="form-control" placeholder="Type your password" value="{{ old('repassword') }}" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2">Kelas</label>
                    <div class="col-sm-8">
                        <select name="kelas" class="form-control">
                            <option value="" {{ old('kelas') == "" ? 'selected' : '' }}>[ Choose Kelas ]</option>
                            <option value="XII-RPL1" {{ old('kelas') == "XII-RPL1" ? 'selected' : '' }}>XII-RPL1</option>
                            <option value="XII-RPL2" {{ old('kelas') == "XII-RPL2" ? 'selected' : '' }}>XII-RPL2</option>
                            <option value="XII-RPL3" {{ old('kelas') == "XII-RPL3" ? 'selected' : '' }}>XII-RPL3</option>
                        </select>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-8">
                        <button class="btn btn-success btn-block btn-lg">Submit</button>
                    </div>
                </div>
        </div>
    </form>
    </div>
</section>
<!-- /.content -->
@endsection