<div class="modal fade bd-example-modal-lg show" id="modalModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" style="padding-right: 17px; display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header btn-primary">
                <div class="col-md-9">
                    <h5 class="modal-title" id="modalLabel">@yield('modalTitle')</h5>
                </div>
                <div class="col-md-3 text-right">
                    @yield('modalBtnsHeader')
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"> <span class="fas fa-times"> </span></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    @yield('modalBody')
                </div>
                <div class="modal-footer">
                    @yield('modalFooter')
                </div>
            </div>
        </div>
    </div>
</div>
@yield('modalScripts')