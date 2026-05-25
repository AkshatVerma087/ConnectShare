<section>
    <header style="margin-bottom:1.25rem;">
        <h2 class="section-title" style="font-size:1.2rem; margin-bottom:6px;">{{ __('Profile Information') }}</h2>
        <p class="section-sub" style="margin-top:0;">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display:grid; gap:1rem;">
        @csrf
        @method('patch')

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $errors->first('email') }}</div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:0.75rem; padding:0.9rem 1rem; border-radius:10px; background:rgba(255,179,71,0.08); border:1px solid rgba(255,179,71,0.18);">
                    <p style="font-size:0.875rem; color:var(--cs-text); line-height:1.6;">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn-ghost" style="margin-left:8px; padding:6px 10px; font-size:0.8rem; text-decoration:none;">
                            {{ __('Resend verification email') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top:0.75rem; font-size:0.875rem; color:var(--cs-accent3);">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; padding-top:0.5rem;">
            <button type="submit" class="btn-primary" style="padding:10px 16px;">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
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
