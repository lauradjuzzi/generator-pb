<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Generator PB</title>

    <style>
        :root {
            --brk-red: #c62828;
            --brk-red-dark: #8f1d1d;
            --brk-red-soft: #ef5350;

            --brk-green: #087f5b;
            --brk-green-dark: #045a41;
            --brk-green-soft: #35a77e;

            --brk-orange: #f59f00;
            --brk-orange-light: #ffbd3d;

            --white: #ffffff;
            --text: #f7faf9;
            --muted: rgba(255, 255, 255, 0.62);

            --glass: rgba(255, 255, 255, 0.085);
            --glass-strong: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.19);

            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            background: #07100e;
            color: var(--text);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        /* =====================================================
           BACKGROUND
           ===================================================== */

        .login-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow: hidden;

            background:
                radial-gradient(circle at 15% 20%,
                    rgba(8, 127, 91, 0.14),
                    transparent 32%),
                radial-gradient(circle at 85% 75%,
                    rgba(245, 159, 0, 0.10),
                    transparent 30%),
                linear-gradient(135deg,
                    #d0162bdf 0%,
                    #716244c0 50%,
                    #395a3fd0 100%);
        }

        .login-page::before {
            position: absolute;
            inset: 0;
            content: "";

            background:
                linear-gradient(115deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.025) 45%,
                    transparent 70%);

            pointer-events: none;
        }

        .ambient {
            position: absolute;
            border-radius: 50%;
            filter: blur(4px);
            pointer-events: none;
            will-change: transform;
        }

        .ambient-red {
            top: -130px;
            left: -100px;
            width: 380px;
            height: 380px;
            background:
                radial-gradient(circle,
                    rgba(198, 40, 40, 0.34),
                    transparent 68%);
        }

        .ambient-green {
            right: -120px;
            top: 80px;
            width: 420px;
            height: 420px;
            background:
                radial-gradient(circle,
                    rgba(8, 127, 91, 0.32),
                    transparent 68%);
        }

        .ambient-orange {
            bottom: -180px;
            left: 34%;
            width: 420px;
            height: 420px;
            background:
                radial-gradient(circle,
                    rgba(245, 159, 0, 0.24),
                    transparent 68%);
        }

        .ambient-line {
            position: absolute;
            width: 75%;
            height: 1px;
            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.13),
                    transparent);
            transform: rotate(-12deg);
            pointer-events: none;
        }

        .ambient-line.one {
            top: 25%;
            left: -12%;
        }

        .ambient-line.two {
            bottom: 24%;
            right: -12%;
            transform: rotate(12deg);
        }

        /* =====================================================
           MAIN STAGE
           ===================================================== */

        .login-stage {
            position: relative;
            z-index: 10;

            width: min(1120px, 100%);

            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(430px, 1.1fr);
            gap: 28px;

            align-items: center;
        }

        /* =====================================================
           BRAND AREA
           ===================================================== */

        .brand-area {
            position: relative;
            min-height: 560px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            padding: 46px;

            transform:
                translate3d(var(--brand-x, 0px),
                    var(--brand-y, 0px),
                    0);

            transition:
                transform 0.65s var(--ease-out);

            will-change: transform;
        }

        .brand-area::before {
            position: absolute;
            top: 10%;
            left: 4%;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(198, 40, 40, 0.22),
                    transparent 70%);

            content: "";
            pointer-events: none;
        }

        .brand-logo {
            position: relative;
            z-index: 2;

            display: inline-flex;
            align-items: center;
            gap: 14px;

            width: fit-content;
            margin-bottom: 38px;

            transform:
                translate3d(var(--logo-x, 0px),
                    var(--logo-y, 0px),
                    0);

            transition:
                transform 0.5s var(--ease-out);

            will-change: transform;
        }

        .brand-logo-mark {
            position: relative;

            width: 58px;
            height: 58px;

            display: grid;
            place-items: center;

            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 17px;

            background:
                linear-gradient(145deg,
                    rgba(198, 40, 40, 0.88),
                    rgba(8, 127, 91, 0.82));

            box-shadow:
                0 16px 40px rgba(0, 0, 0, 0.24),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);

            overflow: hidden;
        }

        .brand-logo-mark::before {
            position: absolute;
            top: -24px;
            right: -24px;

            width: 65px;
            height: 65px;

            border-radius: 50%;

            background: var(--brk-orange);

            content: "";
        }

        .brand-logo-mark span {
            position: relative;
            z-index: 2;

            color: #ffffff;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .brand-logo-name {
            margin: 0;

            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        .brand-logo-subtitle {
            margin: 4px 0 0;

            color: rgba(255, 255, 255, 0.55);
            font-size: 11px;
            letter-spacing: 0.8px;
        }

        .brand-kicker {
            position: relative;
            z-index: 2;

            display: inline-flex;
            align-items: center;
            gap: 9px;

            width: fit-content;
            margin-bottom: 18px;
            padding: 8px 12px;

            border: 1px solid rgba(245, 159, 0, 0.25);
            border-radius: 999px;

            background: rgba(8, 127, 91, 0.10);

            color: #ffd37a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        .brand-kicker-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--brk-orange);

            box-shadow:
                0 0 0 4px rgba(245, 159, 0, 0.1);
        }

        .brand-title {
            position: relative;
            z-index: 2;

            max-width: 520px;
            margin: 0;

            color: #ffffff;
            font-size: clamp(42px, 5vw, 70px);
            font-weight: 800;
            line-height: 0.98;
            letter-spacing: -3px;

            transform:
                translate3d(var(--title-x, 0px),
                    var(--title-y, 0px),
                    0);

            transition:
                transform 0.55s var(--ease-out);

            will-change: transform;
        }

        .brand-title .red {
            color: #ff6b6b;
        }

        .brand-title .orange {
            color: var(--brk-orange-light);
        }

        .brand-description {
            position: relative;
            z-index: 2;

            max-width: 430px;
            margin: 24px 0 0;

            color: rgba(255, 255, 255, 0.58);
            font-size: 14px;
            line-height: 1.8;
        }

        .brand-footer {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            gap: 10px;

            margin-top: 40px;

            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
        }

        .brand-footer-line {
            width: 30px;
            height: 1px;
            background:
                linear-gradient(90deg,
                    var(--brk-red),
                    var(--brk-orange));
        }

        /* =====================================================
           FLOATING DECORATIONS
           ===================================================== */

        .floating-chip {
            position: absolute;
            z-index: 1;

            display: flex;
            align-items: center;
            gap: 8px;

            padding: 10px 13px;

            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;

            background:
                rgba(255, 255, 255, 0.045);

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            color: rgba(255, 255, 255, 0.6);
            font-size: 10px;

            pointer-events: none;
        }

        .floating-chip::before {
            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: var(--chip-color);

            content: "";
        }

        .chip-one {
            top: 8%;
            right: 4%;
            --chip-color: var(--brk-red);
            animation: floatingOne 5s ease-in-out infinite;
        }

        .chip-two {
            right: 13%;
            bottom: 13%;
            --chip-color: var(--brk-orange);
            animation: floatingTwo 6s ease-in-out infinite;
        }

        .chip-three {
            top: 33%;
            left: -2%;
            --chip-color: var(--brk-green-soft);
            animation: floatingThree 7s ease-in-out infinite;
        }

        @keyframes floatingOne {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, -12px, 0);
            }
        }

        @keyframes floatingTwo {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(8px, -8px, 0);
            }
        }

        @keyframes floatingThree {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(-7px, 10px, 0);
            }
        }

        /* =====================================================
           LOGIN CARD
           ===================================================== */

        .login-card {
            position: relative;

            min-height: 560px;

            padding: 42px;

            border: 1px solid var(--glass-border);
            border-radius: 28px;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.13),
                    rgba(255, 255, 255, 0.045));

            box-shadow:
                0 40px 100px rgba(0, 0, 0, 0.32),
                0 12px 35px rgba(8, 127, 91, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);

            backdrop-filter: blur(28px) saturate(130%);
            -webkit-backdrop-filter: blur(28px) saturate(130%);

            transform:
                perspective(1200px) translate3d(var(--card-x, 0px),
                    var(--card-y, 0px),
                    0) rotateX(var(--rotate-x, 0deg)) rotateY(var(--rotate-y, 0deg));

            transition:
                box-shadow 0.45s var(--ease-out),
                border-color 0.45s var(--ease-out);

            will-change: transform;
        }

        .login-card::before {
            position: absolute;
            inset: 0;

            border-radius: inherit;

            background:
                radial-gradient(circle 260px at var(--glow-x, 50%) var(--glow-y, 50%),
                    rgba(255, 255, 255, 0.17),
                    rgba(255, 255, 255, 0.055) 30%,
                    transparent 70%);

            content: "";

            pointer-events: none;
        }

        .login-card::after {
            position: absolute;
            inset: 1px;

            border-radius: 27px;

            border-top: 1px solid rgba(255, 255, 255, 0.18);

            content: "";

            pointer-events: none;
        }

        .login-card.is-active {
            border-color: rgba(255, 255, 255, 0.28);

            box-shadow:
                0 48px 110px rgba(0, 0, 0, 0.38),
                0 18px 50px rgba(8, 127, 91, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .login-card-content {
            position: relative;
            z-index: 3;
        }

        /* =====================================================
           CARD TOP
           ===================================================== */

        .login-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;
            margin-bottom: 34px;
        }

        .login-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 7px 10px;

            border: 1px solid rgba(8, 127, 91, 0.3);
            border-radius: 999px;

            background: rgba(8, 127, 91, 0.1);

            color: #72d9b3;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.8px;
        }

        .login-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;

            background: #105239;

            box-shadow:
                0 0 0 4px rgba(53, 214, 154, 0.1);
        }

        .login-heading {
            margin: 0;

            color: #ffffff;
            font-size: 32px;
            line-height: 1.05;
            letter-spacing: -1.3px;
        }

        .login-heading span {
            color: #ff8b8b;
        }

        .login-description {
            margin: 10px 0 0;

            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            line-height: 1.6;
        }

        /* =====================================================
           FORM
           ===================================================== */

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;

            margin-bottom: 8px;

            color: rgba(255, 255, 255, 0.72);

            font-size: 11px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;

            color: rgba(255, 255, 255, 0.38);

            font-size: 14px;

            transform: translateY(-50%);

            pointer-events: none;

            transition:
                color 0.25s ease;
        }

        .field input {
            width: 100%;
            min-height: 50px;

            padding: 13px 15px 13px 42px;

            border: 1px solid rgba(255, 255, 255, 0.11);
            border-radius: 13px;

            outline: none;

            background:
                rgba(3, 15, 13, 0.32);

            color: #ffffff;

            font-family: inherit;
            font-size: 12px;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.035);

            transition:
                border-color 0.25s ease,
                background 0.25s ease,
                box-shadow 0.25s ease,
                transform 0.25s var(--ease-out);
        }

        .field input::placeholder {
            color: rgba(255, 255, 255, 0.28);
        }

        .field input:focus {
            border-color: rgba(245, 159, 0, 0.58);

            background:
                rgba(3, 15, 13, 0.46);

            box-shadow:
                0 0 0 3px rgba(245, 159, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);

            transform: translateY(-1px);
        }

        .field input:focus+.input-focus-line {
            transform: scaleX(1);
        }

        .input-focus-line {
            position: absolute;
            left: 16px;
            right: 16px;
            bottom: 0;

            height: 1px;

            background:
                linear-gradient(90deg,
                    var(--brk-red),
                    var(--brk-orange),
                    var(--brk-green));

            transform: scaleX(0);
            transform-origin: center;

            transition:
                transform 0.3s var(--ease-out);

            pointer-events: none;
        }

        .input-wrap:focus-within .input-icon {
            color: var(--brk-orange-light);
        }

        /* =====================================================
           ERROR
           ===================================================== */

        .error-message {
            margin: 0 0 18px;
            padding: 12px 14px;

            border: 1px solid rgba(239, 83, 80, 0.3);
            border-radius: 12px;

            background:
                rgba(198, 40, 40, 0.12);

            color: #ff9d9d;

            font-size: 11px;
            line-height: 1.6;
        }

        /* =====================================================
           LOGIN BUTTON
           ===================================================== */

        .login-button {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            min-height: 51px;

            margin-top: 8px;

            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 13px;

            overflow: hidden;

            background:
                linear-gradient(100deg,
                    var(--brk-red-dark),
                    var(--brk-red),
                    var(--brk-orange),
                    var(--brk-green));

            background-size: 220% 100%;
            background-position: 0% 50%;

            color: #ffffff;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 12px 28px rgba(198, 40, 40, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);

            transition:
                transform 0.25s var(--ease-out),
                box-shadow 0.25s ease,
                background-position 0.45s ease;
        }

        .login-button::before {
            position: absolute;
            top: 0;
            left: -100%;

            width: 65%;
            height: 100%;

            background:
                linear-gradient(100deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);

            content: "";

            transform: skewX(-20deg);

            transition:
                left 0.55s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);

            background-position: 100% 50%;

            box-shadow:
                0 18px 38px rgba(198, 40, 40, 0.28),
                0 6px 18px rgba(245, 159, 0, 0.12);
        }

        .login-button:hover::before {
            left: 140%;
        }

        .login-button:active {
            transform: translateY(0) scale(0.985);
        }

        .login-button:focus-visible {
            outline: 2px solid var(--brk-orange-light);
            outline-offset: 3px;
        }

        /* =====================================================
           FOOTER
           ===================================================== */

        .login-footer {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-top: 27px;

            color: rgba(255, 255, 255, 0.32);

            font-size: 9px;
            text-align: center;
        }

        .login-footer::before,
        .login-footer::after {
            flex: 1;
            height: 1px;

            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.1));

            content: "";
        }

        .login-footer::after {
            background:
                linear-gradient(90deg,
                    rgba(255, 255, 255, 0.1),
                    transparent);
        }

        /* =====================================================
           MOTION
           ===================================================== */

        .brand-area,
        .brand-logo,
        .brand-title,
        .login-card {
            transition-timing-function: var(--ease-out);
        }

        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 900px) {
            .login-page {
                padding: 24px;
            }

            .login-stage {
                grid-template-columns: 1fr;
                max-width: 620px;
            }

            .brand-area {
                min-height: auto;
                padding: 20px 12px 4px;
            }

            .brand-title {
                max-width: 600px;
                font-size: 48px;
            }

            .brand-description {
                max-width: 560px;
            }

            .floating-chip {
                display: none;
            }

            .login-card {
                min-height: auto;
            }
        }

        @media (max-width: 560px) {
            .login-page {
                padding: 14px;
            }

            .brand-area {
                padding: 20px 8px 0;
            }

            .brand-logo {
                margin-bottom: 28px;
            }

            .brand-title {
                font-size: 39px;
                letter-spacing: -2px;
            }

            .brand-description {
                font-size: 12px;
            }

            .brand-footer {
                margin-top: 25px;
            }

            .login-card {
                padding: 28px 22px;
                border-radius: 22px;
            }

            .login-card::after {
                border-radius: 21px;
            }

            .login-heading {
                font-size: 28px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }

            .login-card,
            .brand-area,
            .brand-logo,
            .brand-title {
                transform: none !important;
            }
        }
    </style>
