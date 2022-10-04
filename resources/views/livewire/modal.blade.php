<div class="modal fade" id="modal-chang-password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('change-password.update') }}" method="post" id="form_change_password">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('msg.menu_change_password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="form-group">
                        <label class="form-label" for="current_password">{{ __('msg.current_password') }}</label>
                        <input id="current_password" type="password" name="current_password" class="form-control"
                            placeholder="{{ __('msg.placeholder') }}">
                    </div>
                    <!-- New password -->
                    <div class="form-group password-field">
                        <label class="form-label" for="new_password">{{ __('msg.new_password') }}</label>
                        <input id="new_password" type="password" name="new_password" class="form-control mb-2"
                            placeholder="{{ __('msg.placeholder') }}">
                    </div>
                    <div class="form-group">
                        <!-- Confirm new password -->
                        <label class="form-label" for="confirm_password">{{ __('msg.confirm_password') }}</label>
                        <input id="confirm_password" type="password" name="confirm_password" class="form-control mb-2"
                            placeholder="{{ __('msg.placeholder') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_save_chang_password"><i class="fas fa-save"></i>
                        {{ __('msg.btn_save') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i
                            class="fas fa-times-circle"></i> {{ __('msg.btn_close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
