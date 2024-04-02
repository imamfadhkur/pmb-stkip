<div class="container my-4">
  <div class="row">
    <div class="col-8">
      <h4>Silahkan rubah password anda terlebih dahulu</h4>
<form action="{{ url('change-password') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
    </div>
    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="checkbox" onclick="showPassword()" class="mb-4"> Show Password <br>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    </div>
  </div>
</div>