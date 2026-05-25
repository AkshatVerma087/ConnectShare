<section style="display:grid; gap:1rem;">
    <header>
        <h2 class="section-title" style="font-size:1.2rem; margin-bottom:6px; color:var(--cs-accent2);">{{ __('Delete Account') }}</h2>
        <p class="section-sub" style="margin-top:0;">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Download anything you want to keep before continuing.') }}</p>
    </header>

    <button
        type="button"
        class="btn-primary"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="background:rgba(255,107,107,0.12); border:1px solid rgba(255,107,107,0.25); color:var(--cs-accent2); width:max-content;"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="background:var(--cs-card); color:var(--cs-text);">
            @csrf
            @method('delete')

            <h2 style="font-family:var(--pf); font-size:1.25rem; font-weight:500; color:var(--cs-text);">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="margin-top:0.5rem; font-size:0.875rem; line-height:1.7; color:var(--cs-muted);">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="form-group" style="margin-top:1rem;">
                <label for="password" class="form-label">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="{{ __('Password') }}"
                />

                @if($errors->userDeletion->get('password'))
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->userDeletion->first('password') }}</div>
                @endif
            </div>

            <div style="margin-top:1.25rem; display:flex; justify-content:flex-end; gap:10px; flex-wrap:wrap;">
                <button type="button" class="btn-ghost" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="btn-primary" style="background:rgba(255,107,107,0.14); border:1px solid rgba(255,107,107,0.22); color:var(--cs-accent2);">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
