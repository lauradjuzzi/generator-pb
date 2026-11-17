@extends('layouts.app')

@section('content')
    <div class="brk-form-page">

        <div class="brk-form-header brk-form-animate">

            <div class="brk-form-heading">

                <div>
                    <span class="brk-form-eyebrow">
                        {{ strtoupper($documentType) }}
                    </span>

                    <h1>
                        {{ $documentType === 'pb01' ? 'Mendebet Rekening' : 'Penerusan ke BI' }}
                    </h1>

                    <p>
                        Top Up {{ $topupType->name }}
                    </p>
                </div>

            </div>

        </div>


        {{-- PESAN BERHASIL --}}
        @if (session('success'))
            <div class="brk-form-alert brk-form-alert-success brk-form-animate">

                <div class="brk-form-alert-icon">
                    ✓
                </div>

                <div>
                    {{ session('success') }}
                </div>

            </div>
        @endif


        {{-- PESAN ERROR --}}
        @if ($errors->any())
            <div class="brk-form-alert brk-form-alert-error brk-form-animate">

                <div class="brk-form-alert-icon">
                    !
                </div>

                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif


        {{-- ==================== PB 01 ==================== --}}
        @if ($documentType === 'pb01')

            <div class="brk-pb-form-card brk-form-animate brk-form-delay-1">

                <div class="brk-pb-form-card-header">

                    <div class="brk-pb-form-card-title">

                        <div class="brk-pb-form-badge">
                            PB 01
                        </div>

                        <div>
                            <h2>Mendebet Rekening</h2>

                            <p>
                                Formulir transaksi pemindahbukuan untuk pendebetan rekening.
                            </p>
                        </div>

                    </div>

                    <div class="brk-form-status">
                        <span class="brk-form-status-dot"></span>
                        <span>Data transaksi</span>
                    </div>

                </div>


                <form method="POST" action="{{ route('topup.generator.pb01.store', [
                'topupType' => $topupType->slug,
            ]) }}" class="pb-form" data-form="pb01">

                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- INFORMASI PB --}}
                        <div>
                            <label for="pb01_number">
                                Nomor PB
                            </label>

                            <input type="text" id="pb01_number" name="pb_number" autocomplete="off"
                                value="{{ old('pb_number') }}" placeholder="Masukkan nomor PB" required>
                        </div>


                        {{-- PERIODE --}}
                        <div class="form-group">

                            <label for="pb01_date_range">
                                Periode Transaksi
                            </label>

                            <input type="text" id="pb01_date_range" placeholder="Pilih rentang tanggal" autocomplete="off"
                                class="form-control">

                            <input type="hidden" name="date_from" id="pb01_date_from">
                            <input type="hidden" name="date_until" id="pb01_date_until">

                        </div>


                        {{-- DEBET --}}
                        <div class="mt-4 md:col-span-2">

                            <div>
                                <h3>Debet</h3>

                                <p>
                                    Data rekening yang akan didebet.
                                </p>
                            </div>

                        </div>


                        {{-- NOMOR REKENING DEBET --}}
                        <div>

                            <label for="pb01_debit_account_number">
                                Nomor Rekening Debet
                            </label>

                            <input type="text" id="pb01_debit_account_number" name="debit_account_number"
                                value="{{ old('debit_account_number', $topupType->default_debit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" class="pb01-number"
                                placeholder="Masukkan nomor rekening" required>

                            <p id="pb01_debit_account_number_error" class="hidden">
                                Nomor rekening hanya boleh berisi angka.
                            </p>

                        </div>


                        {{-- NAMA REKENING DEBET --}}
                        <div>

                            <label for="pb01_debit_account_name">
                                Nama Rekening Debet
                            </label>

                            <input type="text" id="pb01_debit_account_name" name="debit_account_name"
                                value="{{ old('debit_account_name', $topupType->default_debit_account_name) }}"
                                placeholder="Masukkan nama rekening" required>

                        </div>


                        {{-- NOMINAL DEBET --}}
                        <div>

                            <label for="pb01_debit_amount">
                                Nominal Debet
                            </label>

                            <input type="number" id="pb01_debit_amount" name="debit_amount" value="{{ old('debit_amount') }}"
                                min="1" step="0.01" class="pb01-amount" placeholder="Contoh: 1000000" required>

                            <p id="pb01_debit_amount_error" class="hidden">
                                Nominal Debet harus berupa angka.
                            </p>

                        </div>


                        {{-- KETERANGAN DEBET --}}
                        <div class="md:col-span-2">

                            <label for="pb01_debit_description">
                                Keterangan Debet
                            </label>

                            <textarea id="pb01_debit_description" name="debit_description" rows="3"
                                placeholder="Masukkan keterangan transaksi debet">{{ old('debit_description', $topupType->default_debit_description) }}</textarea>

                        </div>


                        {{-- KREDIT --}}
                        <div class="mt-4 md:col-span-2">

                            <div>
                                <h3>Kredit</h3>

                                <p>
                                    Data rekening yang akan dikredit.
                                </p>
                            </div>

                        </div>


                        {{-- NOMOR REKENING KREDIT --}}
                        <div>

                            <label for="pb01_credit_account_number">
                                Nomor Rekening Kredit
                            </label>

                            <input type="text" id="pb01_credit_account_number" name="credit_account_number"
                                value="{{ old('credit_account_number', $topupType->default_credit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" class="pb01-number"
                                placeholder="Masukkan nomor rekening" required>

                            <p id="pb01_credit_account_number_error" class="hidden">
                                Nomor rekening hanya boleh berisi angka.
                            </p>

                        </div>


                        {{-- NAMA REKENING KREDIT --}}
                        <div>

                            <label for="pb01_credit_account_name">
                                Nama Rekening Kredit
                            </label>

                            <input type="text" id="pb01_credit_account_name" name="credit_account_name"
                                value="{{ old('credit_account_name', $topupType->default_credit_account_name) }}"
                                placeholder="Masukkan nama rekening" required>

                        </div>


                        {{-- NOMINAL KREDIT --}}
                        <div>

                            <label for="pb01_credit_amount">
                                Nominal Kredit
                            </label>

                            <input type="number" id="pb01_credit_amount" name="credit_amount" value="{{ old('credit_amount') }}"
                                min="1" step="0.01" class="pb01-amount" placeholder="Contoh: 1000000" required>

                            <p id="pb01_credit_amount_error" class="hidden">
                                Nominal Kredit harus berupa angka.
                            </p>

                        </div>


                        {{-- KETERANGAN KREDIT --}}
                        <div class="md:col-span-2">

                            <label for="pb01_credit_description">
                                Keterangan Kredit
                            </label>

                            <textarea id="pb01_credit_description" name="credit_description" rows="3"
                                placeholder="Masukkan keterangan transaksi kredit">{{ old('credit_description', $topupType->default_credit_description) }}</textarea>

                        </div>

                    </div>


                    {{-- SIMPAN PB01 --}}
                    <div class="mt-6">

                        <button type="submit" class="pb01-save hidden">
                            Simpan PB01
                        </button>

                    </div>

                </form>

            </div>


            {{-- ==================== PB 02 ==================== --}}
        @elseif ($documentType === 'pb02')

            <div class="brk-pb-form-card brk-form-animate brk-form-delay-1">

                <div class="brk-pb-form-card-header">

                    <div class="brk-pb-form-card-title">

                        <div class="brk-pb-form-badge pb02">
                            PB 02
                        </div>

                        <div>
                            <h2>Penerusan ke BI</h2>

                            <p>
                                Formulir transaksi pemindahbukuan untuk penerusan ke Bank Indonesia.
                            </p>
                        </div>

                    </div>

                    <div class="brk-form-status">
                        <span class="brk-form-status-dot"></span>
                        <span>Data transaksi</span>
                    </div>

                </div>


                <form method="POST" action="{{ route('topup.generator.pb02.store', [
                'topupType' => $topupType->slug,
            ]) }}" class="pb-form" data-form="pb02">

                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NOMOR PB --}}
                        <div>

                            <label for="pb02_number">
                                Nomor PB
                            </label>

                            <input type="text" id="pb02_number" name="pb_number" autocomplete="off"
                                value="{{ old('pb_number') }}" placeholder="Masukkan nomor PB" required>

                        </div>


                        {{-- PERIODE --}}
                        <div class="form-group">

                            <label for="pb02_date_range">
                                Periode Transaksi
                            </label>

                            <input type="text" id="pb02_date_range" placeholder="Pilih rentang tanggal" autocomplete="off"
                                class="form-control">

                            <input type="hidden" name="date_from" id="pb02_date_from">
                            <input type="hidden" name="date_until" id="pb02_date_until">

                        </div>


                        {{-- DEBET --}}
                        <div class="mt-4 md:col-span-2">

                            <div>
                                <h3>Debet</h3>

                                <p>
                                    Data rekening yang akan didebet.
                                </p>
                            </div>

                        </div>


                        {{-- NOMOR REKENING DEBET --}}
                        <div>

                            <label for="pb02_debit_account_number">
                                Nomor Rekening Debet
                            </label>

                            <input type="text" id="pb02_debit_account_number" name="debit_account_number"
                                value="{{ old('debit_account_number', $topupType->default_debit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" class="pb02-number"
                                placeholder="Masukkan nomor rekening" required>

                            <p id="pb02_debit_account_number_error" class="hidden">
                                Nomor rekening hanya boleh berisi angka.
                            </p>

                        </div>


                        {{-- NAMA REKENING DEBET --}}
                        <div>

                            <label for="pb02_debit_account_name">
                                Nama Rekening Debet
                            </label>

                            <input type="text" id="pb02_debit_account_name" name="debit_account_name"
                                value="{{ old('debit_account_name', $topupType->default_debit_account_name) }}"
                                placeholder="Masukkan nama rekening" required>

                        </div>


                        {{-- NOMINAL DEBET --}}
                        <div>

                            <label for="pb02_debit_amount">
                                Nominal Debet
                            </label>

                            <input type="number" id="pb02_debit_amount" name="debit_amount" value="{{ old('debit_amount') }}"
                                min="1" step="0.01" class="pb02-amount" placeholder="Contoh: 1000000" required>

                            <p id="pb02_debit_amount_error" class="hidden">
                                Nominal Debet harus berupa angka.
                            </p>

                        </div>


                        {{-- KETERANGAN DEBET --}}
                        <div class="md:col-span-2">

                            <label for="pb02_debit_description">
                                Keterangan Debet
                            </label>

                            <textarea id="pb02_debit_description" name="debit_description" rows="3"
                                placeholder="Masukkan keterangan transaksi debet">{{ old('debit_description', $topupType->default_debit_description) }}</textarea>

                        </div>


                        {{-- KREDIT --}}
                        <div class="mt-4 md:col-span-2">

                            <div>
                                <h3>Kredit</h3>

                                <p>
                                    Data rekening yang akan dikredit.
                                </p>

                            </div>

                        </div>


                        {{-- NOMOR REKENING KREDIT --}}
                        <div>

                            <label for="pb02_credit_account_number">
                                Nomor Rekening Kredit
                            </label>

                            <input type="text" id="pb02_credit_account_number" name="credit_account_number"
                                value="{{ old('credit_account_number', $topupType->default_credit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" class="pb02-number"
                                placeholder="Masukkan nomor rekening" required>

                            <p id="pb02_credit_account_number_error" class="hidden">
                                Nomor rekening hanya boleh berisi angka.
                            </p>

                        </div>


                        {{-- NAMA REKENING KREDIT --}}
                        <div>

                            <label for="pb02_credit_account_name">
                                Nama Rekening Kredit
                            </label>

                            <input type="text" id="pb02_credit_account_name" name="credit_account_name"
                                value="{{ old('credit_account_name', $topupType->default_credit_account_name) }}"
                                placeholder="Masukkan nama rekening" required>

                        </div>


                        {{-- NOMINAL KREDIT --}}
                        <div>

                            <label for="pb02_credit_amount">
                                Nominal Kredit
                            </label>

                            <input type="number" id="pb02_credit_amount" name="credit_amount" value="{{ old('credit_amount') }}"
                                min="1" step="0.01" class="pb02-amount" placeholder="Contoh: 1000000" required>

                            <p id="pb02_credit_amount_error" class="hidden">
                                Nominal Kredit harus berupa angka.
                            </p>

                        </div>


                        {{-- KETERANGAN KREDIT --}}
                        <div class="md:col-span-2">

                            <label for="pb02_credit_description">
                                Keterangan Kredit
                            </label>

                            <textarea id="pb02_credit_description" name="credit_description" rows="3"
                                placeholder="Masukkan keterangan transaksi kredit">{{ old('credit_description', $topupType->default_credit_description) }}</textarea>

                        </div>

                    </div>


                    {{-- SIMPAN PB02 --}}
                    <div class="mt-6">

                        <button type="submit" class="pb02-save hidden">
                            Simpan PB02
                        </button>

                    </div>

                </form>

            </div>

        @endif

    </div>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function setupNumberValidation(formSelector, numberClass, amountClass) {
                const form = document.querySelector(formSelector);
                if (!form) return;

                const inputs = form.querySelectorAll(`.${numberClass}, .${amountClass}`);

                inputs.forEach(function (input) {

                    function validate() {

                        const error = document.getElementById(input.id + '_error');

                        if (!error) return true;

                        const value = input.value.trim();

                        let isValid;

                        if (input.classList.contains(numberClass)) {
                            isValid = /^[0-9]+$/.test(value);
                        } else {
                            isValid = /^[0-9]+(\.[0-9]+)?$/.test(value);
                        }

                        if (isValid) {

                            input.classList.remove('!border-red-500');
                            input.classList.add('!border-gray-300');
                            error.classList.add('hidden');

                        } else {

                            input.classList.remove('!border-gray-300');
                            input.classList.add('!border-red-500');
                            error.classList.remove('hidden');

                        }

                        return isValid;
                    }

                    input.addEventListener('input', validate);
                    input.addEventListener('blur', validate);

                });
            }


            function setupDateRange(formSelector, rangeId, fromHiddenId, untilHiddenId) {

                const form = document.querySelector(formSelector);

                if (!form) {
                    return;
                }

                const rangeInput = document.getElementById(rangeId);
                const fromHidden = document.getElementById(fromHiddenId);
                const untilHidden = document.getElementById(untilHiddenId);

                if (!rangeInput || !fromHidden || !untilHidden) {
                    return;
                }

                flatpickr(rangeInput, {

                    mode: 'range',

                    dateFormat: 'd-m-Y',

                    locale: {
                        firstDayOfWeek: 1
                    },

                    onChange: function (selectedDates) {

                        if (selectedDates.length >= 1) {

                            const from = selectedDates[0];

                            fromHidden.value =
                                from.getFullYear() + '-' +
                                String(from.getMonth() + 1).padStart(2, '0') + '-' +
                                String(from.getDate()).padStart(2, '0');

                        }

                        if (selectedDates.length === 2) {

                            const until = selectedDates[1];

                            untilHidden.value =
                                until.getFullYear() + '-' +
                                String(until.getMonth() + 1).padStart(2, '0') + '-' +
                                String(until.getDate()).padStart(2, '0');

                        } else {

                            untilHidden.value = '';

                        }

                    }

                });

            }


            function setupSaveButton(formSelector, amountSelector, buttonSelector) {

                const form = document.querySelector(formSelector);

                if (!form) {
                    return;
                }

                const amounts = form.querySelectorAll(amountSelector);
                const button = form.querySelector(buttonSelector);

                if (!button) {
                    return;
                }

                function checkAmount() {

                    const filled = Array.from(amounts).every(function (input) {
                        return input.value.trim() !== '';
                    });

                    if (filled) {
                        button.classList.remove('hidden');
                    } else {
                        button.classList.add('hidden');
                    }

                }

                amounts.forEach(function (input) {
                    input.addEventListener('input', checkAmount);
                });

                checkAmount();

            }


            setupDateRange(
                '[data-form="pb01"]',
                'pb01_date_range',
                'pb01_date_from',
                'pb01_date_until'
            );

            setupDateRange(
                '[data-form="pb02"]',
                'pb02_date_range',
                'pb02_date_from',
                'pb02_date_until'
            );


            setupNumberValidation(
                '[data-form="pb01"]',
                'pb01-number',
                'pb01-amount'
            );

            setupNumberValidation(
                '[data-form="pb02"]',
                'pb02-number',
                'pb02-amount'
            );


            setupSaveButton(
                '[data-form="pb01"]',
                '.pb01-amount',
                '.pb01-save'
            );

            setupSaveButton(
                '[data-form="pb02"]',
                '.pb02-amount',
                '.pb02-save'
            );

        });
    </script>

@endsection