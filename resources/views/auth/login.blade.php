<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Generator PB</title>

    <style>
        :root {
            --teal: #286963;
            --teal-dark: #204F4B;
            --eucalyptus: #78A69A;
            --pale-green: #E3EFEB;
            --beige: #F5F1E8;
            --white: #FFFFFF;
            --text: #303C3A;
            --muted: #6B7773;
            --border: #DCE4E0;
            --danger: #B54747;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px;
            background:
                radial-gradient(
                    circle at top right,
                    #DCEAE3 0,
                    transparent 30%
                ),
                var(--beige);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1040px;
            min-height: 610px;
            overflow: hidden;
            background: var(--white);
            border: 1px solid rgba(48, 60, 58, 0.06);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(36, 74, 65, 0.10);
        }

        /* Panel identitas */

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px;
            overflow: hidden;
            color: var(--white);
            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(120, 166, 154, 0.65),
                    transparent 35%
                ),
                linear-gradient(
                    150deg,
                    var(--teal),
                    var(--teal-dark)
                );
        }

        .brand-panel::before {
            position: absolute;
            right: -100px;
            bottom: 100px;
            width: 300px;
            height: 300px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            content: "";
        }

        .brand-panel::after {
            position: absolute;
            right: -40px;
            bottom: 30px;
            width: 210px;
            height: 210px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            content: "";
        }

        .brand-content,
        .brand-footer {
            position: relative;
            z-index: 1;
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            display: grid;
            width: 46px;
            height: 46px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 22px;
            font-weight: bold;
        }

        .brand-name {
            margin: 0;
            font-size: 19px;
            font-weight: 700;
        }

        .brand-caption {
            margin: 5px 0 0;
            color: #D7E9E3;
            font-size: 12px;
        }

        .brand-heading {
            max-width: 360px;
            margin-top: 76px;
        }

        .eyebrow {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            color: #E2F0EB;
            background: rgba(255, 255, 255, 0.08);
            font-size: 11px;
            letter-spacing: 1px;
        }

        .brand-heading h1 {
            margin: 22px 0 15px;
            font-size: clamp(30px, 3vw, 42px);
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .brand-heading p {
            max-width: 340px;
            margin: 0;
            color: #D8E8E3;
            font-size: 15px;
            line-height: 1.8;
        }

        .brand-footer {
            margin-top: 32px;
            color: #D3E5DF;
            font-size: 11px;
        }

        /* Panel login */

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px;
        }

        .access-label {
            align-self: flex-start;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 32px;
            padding: 9px 12px;
            border-radius: 20px;
            color: var(--teal-dark);
            background: var(--pale-green);
            font-size: 11px;
        }

        .access-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--eucalyptus);
        }

        .form-panel h2 {
            margin: 0 0 10px;
            color: var(--teal-dark);
            font-size: 30px;
            letter-spacing: -0.6px;
        }

        .form-description {
            margin: 0 0 25px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .info-banner {
            display: flex;
            gap: 11px;
            margin-bottom: 27px;
            padding: 14px;
            border: 1px solid #D8E8E2;
            border-radius: 10px;
            background: #F2F8F5;
            color: #426A60;
            font-size: 12px;
            line-height: 1.6;
        }

        .info-icon {
            flex-shrink: 0;
            font-weight: bold;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            color: #7B9690;
            font-size: 17px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .field input {
            width: 100%;
            min-height: 49px;
            padding: 13px 14px 13px 43px;
            border: 1px solid var(--border);
            border-radius: 9px;
            outline: none;
            background: #FCFDFC;
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field input::placeholder {
            color: #9AA7A2;
        }

        .field input:focus {
            border-color: var(--eucalyptus);
            box-shadow: 0 0 0 3px rgba(120, 166, 154, 0.16);
        }

        .error-message {
            margin: 0 0 18px;
            padding: 12px 14px;
            border: 1px solid #F0D3D3;
            border-radius: 9px;
            background: #FFF5F5;
            color: var(--danger);
            font-size: 12px;
            line-height: 1.6;
        }

        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 49px;
            margin-top: 5px;
            border: none;
            border-radius: 9px;
            background: var(--teal);
            color: var(--white);
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .login-button:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        .login-button:focus-visible {
            outline: 3px solid var(--eucalyptus);
            outline-offset: 3px;
        }

        .login-button span {
            font-size: 18px;
        }

        .form-footer {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 35px;
            color: #89958F;
            font-size: 11px;
        }

        .form-footer::before,
        .form-footer::after {
            flex: 1;
            height: 1px;
            background: var(--border);
            content: "";
        }

        @media (max-width: 800px) {
            body {
                padding: 20px;
            }

            .login-container {
                grid-template-columns: 1fr;
                max-width: 520px;
            }

            .brand-panel {
                padding: 30px;
            }

            .brand-heading {
                margin-top: 40px;
            }

            .brand-heading h1 {
                font-size: 32px;
            }

            .brand-footer {
                margin-top: 24px;
            }

            .form-panel {
                padding: 34px 30px;
            }

            .access-label {
                margin-bottom: 25px;
            }
        }

        @media (max-width: 400px) {
            body {
                padding: 10px;
            }

            .brand-panel,
            .form-panel {
                padding: 24px 20px;
            }

            .feature-list {
                gap: 7px;
            }

            .feature {
                padding: 12px 8px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition: none !important;
            }
        }
    </style>
</head>
<body>
    <main class="login-container">
        
<section class="brand-panel">
    <div class="brand-content">
        <div class="brand-mark">
            <div class="brand-icon" aria-hidden="true">PB</div>
            <div>
                <p class="brand-name">Generator PB</p>
                <p class="brand-caption">E-Channel Dashboard</p>
            </div>
        </div>

        <div class="brand-heading">
            <span class="eyebrow">SISTEM INTERNAL</span>
            <h1>Generator Pemindah Pembukuan (PB) </h1>
            <p>
                Divisi E-Channel<br>
                Bank Riau Kepri Syariah
            </p>
        </div>
    </div>

    <div class="brand-footer">
        Generator PB &middot; Divisi E-Channel
    </div>
</section>


        <section class="form-panel">

            <h2>Selamat datang</h2>

            <div class="info-banner">
                <span class="info-icon" aria-hidden="true">i</span>
                <span>
                    Gunakan username dan password untuk melanjutkan ke dashboard.
                </span>
            </div>

            @if ($errors->any())
                <div class="error-message" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="username">Username</label>

                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">♙</span>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">⌑</span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="login-button">
                    <span aria-hidden="true">→</span>
                    Login ke Dashboard
                </button>
            </form>

            <div class="form-footer">
                Generator PB &middot; Versi 1.0
            </div>
        </section>
    </main>
</body>
</html>
