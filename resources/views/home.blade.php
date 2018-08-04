@extends('templates.header')

@section('content')
<!-- Main content -->
<section class="content">
    @include('templates.error')

    <div class="col-lg-4">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Leaderboard</h3>
            </div>
            <div class="box-body">
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @foreach ($rank as $row)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['score'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
    @if (@$schedule_2)
        <div class="box box-danger">
            <div class="box-header with-border">
                @if (empty($user->cipher))
                <h3 class="box-title">Dibawah ini adalah contoh form yang harus dilengkapi nanti saat bermain dengan tim</h3>
                @else
                    <h3 class="box-title">Helo <strong>{{ @$user->username }}</strong> - {{ @$user->kelas }}</h3>
                @endif
            </div>

            <div class="box-body">
                <form class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-3">Plain Text</label>
                        <div class="col-sm-8">
                            <input name="plain_text" class="form-control" placeholder="Type your Plain text (Eg: AKU)" value="{{ old('plain_text', @$cipher->plain_text) }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Shift Number</label>
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
                        <label class="control-label col-sm-3">Cipher Text Level 1</label>
                        <div class="col-sm-8">
                            <input name="cipher_text_1" class="form-control" placeholder="Type your Cipher Text Level 1 (Eg: BLV)" value="{{ old('cipher_text_1', @$cipher->cipher_text_1) }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Cipher Text Level 2</label>
                        <div class="col-sm-8">
                            <input name="cipher_text_2" class="form-control" placeholder="Type your Cipher Text Level 2 (Eg: Nkt4WFo0MGQrTm89)" value="{{ old('cipher_text_2', @$cipher->cipher_text_2) }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Key</label>
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
                        <label class="control-label col-sm-3">Salt 8</label>
                        <div class="col-sm-8">
                            <input name="salt_8" class="form-control" placeholder="Salt 8" value="{{ old('salt_8', @$cipher->salt_8) }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Salt 16</label>
                        <div class="col-sm-8">
                            <input name="salt_16" class="form-control" placeholder="Salt 16" value="{{ old('salt_16', @$cipher->salt_16) }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Real Salt</label>
                        <div class="col-sm-8">
                            <select name="real_salt" class="form-control">
                                <option value="" {{ old('real_salt', @$cipher->real_salt) == '' ? 'selected' : '' }}>[ Choose Real Salt ]</option>
                                <option value="salt_8" {{ old('real_salt', @$cipher->real_salt) == 'salt_8' ? 'selected' : '' }}>Salt 8</option>
                                <option value="salt_16" {{ old('real_salt', @$cipher->real_salt) == 'salt_16' ? 'selected' : '' }}>Salt 16</option>
                            </select>
                        </div>
                    </div>

                    @if (empty($user->cipher))
                    <div class="form-group">
                        <label class="control-label col-sm-3"></label>
                        <div class="col-sm-8">
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endif
    
    @if (@$schedule_1 && !empty($single))
    <div class="col-lg-8 col-lg-offset-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Contoh Soal #{{ $single->id }}</h3>
            </div>

            <div class="box-body">
                <form class="form-horizontal" action="{{ url('/submit-enemies') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-sm-2">Cipher Text</label>
                        <div class="col-sm-8">
                            <input class="form-control" readonly value="{{ $single->cipher_text_2 }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Salt 8</label>
                        <div class="col-sm-8">
                            <input class="form-control" readonly value="{{ $single->salt_8 }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Salt 16</label>
                        <div class="col-sm-8">
                            <input class="form-control" readonly value="{{ $single->salt_16 }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Answer</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" value="{{ $single->id }}" />
                            <input name="answer" class="form-control" autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-8">
                            <button class="btn btn-danger btn-block">Answer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif (empty($single))
        <div class="col-lg-8 col-lg-offset-4">
            <div class="alert alert-danger">
                <p>Game Not Set yet.</p>
            </div>
        </div>
    @else
        <div class="col-lg-8 col-lg-offset-4">
            <div class="alert alert-danger">
                <p>Game started at {{ !empty($schedule_1) ? $schedule_1->start->format('d/m/Y H:i:s') : '' }}.</p>
            </div>
        </div>
    @endif
</section>
<!-- /.content -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <form class="form-horizontal" method="POST" action="{{ url('guess') }}">
          {{ csrf_field() }}
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Help</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
                <div class="col-lg-12">
            <input type="text" name="cipher_text_1" class="form-control" placeholder="Type Cipher Text Level 1 (Max 7 Characters)" maxlength="7" />
              </div>
              </div>
          
          <div class="form-group">
              <div class="col-lg-12">
            <select name="shift_number" class="form-control">
                <option value="" >[ Choose Shift Number ]</option>
                @for ($i=1; $i <= 25; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
              </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>
  </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(function() {
        $(".btnHelp").on('click', function() {
             $(".modal").modal('show');
        });
        setTimeout(function() {
          location.href = '{{ url('/') }}'
        }, 5000);
    });
</script>
@endpush