</head>

<body>
    <main class="login-page" data-login-page>

        <div class="ambient ambient-red" data-ambient="red"></div>
        <div class="ambient ambient-green" data-ambient="green"></div>
        <div class="ambient ambient-orange" data-ambient="orange"></div>

        <div class="ambient-line one"></div>
        <div class="ambient-line two"></div>

        <section class="login-stage">

            <div class="brand-area">

                <div class="floating-chip chip-one">
                    Secure Access
                </div>

                <div class="floating-chip chip-two">
                    E-Channel
                </div>

                <div class="brand-logo" data-depth="logo">
                    <div class="brand-logo-mark">
                        <span>BRK</span>
                    </div>

                    <div>
                        <p class="brand-logo-name">
                            BRK Syariah
                        </p>

                        <p class="brand-logo-subtitle">
                            BERKAH UNTUK SEMUA
                        </p>
                    </div>
                </div>

                <div class="brand-kicker">
                    <span class="brand-kicker-dot"></span>
                    SISTEM INTERNAL
                </div>

                <h1 class="brand-title" data-depth="title">
                    Generator
                    <span class="red">PB</span>
                </h1>

                <p class="brand-description">
                    Kelola dokumen Pemindah Pembukuan dengan proses yang
                    lebih terstruktur, cepat, dan mudah digunakan.
                </p>

                <div class="brand-footer">
                    <span class="brand-footer-line"></span>
                    Generator Pemindah Pembukuan
                </div>

            </div>

            <section class="login-card" data-login-card>
                <div class="login-card-content">

                    <div class="login-card-top">

                        <div>
                            <h2 class="login-heading">
                                Selamat <span>datang.</span>
                            </h2>

                            <p class="login-description">
                                Masukkan akun milikmu untuk melanjutkan
                                ke dashboard Generator PB.
                            </p>
                        </div>

                        <div class="login-status">
                            <span class="login-status-dot"></span>
                            ONLINE
                        </div>

                    </div>

                    @if ($errors->any())
                        <div class="error-message" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST" data-login-form>
                        @csrf

                        <div class="field">
                            <label for="username">
                                Username
                            </label>

                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    ◎
                                </span>

                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    placeholder="Masukkan username" autocomplete="username" required autofocus>

                                <span class="input-focus-line"></span>
                            </div>
                        </div>

                        <div class="field">
                            <label for="password">
                                Password
                            </label>

                            <div class="input-wrap">
                                <span class="input-icon" aria-hidden="true">
                                    ◉
                                </span>

                                <input type="password" id="password" name="password" placeholder="Masukkan password"
                                    autocomplete="current-password" required>

                                <span class="input-focus-line"></span>
                            </div>
                        </div>

                        <button type="submit" class="login-button">
                            Login ke Dashboard
                        </button>
                    </form>

                    <div class="login-footer">
                        Generator PB
                    </div>

                </div>
            </section>

        </section>
    </main>

    <script>
        (() => {
            const page = document.querySelector('[data-login-page]')
            const card = document.querySelector('[data-login-card]')
            const brand = document.querySelector('.brand-area')
            const logo = document.querySelector('[data-depth="logo"]')
            const title = document.querySelector('[data-depth="title"]')

            if (!page || !card || !brand) {
                return
            }

            const desktopQuery = window.matchMedia('(min-width: 901px)')
            const reducedMotionQuery = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            )

            if (
                !desktopQuery.matches ||
                reducedMotionQuery.matches
            ) {
                return
            }

            let targetX = 0
            let targetY = 0

            let currentX = 0
            let currentY = 0

            let targetRotateX = 0
            let targetRotateY = 0

            let currentRotateX = 0
            let currentRotateY = 0

            let inside = false

            const moveStrength = 16
            const rotateStrength = 5

            const clamp = (value, min, max) => {
                return Math.min(
                    Math.max(value, min),
                    max
                )
            }

            const handlePointerMove = (event) => {
                const rect = page.getBoundingClientRect()

                const x = (
                    (event.clientX - rect.left) /
                    rect.width
                )

                const y = (
                    (event.clientY - rect.top) /
                    rect.height
                )

                const normalizedX = clamp(
                    (x - 0.5) * 2,
                    -1,
                    1
                )

                const normalizedY = clamp(
                    (y - 0.5) * 2,
                    -1,
                    1
                )

                targetX = normalizedX * moveStrength
                targetY = normalizedY * moveStrength

                targetRotateY =
                    normalizedX * rotateStrength

                targetRotateX =
                    normalizedY * -rotateStrength

                const cardRect =
                    card.getBoundingClientRect()

                const cardX = clamp(
                    (
                        (event.clientX - cardRect.left) /
                        cardRect.width
                    ) * 100,
                    0,
                    100
                )

                const cardY = clamp(
                    (
                        (event.clientY - cardRect.top) /
                        cardRect.height
                    ) * 100,
                    0,
                    100
                )

                card.style.setProperty(
                    '--glow-x',
                    `${cardX}%`
                )

                card.style.setProperty(
                    '--glow-y',
                    `${cardY}%`
                )

                inside = true

                card.classList.add('is-active')
            }

            const handlePointerLeave = () => {
                targetX = 0
                targetY = 0

                targetRotateX = 0
                targetRotateY = 0

                card.style.setProperty(
                    '--glow-x',
                    '50%'
                )

                card.style.setProperty(
                    '--glow-y',
                    '50%'
                )

                card.classList.remove('is-active')

                inside = false
            }

            const animate = () => {
                const stiffness = inside
                    ? 0.12
                    : 0.075

                currentX += (
                    targetX - currentX
                ) * stiffness

                currentY += (
                    targetY - currentY
                ) * stiffness

                currentRotateX += (
                    targetRotateX -
                    currentRotateX
                ) * stiffness

                currentRotateY += (
                    targetRotateY -
                    currentRotateY
                ) * stiffness

                if (!inside) {
                    currentX *= 0.88
                    currentY *= 0.88

                    currentRotateX *= 0.86
                    currentRotateY *= 0.86
                }

                card.style.setProperty(
                    '--card-x',
                    `${currentX}px`
                )

                card.style.setProperty(
                    '--card-y',
                    `${currentY}px`
                )

                card.style.setProperty(
                    '--rotate-x',
                    `${currentRotateX}deg`
                )

                card.style.setProperty(
                    '--rotate-y',
                    `${currentRotateY}deg`
                )

                brand.style.setProperty(
                    '--brand-x',
                    `${currentX * -0.28}px`
                )

                brand.style.setProperty(
                    '--brand-y',
                    `${currentY * -0.28}px`
                )

                logo.style.setProperty(
                    '--logo-x',
                    `${currentX * -0.45}px`
                )

                logo.style.setProperty(
                    '--logo-y',
                    `${currentY * -0.45}px`
                )

                title.style.setProperty(
                    '--title-x',
                    `${currentX * -0.22}px`
                )

                title.style.setProperty(
                    '--title-y',
                    `${currentY * -0.22}px`
                )

                document
                    .querySelector(
                        '.ambient-red'
                    )
                    ?.style.setProperty(
                        'transform',
                        `translate3d(
                            ${currentX * 1.4}px,
                            ${currentY * 1.1}px,
                            0
                        )`
                    )

                document
                    .querySelector(
                        '.ambient-green'
                    )
                    ?.style.setProperty(
                        'transform',
                        `translate3d(
                            ${currentX * -1.2}px,
                            ${currentY * -0.8}px,
                            0
                        )`
                    )

                document
                    .querySelector(
                        '.ambient-orange'
                    )
                    ?.style.setProperty(
                        'transform',
                        `translate3d(
                            ${currentX * 0.7}px,
                            ${currentY * -1.1}px,
                            0
                        )`
                    )

                requestAnimationFrame(animate)
            }

            page.addEventListener(
                'pointermove',
                handlePointerMove,
                { passive: true }
            )

            page.addEventListener(
                'pointerleave',
                handlePointerLeave
            )

            animate()
        })()
    </script>
</body>

</html>