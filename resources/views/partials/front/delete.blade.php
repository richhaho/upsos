<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="deleteModalLabel">@lang('Delete Schedule')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <h5>@lang('Are you sure you ?')</h5>
          <p class="mt-3">@lang('You would not able to revert once you delete it?')</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cmn--btn" data-bs-dismiss="modal">@lang('Close')</button>
          <a id="modaldelete" class="cmn--btn" href="">@lang('Submit')</a>
         
        </div>

        
      </div>
    </div>
  </div>