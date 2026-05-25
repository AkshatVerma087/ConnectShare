<section>
    <header style="margin-bottom:1.25rem;">
        <h2 class="section-title" style="font-size:1.2rem; margin-bottom:6px;">{{ __('Update Password') }}</h2>
        <p class="section-sub" style="margin-top:0;">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display:grid; gap:1rem;">
        @csrf
        @method('put')

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; padding-top:0.5rem;">
            <button type="submit" class="btn-primary" style="padding:10px 16px;">{{ __('Save Password') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size:0.875rem; color:var(--cs-accent3);"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
