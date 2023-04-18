<script>
    function loadModal(url) {
        $("#body-content").load(url);
    }
</script>


<div class="modal fade" id="modal" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-content">
        <img src="{{asset('img/loading.gif')}}" alt="Loading" title="Loading" height="50px">
      </div>
    </div>
  </div>
</div>
