{{--@if(Session::has('success'))--}}
{{--  <div class="php-alert alert alert-success alert-dismissible fade show" role="alert">--}}
{{--    <strong>Success!</strong>{{Session::get('success')}}--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--      <span aria-hidden="true">&times;</span>--}}
{{--    </button>--}}
{{--  </div>--}}
{{--@endif--}}
{{--@if(Session::has('error'))--}}
{{--  <div class="php-alert alert alert-warning alert-dismissible fade show" role="alert">--}}
{{--    <strong>Error!</strong>{{Session::get('error')}}--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--      <span aria-hidden="true">&times;</span>--}}
{{--    </button>--}}
{{--  </div>--}}
{{--@endif--}}
{{--@foreach($errors->all() as $error)--}}
{{--  <div class="php-alert alert alert-warning alert-dismissible fade show" role="alert">--}}
{{--    <strong>Error!</strong>{{$error}}--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--      <span aria-hidden="true">&times;</span>--}}
{{--    </button>--}}
{{--  </div>--}}
{{--@endforeach--}}

<script>
  $(document).ready(function () {
    $('.php-alert').show().delay(1000).fadeOut(3000);
  });
</script>

<script>
  function successResponse(message) {
    setTimeout(function () {
      $('#msgSuccess').text(message);
      $('.successAlert').fadeIn(1000).delay(2000).fadeOut(1000);
    }, 500);
  }

  function errorResponse(message) {
    setTimeout(function () {
      $('#msgError').text(message);
      $('.warningAlert').fadeIn(1000).delay(2000).fadeOut(1000);
    }, 500);
  }

  function errorValidateResponse(errors) {
    $.each(errors, function (key, value) {
      $.each(this, function (childKey, childValue) {
        $(".error-list ul").append('<il class="text-danger">' + childValue + '</il>');
      });
    });
  }

  function responseMessage(res) {
    if (res.success === true) {
      $('#msgSuccess').text(res.message);
      $('.successAlert').show().delay(1000).fadeOut(3000);

    } else if (res.success === false) {
      $('#msgError').text(res.message);
      $('.warningAlert').show().delay(1000).fadeOut(3000);

    } else if (res.status == 422) {
      jQuery.each(res.responseJSON.errors, (index, error) => {
        $('#msgError').text(error);
        $('.warningAlert').show().delay(1000).fadeOut(3000);
      });
    }
  }
</script>
<!-- Javascript messages-->

<div class="alert alert-success alert-dismissible successAlert" role="alert" style="display: none">
  <strong>Success!</strong> <span id="msgSuccess"></span>
  {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
  {{--<span aria-hidden="true">&times;</span>--}}
  {{--</button>--}}
</div>
<div class="alert alert-danger alert-dismissible warningAlert" role="alert" style="display: none">
  <strong>Error!</strong> <span id="msgError"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
