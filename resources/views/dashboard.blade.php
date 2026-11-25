@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-label', 'Dashboard Utama')

@section('content')
    <style>
        .dashboard-header {
            margin-bottom: 28px;
        }

        .dashboard-header h1 {
            margin: 0;
            color: #24312F;
            font-size: 28px;
            font-weight: 800;
        }

        .dashboard-header p {
            margin: 7px 0 0;
            color: #6B7773;
            font-size: 14px;
        }

        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid #DCE4E0;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(32, 79, 75, .05);
        }

        .summary-label {
            color: #6B7773;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .summary-value {
            margin-top: 8px;
            color: #286963;
            font-size: 30px;
            font-weight: 800;
        }

        .history-card {
            overflow: hidden;
            border: 1px solid #DCE4E0;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(32, 79, 75, .05);
        }

        .history-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #E7ECEA;
        }

        .history-header h2 {
            margin: 0;
            color: #24312F;
            font-size: 18px;
            font-weight: 800;
        }

        .history-header p {
            margin: 5px 0 0;
            color: #7A8582;
            font-size: 12px;
        }

        .history-search {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .history-search input {
            width: 280px;
            padding: 9px 11px;
            border: 1px solid #DCE4E0;
            border-radius: 8px;
            color: #34413E;
            background: #fff;
            font-size: 12px;
            outline: none;
        }

        .history-search input:focus {
            border-color: #286963;
        }

        .history-search button {
            padding: 9px 12px;
            border: 1px solid #DCE4E0;
            border-radius: 8px;
            color: #286963;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .history-search button:hover {
            color: #fff;
            background: #286963;
            border-color: #286963;
        }

        .history-table-wrapper {
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .history-table th {
            padding: 13px 16px;
            color: #65716E;
            background: #F6F9F7;
            font-size: 11px;
            font-weight: 800;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        .history-table td {
            padding: 15px 16px;
            border-top: 1px solid #EDF1EF;
            color: #34413E;
            font-size: 13px;
            vertical-align: middle;
        }

        .history-table tbody tr:hover {
            background: #FAFCFB;
        }

        .document-number {
            color: #286963;
            font-weight: 800;
        }

        .document-type {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 7px;
            color: #286963;
            background: #EAF4F1;
            font-size: 11px;
            font-weight: 800;
        }

        .nominal {
            color: #24312F;
            font-weight: 750;
            white-space: nowrap;
        }

        .creator-name {
            font-weight: 650;
        }

        .date-text {
            color: #6B7773;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 800;
        }

        .status-generated {
            color: #286963;
            background: #EAF4F1;
        }

        .status-active {
            color: #A85A00;
            background: #FFF2DD;
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 10px;
            border: 1px solid #DCE4E0;
            border-radius: 7px;
            color: #286963;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .action-button:hover {
            color: #fff;
            background: #286963;
            border-color: #286963;
        }

        .empty-history {
            padding: 55px 20px;
            color: #7A8582;
            text-align: center;
        }

        .empty-history strong {
            display: block;
            margin-bottom: 7px;
            color: #34413E;
            font-size: 15px;
        }

        @media (max-width: 900px) {
            .dashboard-summary {
                grid-template-columns: 1fr;
            }

            .history-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .history-search {
                width: 100%;
            }

            .history-search input {
                flex: 1;
                width: auto;
            }
        }

        /* =========================================================
                                                                               EDIT MODAL
                                                                               ========================================================= */

        .edit-modal {
            display: none;
            position: fixed;
            top: 82px;
            right: 0;
            bottom: 0;
            left: 300px;

            z-index: 9999;

            align-items: flex-start;
            justify-content: center;

            padding: 24px;

            background: rgba(20, 35, 32, 0.42);

            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);

            pointer-events: auto;
        }

        .edit-modal.show {
            display: flex;
        }

        .edit-modal-content {
            position: relative;
            z-index: 10000;

            width: min(1100px, 100%);
            max-height: calc(100vh - 130px);

            overflow-y: auto;

            padding: 0;

            border: 1px solid #e5ebe8;
            border-radius: 20px;

            background: #ffffff;

            box-shadow:
                0 20px 50px rgba(20, 35, 32, 0.18),
                0 4px 16px rgba(20, 35, 32, 0.08);

            pointer-events: auto;
        }

        /* Header */

        .edit-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            padding: 20px 26px;

            border-bottom: 1px solid #edf1ef;
            background: #ffffff;
        }

        .edit-modal-header h2 {
            margin: 0 0 5px;
            color: #182522;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.25;
        }

        .edit-modal-header p {
            margin: 0;
            color: #71807b;
            font-size: 12px;
            line-height: 1.5;
        }

        .edit-modal-close {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 38px;
            height: 38px;
            flex: 0 0 38px;

            border: 1px solid #e3e9e6;
            border-radius: 10px;

            color: #667570;
            background: #f8faf9;

            font-size: 22px;
            line-height: 1;

            cursor: pointer;

            transition:
                background-color 0.18s ease,
                color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .edit-modal-close:hover {
            border-color: #f1cccc;
            background: #fce8e8;
            color: #c62828;
            transform: rotate(3deg);
        }

        /* Area form */

        #edit-form {
            padding: 22px 26px 26px;
        }

        /* Informasi atas */

        .edit-form-top {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        /* Dua bagian PB */

        .edit-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* Card PB */

        .edit-section {
            position: relative;

            padding: 20px;

            border: 1px solid #e3ebe7;
            border-radius: 16px;

            background:
                linear-gradient(180deg,
                    #ffffff 0%,
                    #fbfcfb 100%);

            box-shadow: 0 5px 18px rgba(20, 35, 32, 0.045);
        }

        /* Garis warna atas */

        .edit-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 20px;
            right: 20px;

            height: 3px;

            border-radius: 0 0 6px 6px;
            background: #087f5b;
        }

        /* Judul section */

        .edit-section h3 {
            margin: 2px 0 18px;
            color: #182522;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.3;
        }

        .edit-section h4 {
            margin: 22px 0 14px;
            padding: 9px 12px;

            border: 0;
            border-left: 3px solid #f59f00;
            border-radius: 7px;

            background: #fff8e8;
            color: #8a5a00;

            font-size: 12px;
            font-weight: 800;
            line-height: 1.3;
        }

        .edit-section h4:first-of-type {
            margin-top: 4px;
        }

        .edit-section h4+.edit-field {
            margin-top: 0;
        }

        /* Field */

        .edit-field {
            margin-bottom: 14px;
        }

        .edit-field:last-child {
            margin-bottom: 0;
        }

        .edit-field label {
            display: block;
            margin-bottom: 7px;

            color: #4b5a56;

            font-size: 11px;
            font-weight: 800;
            line-height: 1.3;
        }

        .edit-field input,
        .edit-field textarea {
            width: 100%;
            box-sizing: border-box;

            padding: 10px 12px;

            border: 1px solid #dce5e1;
            border-radius: 9px;

            color: #263532;
            background: #ffffff;

            font-family: inherit;
            font-size: 12px;
            line-height: 1.4;

            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .edit-field textarea {
            min-height: 74px;
            resize: vertical;
        }

        .edit-field input:hover,
        .edit-field textarea:hover {
            border-color: #c6d4ce;
        }

        .edit-field input:focus,
        .edit-field textarea:focus {
            outline: none;
            border-color: #087f5b;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(8, 127, 91, 0.09);
        }

        /* Error */

        .edit-input-error {
            margin-top: 5px;
            color: #c62828;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.4;
        }

        .edit-input-invalid {
            border-color: #c62828 !important;
            background: #fffafa !important;
            box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.07) !important;
        }

        /* Footer */

        .edit-modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;

            margin-top: 24px;
            padding-top: 18px;

            border-top: 1px solid #edf1ef;
        }

        /* Tombol footer */

        .edit-modal-footer button {
            min-height: 40px;
            padding: 9px 16px;

            border-radius: 9px;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease;
        }

        .edit-modal-footer button:hover {
            transform: translateY(-1px);
        }

        .edit-modal-footer button:active {
            transform: translateY(0);
        }

        /* Animasi */

        @keyframes editModalFade {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes editModalSlide {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.985);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Responsive */

        @media (max-width: 850px) {
            .edit-modal {
                padding: 14px;
            }

            .edit-modal-content {
                max-height: 94vh;
                border-radius: 16px;
            }

            .edit-modal-header {
                padding: 18px 20px;
            }

            #edit-form {
                padding: 20px;
            }

            .edit-form-top,
            .edit-sections {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .edit-modal {
                padding: 8px;
            }

            .edit-modal-content {
                border-radius: 14px;
            }

            .edit-modal-header {
                padding: 16px;
            }

            .edit-modal-header h2 {
                font-size: 18px;
            }

            #edit-form {
                padding: 16px;
            }

            .edit-section {
                padding: 16px;
            }

            .edit-modal-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .edit-modal-footer button {
                width: 100%;
            }
        }

        .history-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-top: 18px;
            padding: 14px 4px 4px;
        }

        .pagination-info {
            color: #6F7D79;
            font-size: 13px;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .per-page-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .per-page-form label,
        .per-page-form span {
            color: #53615D;
            font-size: 13px;
        }

        .per-page-form select {
            min-width: 70px;
            height: 36px;
            padding: 0 30px 0 10px;
            border: 1px solid #D5DEDB;
            border-radius: 6px;
            background: #FFFFFF;
            color: #24312F;
            font-size: 13px;
            cursor: pointer;
            outline: none;
        }

        .per-page-form select:focus {
            border-color: #286963;
        }

        .pagination-links {
            display: flex;
            align-items: center;
        }

        .pagination-links nav {
            display: flex;
            align-items: center;
        }

        .pagination-links nav>div:first-child {
            display: none;
        }

        .pagination-links svg {
            width: 16px;
            height: 16px;
        }

        .pagination-links a,
        .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border: 1px solid #D5DEDB;
            background: #FFFFFF;
            color: #53615D;
            font-size: 13px;
            text-decoration: none;
        }

        .pagination-links a:hover {
            background: #EEF5F3;
            color: #286963;
        }

        .pagination-links span[aria-current="page"] {
            background: #286963;
            border-color: #286963;
            color: #FFFFFF;
        }

        .pagination-links a:first-child,
        .pagination-links span:first-child {
            border-radius: 6px 0 0 6px;
        }

        .pagination-links a:last-child,
        .pagination-links span:last-child {
            border-radius: 0 6px 6px 0;
        }

        @media (max-width: 768px) {
            .history-pagination {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination-controls {
                width: 100%;
                justify-content: space-between;
            }
        }

        .input-error {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .edit-field-error {
            display: none;
            margin-top: 5px;
            color: #dc3545;
            font-size: 12px;
        }

        /* =========================================================
                                                                                                                   DASHBOARD REDESIGN
                                                                                                                   ========================================================= */

        .dashboard-header {
            position: relative;
            margin-bottom: 30px;
            padding: 8px 2px 4px;
        }

        .dashboard-header h1 {
            margin: 0;
            color: #17231f;
            font-size: clamp(30px, 3vw, 38px);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -0.04em;
        }

        .dashboard-header p {
            max-width: 680px;
            margin: 9px 0 0;
            color: #71807b;
            font-size: 14px;
            line-height: 1.6;
        }


        /* =========================================================
                                                                                                                   SUMMARY
                                                                                                                   ========================================================= */

        .dashboard-summary {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;

            min-height: 128px;
            padding: 22px 22px 20px;

            border: 1px solid rgba(16, 32, 28, 0.07);
            border-radius: 18px;

            background: rgba(255, 255, 255, 0.88);

            box-shadow:
                0 10px 28px rgba(16, 32, 28, 0.05);

            transition:
                transform 180ms ease,
                box-shadow 180ms ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 16px 34px rgba(16, 32, 28, 0.08);
        }

        .summary-card::before {
            content: "";

            position: static;
            top: 0;
            left: 0;

            width: 100%;
            height: 4px;

            background: var(--brk-green);
        }

        .summary-card:nth-child(1)::before {
            background: var(--brk-red);
        }

        .summary-card:nth-child(2)::before {
            background: var(--brk-green);
        }

        .summary-card:nth-child(3)::before {
            background: var(--brk-orange);
        }

        .summary-card::after {
            content: "";

            position: static;
            right: -35px;
            bottom: -55px;

            width: 130px;
            height: 130px;

            border-radius: 50%;

            background: rgba(8, 127, 91, 0.035);
        }

        .summary-card:nth-child(1)::after {
            background: rgba(198, 40, 40, 0.045);
        }

        .summary-card:nth-child(3)::after {
            background: rgba(245, 159, 0, 0.055);
        }

        .summary-label {
            position: relative;
            z-index: 1;

            color: #77837f;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .summary-value {
            position: relative;
            z-index: 1;

            margin-top: 12px;

            color: #17231f;
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .summary-card:nth-child(1) .summary-value {
            color: var(--brk-red);
        }

        .summary-card:nth-child(2) .summary-value {
            color: var(--brk-green);
        }

        .summary-card:nth-child(3) .summary-value {
            color: var(--brk-orange-dark);
        }


        /* =========================================================
                                                                                                                   HISTORY PANEL
                                                                                                                   ========================================================= */

        .history-card {
            overflow: hidden;

            border: 1px solid rgba(16, 32, 28, 0.07);
            border-radius: 20px;

            background: rgba(255, 255, 255, 0.90);

            box-shadow:
                0 12px 32px rgba(16, 32, 28, 0.055);
        }

        .history-header {
            padding: 22px 24px;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.98),
                    rgba(247, 250, 248, 0.92));

            border-bottom: 1px solid #edf1ef;
        }

        .history-header h2 {
            color: #17231f;
            font-size: 18px;
            font-weight: 850;
        }

        .history-header p {
            margin-top: 5px;
            color: #7b8783;
            font-size: 12px;
        }


        /* =========================================================
                                                                                                                   SEARCH
                                                                                                                   ========================================================= */

        .history-search {
            padding: 4px;

            border: 1px solid #e1e7e4;
            border-radius: 12px;

            background: #fff;

            box-shadow:
                0 4px 12px rgba(16, 32, 28, 0.035);
        }

        .history-search input {
            width: 270px;
            padding: 9px 10px;

            border: 0;
            border-radius: 8px;

            background: transparent;

            color: #34413e;
            font-size: 12px;
        }

        .history-search input:focus {
            border: 0;
        }

        .history-search button {
            padding: 8px 12px;

            border: 0;
            border-radius: 8px;

            color: #697671;
            background: #f3f6f4;

            transition:
                color 160ms ease,
                background 160ms ease;
        }

        .history-search button:hover {
            color: var(--brk-red);
            background: var(--brk-red-soft);
        }


        /* =========================================================
                                                                                                                   TABLE
                                                                                                                   ========================================================= */

        .history-table {
            min-width: 980px;
        }

        .history-table th {
            padding: 14px 18px;

            color: #7a8582;
            background: #f7f9f8;

            font-size: 10px;
            font-weight: 850;
            letter-spacing: 0.08em;
        }

        .history-table td {
            padding: 16px 18px;

            border-top: 1px solid #eef2f0;

            color: #34413e;
            font-size: 13px;
        }

        .history-table tbody tr {
            transition:
                background 160ms ease;
        }

        .history-table tbody tr:hover {
            background: #fbfcfb;
        }

        .document-number {
            color: #17231f;
            font-weight: 850;
            line-height: 1.7;
        }

        .document-number div {
            position: relative;
        }

        .document-number div+div {
            padding-top: 2px;
        }

        .document-type {
            padding: 6px 10px;

            border-radius: 999px;

            color: var(--brk-green-dark);
            background: var(--brk-green-soft);

            font-size: 10px;
            font-weight: 800;
        }

        .nominal {
            color: #17231f;
            font-weight: 800;
            line-height: 1.7;
        }

        .creator-name {
            color: #34413e;
            font-weight: 700;
        }

        .date-text {
            color: #71807b;
        }


        /* =========================================================
                                                                                                                   STATUS
                                                                                                                   ========================================================= */

        .status-badge {
            position: relative;

            padding: 6px 10px 6px 20px;

            border-radius: 999px;

            font-size: 10px;
            font-weight: 800;
        }

        .status-badge::before {
            content: "";

            position: static;
            left: 9px;
            top: 50%;

            width: 5px;
            height: 5px;

            border-radius: 50%;

            transform: translateY(-50%);
        }

        .status-generated {
            color: var(--brk-green-dark);
            background: var(--brk-green-soft);
        }

        .status-generated::before {
            background: var(--brk-green);
        }

        .status-active {
            color: var(--brk-orange-dark);
            background: var(--brk-orange-soft);
        }

        .status-active::before {
            background: var(--brk-orange);
        }


        /* =========================================================
                                                                                                                   ACTION
                                                                                                                   ========================================================= */

        .action-group {
            gap: 6px;
        }

        .action-button {
            min-height: 34px;
            padding: 7px 11px;

            border: 1px solid #dfe6e2;
            border-radius: 9px;

            color: #52605b;
            background: #fff;

            font-size: 10px;
            font-weight: 800;

            transition:
                transform 160ms ease,
                color 160ms ease,
                background 160ms ease,
                border-color 160ms ease,
                box-shadow 160ms ease;
        }

        .action-button:hover {
            transform: translateY(-1px);

            color: var(--brk-red);

            background: var(--brk-red-soft);

            border-color: rgba(198, 40, 40, 0.16);

            box-shadow:
                0 4px 10px rgba(198, 40, 40, 0.06);
        }


        /* =========================================================
                                                                                                                   PAGINATION
                                                                                                                   ========================================================= */

        .history-pagination {
            margin-top: 16px;
            padding: 4px 2px;
        }

        .pagination-info {
            color: #7a8582;
            font-size: 12px;
        }

        .pagination-controls {
            gap: 12px;
        }

        .per-page-form {
            gap: 7px;
        }

        .per-page-form label,
        .per-page-form span {
            color: #71807b;
            font-size: 12px;
        }

        .per-page-form select {
            height: 34px;
            min-width: 62px;

            border: 1px solid #dce4e0;
            border-radius: 9px;

            background: #fff;

            color: #34413e;
            font-size: 12px;
        }

        .pagination-links a,
        .pagination-links span {
            min-width: 32px;
            height: 32px;

            border-color: #dce4e0;

            font-size: 12px;
        }

        .pagination-links a:hover {
            color: var(--brk-green);
            background: var(--brk-green-soft);
        }

        .pagination-links span[aria-current="page"] {
            color: #fff;
            background: var(--brk-green);
            border-color: var(--brk-green);
        }


        /* =========================================================
                                                                                                                   EMPTY STATE
                                                                                                                   ========================================================= */

        .empty-history {
            padding: 70px 20px;

            color: #7a8582;
        }

        .empty-history strong {
            color: #34413e;
            font-size: 16px;
        }


        /* =========================================================
                                                                                                                   ANIMATION
                                                                                                                   ========================================================= */

        .dashboard-header,
        .summary-card,
        .history-card,
        .history-pagination {
            animation: dashboardFadeUp 420ms ease both;
        }

        .summary-card:nth-child(1) {
            animation-delay: 60ms;
        }

        .summary-card:nth-child(2) {
            animation-delay: 110ms;
        }

        .summary-card:nth-child(3) {
            animation-delay: 160ms;
        }

        .history-card {
            animation-delay: 220ms;
        }

        .history-pagination {
            animation-delay: 280ms;
        }

        @keyframes dashboardFadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .dashboard-header,
            .summary-card,
            .history-card,
            .history-pagination {
                animation: none;
            }

            .summary-card,
            .action-button {
                transition: none;
            }
        }


        /* =========================================================
                                                                                                                   MOBILE
                                                                                                                   ========================================================= */

        @media (max-width: 900px) {
            .dashboard-summary {
                grid-template-columns: 1fr;
            }

            .summary-card {
                min-height: 110px;
            }

            .history-header {
                gap: 14px;
            }

            .history-search {
                width: 100%;
            }

            .history-search input {
                width: 100%;
                flex: 1;
            }
        }

        /* =========================================================
                                                                                                           DASHBOARD TABLE REFINEMENT
                                                                                                           ========================================================= */

        .history-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            min-width: 1120px;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }

        /* Header */

        .history-table thead th {
            padding: 14px 14px;
            background: #f7f9f8;
            color: #667672;
            border-top: 1px solid #edf1ef;
            border-bottom: 1px solid #e5ebe8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.05em;
            line-height: 1.2;
            text-transform: uppercase;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .history-table thead th:first-child {
            padding-left: 14px;
        }

        /* Lebar kolom */

        .history-table th:nth-child(1),
        .history-table td:nth-child(1) {
            width: 9%;
        }

        .history-table th:nth-child(2),
        .history-table td:nth-child(2) {
            width: 10%;
        }

        .history-table th:nth-child(3),
        .history-table td:nth-child(3) {
            width: 18%;
        }

        .history-table th:nth-child(4),
        .history-table td:nth-child(4) {
            width: 14%;
        }

        .history-table th:nth-child(5),
        .history-table td:nth-child(5) {
            width: 11%;
        }

        .history-table th:nth-child(6),
        .history-table td:nth-child(6) {
            width: 12%;
        }

        .history-table th:nth-child(7),
        .history-table td:nth-child(7) {
            width: 12%;
        }

        .history-table th:nth-child(8),
        .history-table td:nth-child(8) {
            width: 14%;
            min-width: 155px;
        }

        /* Isi */

        .history-table tbody td {
            padding: 15px 14px;
            background: #ffffff;
            border-bottom: 1px solid #edf1ef;
            color: #263532;
            font-size: 12px;
            line-height: 1.35;
            vertical-align: middle;
        }

        .history-table tbody tr {
            transition: background-color 0.18s ease;
        }

        .history-table tbody tr:hover td {
            background: #fbfcfb;
        }

        .history-table tbody td:first-child {
            padding-left: 20px;
        }

        /* Nomor PB */

        .history-table tbody td:first-child {
            color: #16211f;
            font-weight: 800;
            white-space: nowrap;
            word-break: keep-all;
            overflow-wrap: normal;
        }

        /* Jenis Top Up */

        .history-table tbody td:nth-child(2) {
            color: #44534f;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Jenis PB */

        /* Jenis PB */

        .history-table tbody td:nth-child(3) {
            padding-right: 10px;
            color: #34443f;
            font-weight: 600;
        }

        .history-table tbody td:nth-child(3) span,
        .history-table tbody td:nth-child(3) .document-type-badge {
            display: inline;
            padding: 0;
            border-radius: 0;
            background: transparent;
            color: #34443f;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
            white-space: normal;
            overflow-wrap: break-word;
        }

        /* Nominal */

        .history-table tbody td:nth-child(4) {
            color: #17211f;
            font-weight: 800;
            white-space: nowrap;
        }

        .history-table tbody td:nth-child(4)>div {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* Dibuat oleh */

        .history-table tbody td:nth-child(5) {
            color: #263532;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Tanggal */

        .history-table tbody td:nth-child(6) {
            color: #687773;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Status umum */

        .history-table tbody td:nth-child(7) span.status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 32px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
        }

        /* Sudah Generate */

        .history-table tbody td:nth-child(7) .status-badge.generated {
            background: #e8f6f1;
            color: #087f5b;
        }

        .history-table tbody td:nth-child(7) .status-badge.generated .status-dot {
            background: #087f5b;
        }

        /* Belum Generate */

        .history-table tbody td:nth-child(7) .status-badge.pending {
            background: #fff4d6;
            color: #d98200;
        }

        .history-table tbody td:nth-child(7) .status-badge.pending .status-dot {
            background: #f59f00;
        }

        /* Titik status */

        .history-table tbody td:nth-child(7) .status-dot {
            position: static;
            display: inline-block;
            width: 6px;
            height: 6px;
            min-width: 6px;
            margin: 0;
            padding: 0;
            border-radius: 50%;
        }

        /* Aksi */

        .history-table tbody td:last-child {
            min-width: 155px;
            padding-left: 10px;
            padding-right: 18px;
            white-space: nowrap;
        }

        .history-table tbody td:last-child>div,
        .history-table tbody td:last-child .action-buttons {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: nowrap;
        }

        .history-table tbody td:last-child button,
        .history-table tbody td:last-child a {
            flex: 0 0 auto;
            min-width: 0;
            min-height: 36px;
            padding: 8px 11px;
            border: 1px solid #dce5e1;
            border-radius: 9px;
            background: #ffffff;
            color: #34443f;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
            cursor: pointer;
            transition:
                transform 0.18s ease,
                border-color 0.18s ease,
                background-color 0.18s ease,
                color 0.18s ease;
        }

        .history-table tbody td:last-child button:hover,
        .history-table tbody td:last-child a:hover {
            transform: translateY(-1px);
            border-color: #087f5b;
            background: #e8f6f1;
            color: #087f5b;
        }

        .history-table tbody td:last-child button:active,
        .history-table tbody td:last-child a:active {
            transform: translateY(0);
        }

        /* Mobile */

        @media (max-width: 1100px) {
            .history-table {
                min-width: 1120px;
            }

            .history-table thead th,
            .history-table tbody td {
                padding-left: 10px;
                padding-right: 10px;
            }

            .history-table tbody td:first-child {
                padding-left: 14px;
            }
        }

        .history-table th,
        .history-table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Nominal tetap rapi jika terdiri dari dua baris */

        .history-table tbody td:nth-child(4)>div {
            align-items: center;
        }

        /* Aksi tetap berada di tengah */

        .history-table tbody td:last-child>div,
        .history-table tbody td:last-child .action-buttons {
            justify-content: center;
        }

        /* Status di tengah */

        .history-table tbody td:nth-child(7) {
            text-align: center;
        }

        /* Jenis PB di tengah */

        .history-table tbody td:nth-child(3) {
            text-align: center;
        }

        /* =========================================================
                                   DASHBOARD MOTION POLISH
                                   ========================================================= */

        .dashboard-header {
            animation: dashboardHeaderIn 520ms cubic-bezier(.22, 1, .36, 1) both;
        }

        .dashboard-header h1 {
            position: relative;
            display: inline-block;
        }

        .dashboard-header h1::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 42px;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg,
                    var(--brk-red),
                    var(--brk-orange),
                    var(--brk-green));
            transform-origin: left;
            animation: dashboardAccentIn 700ms 180ms cubic-bezier(.22, 1, .36, 1) both;
        }


        /* =========================================================
                                   SUMMARY CARD
                                   ========================================================= */

        .summary-card {
            isolation: isolate;
            transform: translateZ(0);
            transition:
                transform 220ms cubic-bezier(.22, 1, .36, 1),
                box-shadow 220ms ease,
                border-color 220ms ease;
        }

        .summary-card::before {
            position: absolute;
            inset: 0 0 auto;
            z-index: -1;
            width: 100%;
            height: 3px;
            transform-origin: left;
            transform: scaleX(.35);
            transition: transform 320ms cubic-bezier(.22, 1, .36, 1);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            border-color: rgba(8, 127, 91, .12);
            box-shadow:
                0 18px 38px rgba(16, 32, 28, .09),
                0 4px 12px rgba(16, 32, 28, .04);
        }

        .summary-card:hover::before {
            transform: scaleX(1);
        }

        .summary-card::after {
            position: absolute;
            right: -42px;
            bottom: -58px;
            z-index: -1;
            pointer-events: none;
            transition:
                transform 420ms cubic-bezier(.22, 1, .36, 1),
                opacity 420ms ease;
        }

        .summary-card:hover::after {
            transform: scale(1.12) translate(-8px, -6px);
            opacity: .9;
        }

        .summary-label {
            transition: color 180ms ease;
        }

        .summary-card:hover .summary-label {
            color: #52625d;
        }

        .summary-value {
            transition:
                transform 220ms cubic-bezier(.22, 1, .36, 1);
        }

        .summary-card:hover .summary-value {
            transform: translateX(3px);
        }


        /* =========================================================
                                   HISTORY CARD
                                   ========================================================= */

        .history-card {
            position: relative;
            transition:
                box-shadow 240ms ease,
                border-color 240ms ease;
        }

        .history-card:hover {
            border-color: rgba(8, 127, 91, .10);
            box-shadow:
                0 18px 42px rgba(16, 32, 28, .07),
                0 4px 14px rgba(16, 32, 28, .035);
        }

        .history-header {
            position: relative;
        }

        .history-header::after {
            content: "";
            position: absolute;
            left: 24px;
            bottom: -1px;
            width: 54px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg,
                    var(--brk-green),
                    var(--brk-orange));
        }


        /* =========================================================
                                   SEARCH
                                   ========================================================= */

        .history-search {
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                transform 180ms ease;
        }

        .history-search:focus-within {
            border-color: rgba(8, 127, 91, .22);
            box-shadow:
                0 0 0 3px rgba(8, 127, 91, .06),
                0 6px 16px rgba(16, 32, 28, .045);
            transform: translateY(-1px);
        }

        .history-search input::placeholder {
            color: #9aa5a1;
            transition: color 180ms ease;
        }

        .history-search input:focus::placeholder {
            color: #b2bbb8;
        }


        /* =========================================================
                                   TABLE
                                   ========================================================= */

        .history-table tbody tr {
            transition:
                background-color 180ms ease,
                transform 180ms ease;
        }

        .history-table tbody tr:hover td {
            background: #fbfdfc;
        }

        .history-table tbody tr:hover .document-number,
        .history-table tbody tr:hover .creator-name {
            color: #087f5b;
        }

        .history-table tbody tr:hover .nominal {
            color: #17231f;
        }


        /* =========================================================
                                   ACTION BUTTON
                                   ========================================================= */

        .history-table tbody td:last-child button,
        .history-table tbody td:last-child a {
            position: relative;
            overflow: hidden;
        }

        .history-table tbody td:last-child button::after,
        .history-table tbody td:last-child a::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg,
                    transparent 20%,
                    rgba(255, 255, 255, .65) 50%,
                    transparent 80%);
            transform: translateX(-120%);
            transition: transform 420ms ease;
            pointer-events: none;
        }

        .history-table tbody td:last-child button:hover::after,
        .history-table tbody td:last-child a:hover::after {
            transform: translateX(120%);
        }


        /* =========================================================
                                   STATUS
                                   ========================================================= */

        .history-table tbody td:nth-child(7) .status-badge {
            transition:
                transform 180ms ease,
                box-shadow 180ms ease;
        }

        .history-table tbody tr:hover td:nth-child(7) .status-badge {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(16, 32, 28, .05);
        }


        /* =========================================================
           PAGINATION
           ========================================================= */

        .history-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;

            margin-top: 18px;
            padding: 6px 2px 2px;
        }

        .pagination-per-page {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #71807b;
            font-size: 13px;
            white-space: nowrap;
        }

        .per-page-form {
            margin: 0;
        }

        .per-page-form select {
            width: 68px;
            height: 36px;

            padding: 0 30px 0 11px;

            border: 1px solid #dce4e0;
            border-radius: 9px;

            background: #fff;

            color: #34413e;
            font-size: 13px;
            font-weight: 600;

            cursor: pointer;

            transition:
                border-color 160ms ease,
                box-shadow 160ms ease;
        }

        .per-page-form select:hover {
            border-color: #b9cbc4;
        }

        .per-page-form select:focus {
            outline: none;

            border-color: var(--brk-green);

            box-shadow:
                0 0 0 3px rgba(8, 127, 91, 0.10);
        }

        .pagination-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .pagination-info {
            color: #71807b;
            font-size: 13px;
            white-space: nowrap;
        }

        .pagination-info strong {
            color: #34413e;
            font-weight: 700;
        }

        .pagination-links {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 36px;
            height: 36px;

            padding: 0;

            border: 1px solid #dce4e0;
            border-radius: 9px;

            background: #fff;

            color: #52615d;

            font-size: 13px;
            font-weight: 600;

            text-decoration: none;

            transition:
                color 160ms ease,
                background-color 160ms ease,
                border-color 160ms ease,
                transform 160ms ease;
        }

        .pagination-button:hover {
            color: var(--brk-green);

            background: var(--brk-green-soft);

            border-color: rgba(8, 127, 91, 0.22);

            transform: translateY(-1px);
        }

        .pagination-button.active {
            color: #fff;

            background: var(--brk-green);

            border-color: var(--brk-green);

            box-shadow:
                0 4px 10px rgba(8, 127, 91, 0.16);
        }

        .pagination-button.disabled {
            color: #b7c0bd;

            background: #f7f9f8;

            border-color: #e7ecea;

            cursor: not-allowed;
        }

        .pagination-button.disabled:hover {
            transform: none;
        }

        @media (max-width: 900px) {
            .history-pagination {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .pagination-per-page {
                justify-content: flex-start;
            }

            .pagination-right {
                justify-content: space-between;
                gap: 12px;
            }
        }

        @media (max-width: 600px) {
            .pagination-right {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination-links {
                width: 100%;
            }

            .pagination-button {
                width: 34px;
                height: 34px;
            }
        }


        /* =========================================================
                                   ENTRANCE MOTION
                                   ========================================================= */

        @keyframes dashboardHeaderIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes dashboardAccentIn {
            from {
                opacity: 0;
                transform: scaleX(0);
            }

            to {
                opacity: 1;
                transform: scaleX(1);
            }
        }


        /* =========================================================
                                   REDUCED MOTION
                                   ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .dashboard-header,
            .dashboard-header h1::after {
                animation: none;
            }

            .summary-card,
            .summary-card::after,
            .summary-card::before,
            .summary-value,
            .history-card,
            .history-search,
            .history-table tbody tr,
            .history-table tbody td:last-child button,
            .history-table tbody td:last-child a,
            .history-table tbody td:last-child button::after,
            .history-table tbody td:last-child a::after,
            .pagination-links a,
            .pagination-links span,
            .per-page-form select {
                transition: none;
            }
        }
    </style>

    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ auth()->user()->name }}. Kelola dan pantau dokumen PB dari halaman ini.</p>
    </div>

    <div class="dashboard-summary">
        <div class="summary-card">
            <div class="summary-label">Total Dokumen PB</div>
            <div class="summary-value">{{ $totalDocuments }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Total Debet Rekening</div>
            <div class="summary-value">{{ $totalPb01 }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Total Penerusan BI</div>
            <div class="summary-value">{{ $totalPb02 }}</div>
        </div>
    </div>

    <div class="history-card">
        <div class="history-header">
            <div>
                <h2>Riwayat Dokumen PB</h2>
                <p>Daftar dokumen PB yang pernah dibuat oleh seluruh staff.</p>
            </div>

            <div class="history-search">
                <input type="text" id="history-search-input" placeholder="Cari No. PB, jenis top up, atau staff..."
                    autocomplete="off">

                <button type="button" id="history-search-reset">
                    Reset
                </button>
            </div>
        </div>

        @if ($documents->isEmpty())
            <div class="empty-history">
                <strong>Belum ada riwayat dokumen PB.</strong>
                Dokumen yang sudah dibuat akan muncul di sini.
            </div>
        @else
            <div class="history-table-wrapper">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>No. PB</th>
                            <th>Jenis Top Up</th>
                            <th>PB</th>
                            <th>Nominal</th>
                            <th>Dibuat Oleh</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($documents as $document)
                                    @php
                                        $sections = $document->group_documents
                                            ->flatMap(function ($groupDocument) {
                                                return $groupDocument->sections;
                                            });

                                        $debit = $document->group_documents
                                            ->flatMap(function ($groupDocument) {
                                                return $groupDocument->sections;
                                            })
                                            ->flatMap(function ($section) {
                                                return $section->entries;
                                            })
                                            ->firstWhere('entry_type', 'debet');

                                        $hasPb01 = $sections->contains('section_type', 'pb01');
                                        $hasPb02 = $sections->contains('section_type', 'pb02');

                                        $documentType = match (true) {
                                            $hasPb01 && $hasPb02 => 'Debet Rekening & Penerusan BI',
                                            $hasPb01 => 'Mendebet Rekening',
                                            $hasPb02 => 'Penerusan BI',
                                            default => '-',
                                        };
                                    @endphp

                                    <tr data-search="{{ strtolower(
                                $document->group_documents
                                    ->flatMap(function ($groupDocument) {
                                        return $groupDocument->sections;
                                    })
                                    ->flatMap(function ($section) {
                                        return $section->entries;
                                    })
                                    ->map(function ($entry) {
                                        return implode(' ', [
                                            $entry->amount,
                                            number_format(
                                                (float) $entry->amount,
                                                0,
                                                ',',
                                                '.'
                                            ),
                                            $entry->date_from?->format('Y-m-d'),
                                            $entry->date_until?->format('Y-m-d'),
                                        ]);
                                    })
                                    ->implode(' ') . ' ' .
                                $document->group_documents
                                    ->pluck('document_number')
                                    ->implode(' ') . ' ' .
                                ($document->topupType?->name ?? '') . ' ' .
                                $documentType . ' ' .
                                ($document->creator?->name ?? '') . ' ' .
                                ($document->signature_date?->format('Y-m-d') ?? '')
                            ) }}">
                                        <td>
                                            @php
                                                $pb01Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb01');
                                                    });

                                                $pb02Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb02');
                                                    });
                                            @endphp

                                            <div class="document-number">
                                                @if ($pb01Document)
                                                    <div>
                                                        {{ $pb01Document->document_number }}
                                                    </div>
                                                @endif

                                                @if ($pb02Document)
                                                    <div>
                                                        {{ $pb02Document->document_number }}
                                                    </div>
                                                @endif

                                                @if (!$pb01Document && !$pb02Document)
                                                    -
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            {{ $document->topupType?->name ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="document-type">
                                                {{ $documentType }}
                                            </span>
                                        </td>

                                        <td>
                                            @php
                                                $pb01Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb01');
                                                    });

                                                $pb02Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb02');
                                                    });

                                                $pb01Debit = $pb01Document?->sections
                                                    ->flatMap(function ($section) {
                                                        return $section->entries;
                                                    })
                                                    ->firstWhere('entry_type', 'debet');

                                                $pb02Debit = $pb02Document?->sections
                                                    ->flatMap(function ($section) {
                                                        return $section->entries;
                                                    })
                                                    ->firstWhere('entry_type', 'debet');
                                            @endphp

                                            <div class="nominal">
                                                @if ($pb01Debit)
                                                    <div>
                                                        Rp {{ number_format((float) ($pb01Debit->amount ?? 0), 2, ',', '.') }}
                                                    </div>
                                                @endif

                                                @if ($pb02Debit)
                                                    <div>
                                                        Rp {{ number_format((float) ($pb02Debit->amount ?? 0), 2, ',', '.') }}
                                                    </div>
                                                @endif

                                                @if (!$pb01Debit && !$pb02Debit)
                                                    -
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="creator-name">
                                                {{ $document->creator?->name ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="date-text">
                                                {{ $document->signature_date?->translatedFormat('d F Y') ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($document->generated_at)
                                                <span class="status-badge status-generated">
                                                    Sudah Digenerate
                                                </span>
                                            @else
                                                <span class="status-badge status-active">
                                                    Belum Digenerate
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="action-group">
                                                <button type="button" class="action-button" onclick="openEditModal({{ $document->id }})">
                                                    Edit
                                                </button>

                                                <button type="button" class="action-button" onclick="downloadDocument({{ $document->id }})">
                                                    Download
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                        @endforeach
                        <tr id="no-search-result" style="display: none;">
                            <td colspan="8" style="padding: 35px 20px; text-align: center; color: #7A8582;">
                                Tidak ada dokumen yang sesuai dengan pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="history-pagination">

        <div class="pagination-per-page">
            <span>Tampilkan</span>

            <form method="GET" action="{{ route('dashboard') }}" class="per-page-form">
                @if ($search !== '')
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif

                <select id="per-page" name="per_page" onchange="this.form.submit()">
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>
                        25
                    </option>

                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>
                        50
                    </option>

                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>
                        100
                    </option>
                </select>
            </form>

            <span>data</span>
        </div>

        <div class="pagination-right">

            <div class="pagination-info">
                Menampilkan
                <strong>{{ $documents->firstItem() ?? 0 }}</strong>
                sampai
                <strong>{{ $documents->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $documents->total() }}</strong>
                data
            </div>

            <div class="pagination-links">

                @if ($documents->onFirstPage())
                    <span class="pagination-button disabled">
                        ‹
                    </span>
                @else
                    <a href="{{ $documents->previousPageUrl() }}" class="pagination-button" aria-label="Halaman sebelumnya">
                        ‹
                    </a>
                @endif

                @foreach ($documents->getUrlRange(
                        max(1, $documents->currentPage() - 2),
                        min($documents->lastPage(), $documents->currentPage() + 2)
                    ) as $page => $url)

                    @if ($page == $documents->currentPage())
                        <span class="pagination-button active" aria-current="page">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="pagination-button">
                            {{ $page }}
                        </a>
                    @endif

                @endforeach

                @if ($documents->hasMorePages())
                    <a href="{{ $documents->nextPageUrl() }}" class="pagination-button" aria-label="Halaman berikutnya">
                        ›
                    </a>
                @else
                    <span class="pagination-button disabled">
                        ›
                    </span>
                @endif

            </div>

        </div>

    </div>

    <div id="edit-modal" class="edit-modal">
        <div class="edit-modal-content">

            <div class="edit-modal-header">
                <div>
                    <h2>Edit Dokumen PB</h2>
                    <p id="edit-document-type"></p>
                </div>

                <button type="button" class="edit-modal-close" onclick="closeEditModal()">
                    &times;
                </button>
            </div>

            <form id="edit-form">

                <input type="hidden" id="edit-document-id">

                <div class="edit-form-top">

                    <div class="edit-field">
                        <label>Tanggal</label>
                        <input type="text" id="edit-date-range" readonly>

                        <input type="hidden" id="edit-date-from" name="date_from">
                        <input type="hidden" id="edit-date-until" name="date_until">
                    </div>
                </div>

                <div class="edit-sections">

                    <div class="edit-section" id="edit-section-pb01">

                        <h3>Mendebet Rekening</h3>

                        <div class="edit-field">
                            <label>No. PB</label>
                            <input type="text" id="edit-pb01-number" name="pb01_number" required>
                        </div>

                        <h4>Debet</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb01-debit-account-number" name="pb01_debit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb01-debit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb01-debit-account-name" name="pb01_debit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb01-debit-amount" name="pb01_debit_amount" inputmode="decimal"
                                required>

                            <p id="edit-pb01-debit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb01-debit-description" name="pb01_debit_description" rows="3"></textarea>
                        </div>


                        <h4>Kredit</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb01-credit-account-number" name="pb01_credit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb01-credit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb01-credit-account-name" name="pb01_credit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb01-credit-amount" name="pb01_credit_amount" inputmode="decimal"
                                required>

                            <p id="edit-pb01-credit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb01-credit-description" name="pb01_credit_description" rows="3"></textarea>
                        </div>

                    </div>


                    <div class="edit-section" id="edit-section-pb02">

                        <h3>Penerusan BI</h3>
                        <div class="edit-field">
                            <label>No. PB</label>
                            <input type="text" id="edit-pb02-number" name="pb02_number" required>
                        </div>

                        <h4>Debet</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb02-debit-account-number" name="pb02_debit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb02-debit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb02-debit-account-name" name="pb02_debit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb02-debit-amount" name="pb02_debit_amount" inputmode="decimal"
                                required>

                            <p id="edit-pb02-debit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb02-debit-description" name="pb02_debit_description" rows="3"></textarea>
                        </div>


                        <h4>Kredit</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb02-credit-account-number" name="pb02_credit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb02-credit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb02-credit-account-name" name="pb02_credit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb02-credit-amount" name="pb02_credit_amount" inputmode="decimal"
                                required>

                            <p id="edit-pb02-credit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb02-credit-description" name="pb02_credit_description" rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="edit-modal-footer">
                    <button type="button" class="action-button" onclick="closeEditModal()">
                        Batal
                    </button>

                    <button type="submit" class="action-button">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            async function openEditModal(documentId) {
                const modal = document.getElementById('edit-modal');

                try {
                    const response = await fetch(
                        `/documents/${documentId}/edit`
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data dokumen.');
                    }

                    const data = await response.json();

                    console.log('DATA EDIT:', data);

                    document.getElementById('edit-document-id').value =
                        data.id;

                    const documents = data.documents ?? [];

                    const pb01 = documents.find(
                        document => document.section_type === 'pb01'
                    );

                    const pb02 = documents.find(
                        document => document.section_type === 'pb02'
                    );

                    const pb01Section = document.getElementById(
                        'edit-section-pb01'
                    );

                    const pb02Section = document.getElementById(
                        'edit-section-pb02'
                    );

                    function setSectionState(section, enabled) {
                        if (!section) {
                            return;
                        }

                        section.style.display = enabled ? '' : 'none';

                        section
                            .querySelectorAll('input, select, textarea')
                            .forEach(function (input) {
                                input.disabled = !enabled;
                            });
                    }

                    setSectionState(pb01Section, !!pb01);
                    setSectionState(pb02Section, !!pb02);

                    if (pb01) {
                        document.getElementById(
                            'edit-pb01-number'
                        ).value = pb01.document_number ?? '';
                    }

                    if (pb02) {
                        document.getElementById(
                            'edit-pb02-number'
                        ).value = pb02.document_number ?? '';
                    }

                    function fillEntry(prefix, entry) {
                        if (!entry) {
                            return;
                        }

                        document.getElementById(
                            `edit-${prefix}-account-number`
                        ).value = entry.account_number ?? '';

                        document.getElementById(
                            `edit-${prefix}-account-name`
                        ).value = entry.account_name ?? '';

                        const amountInput = document.getElementById(
                            `edit-${prefix}-amount`
                        );

                        if (amountInput) {
                            amountInput.value =
                                entry.amount !== null && entry.amount !== undefined
                                    ? String(entry.amount)
                                    : '';
                        }

                        document.getElementById(
                            `edit-${prefix}-description`
                        ).value = entry.description ?? '';
                    }

                    const pb01Entries = pb01?.entries ?? [];

                    const pb01Debit = pb01Entries.find(
                        entry => entry.entry_type === 'debet'
                    );

                    const pb01Credit = pb01Entries.find(
                        entry => entry.entry_type === 'kredit'
                    );

                    fillEntry(
                        'pb01-debit',
                        pb01Debit
                    );

                    fillEntry(
                        'pb01-credit',
                        pb01Credit
                    );


                    const pb02Entries = pb02?.entries ?? [];

                    const pb02Debit = pb02Entries.find(
                        entry => entry.entry_type === 'debet'
                    );

                    const pb02Credit = pb02Entries.find(
                        entry => entry.entry_type === 'kredit'
                    );

                    fillEntry(
                        'pb02-debit',
                        pb02Debit
                    );

                    fillEntry(
                        'pb02-credit',
                        pb02Credit
                    );


                    const dateEntry =
                        pb01Debit ??
                        pb01Credit ??
                        pb02Debit ??
                        pb02Credit;

                    if (dateEntry) {
                        const start = dateEntry.date_from ?? '';
                        const end = dateEntry.date_until ?? '';

                        document.getElementById('edit-date-from').value = start;
                        document.getElementById('edit-date-until').value = end;

                        const editDateRange = document.getElementById('edit-date-range');

                        editDateRange.value =
                            end && end !== start
                                ? `${start} s.d. ${end}`
                                : start;
                    }

                    modal.classList.add('show');

                } catch (error) {
                    console.error(error);
                    alert('Data dokumen gagal dimuat.');
                }
            }

            async function downloadDocument(documentId) {
                try {
                    const response = await fetch(
                        `/documents/${documentId}/download`
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengunduh dokumen.');
                    }

                    const blob = await response.blob();

                    const url = window.URL.createObjectURL(blob);

                    const link = document.createElement('a');
                    link.href = url;

                    const contentDisposition =
                        response.headers.get('Content-Disposition');

                    let filename = `PB-${documentId}.xlsx`;

                    if (contentDisposition) {
                        const match =
                            contentDisposition.match(/filename="?([^"]+)"?/);

                        if (match) {
                            filename = match[1];
                        }
                    }

                    link.download = filename;

                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                    window.URL.revokeObjectURL(url);

                    window.location.reload();

                } catch (error) {
                    console.error(error);

                    alert('Dokumen gagal di-download.');
                }
            }

            function setupEditValidation() {
                const accountInputs = [
                    {
                        input: document.getElementById(
                            'edit-pb01-debit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb01-debit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb01-credit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb01-credit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-debit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb02-debit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-credit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb02-credit-account-number-error'
                        ),
                    },
                ];

                accountInputs.forEach(function ({ input, error }) {
                    if (!input || !error) {
                        return;
                    }

                    input.addEventListener('input', function () {
                        const value = input.value.trim();

                        if (value === '') {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                            return;
                        }

                        if (!/^[0-9]+$/.test(value)) {
                            input.classList.add('input-error');
                            error.textContent =
                                'Nomor rekening hanya boleh berisi angka.';
                            error.style.display = 'block';
                        } else {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                        }
                    });
                });

                const amountInputs = [
                    {
                        input: document.getElementById(
                            'edit-pb01-debit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb01-debit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb01-credit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb01-credit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-debit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb02-debit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-credit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb02-credit-amount-error'
                        ),
                    },
                ];

                amountInputs.forEach(function ({ input, error }) {
                    if (!input || !error) {
                        return;
                    }

                    input.addEventListener('input', function () {
                        const value = input.value.trim();

                        if (value === '') {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                            return;
                        }

                        if (!/^[0-9]*([.,][0-9]*)?$/.test(value)) {
                            input.classList.add('input-error');
                            error.textContent =
                                'Nominal hanya boleh berupa angka, titik, atau koma.';
                            error.style.display = 'block';
                        } else {
                            input.classList.remove('input-error');
                            error.style.display = 'none';
                        }
                    });
                });
            }

            function closeEditModal() {
                document.getElementById('edit-modal')
                    .classList.remove('show');
            }

            document.addEventListener('DOMContentLoaded', function () {
                setupEditValidation();

                const input =
                    document.getElementById('history-search-input');

                const resetButton =
                    document.getElementById('history-search-reset');

                const rows =
                    document.querySelectorAll(
                        '.history-table tbody tr[data-search]'
                    );

                const noResult =
                    document.getElementById('no-search-result');

                if (input && resetButton && noResult) {

                    function filterHistory() {

                        const keyword =
                            input.value.trim().toLowerCase();

                        let visibleRows = 0;

                        rows.forEach(function (row) {

                            const searchableText =
                                row.dataset.search || '';

                            const isMatch =
                                searchableText.includes(keyword);

                            row.style.display =
                                isMatch ? '' : 'none';

                            if (isMatch) {
                                visibleRows++;
                            }
                        });

                        noResult.style.display =
                            visibleRows === 0
                                ? ''
                                : 'none';
                    }

                    input.addEventListener(
                        'input',
                        filterHistory
                    );

                    resetButton.addEventListener(
                        'click',
                        function () {
                            input.value = '';
                            filterHistory();
                            input.focus();
                        }
                    );
                }

                const editForm =
                    document.getElementById('edit-form');

                if (editForm) {

                    editForm.addEventListener(
                        'submit',
                        async function (event) {

                            event.preventDefault();

                            const documentId =
                                document.getElementById(
                                    'edit-document-id'
                                ).value;

                            const formData =
                                new FormData(editForm);

                            formData.append(
                                '_method',
                                'PUT'
                            );

                            try {

                                const response =
                                    await fetch(
                                        `/documents/${documentId}`,
                                        {
                                            method: 'POST',

                                            headers: {
                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .getAttribute(
                                                            'content'
                                                        ),

                                                'Accept':
                                                    'application/json',
                                            },

                                            body: formData,
                                        }
                                    );

                                if (!response.ok) {

                                    const data =
                                        await response
                                            .json()
                                            .catch(
                                                () => null
                                            );

                                    if (data?.errors) {

                                        const messages =
                                            Object.values(
                                                data.errors
                                            )
                                                .flat()
                                                .join('\n');

                                        alert(messages);

                                        return;
                                    }

                                    throw new Error(
                                        'Gagal menyimpan perubahan.'
                                    );
                                }

                                window.location.href =
                                    '/dashboard';

                            } catch (error) {

                                console.error(error);

                                alert(
                                    'Perubahan gagal disimpan.'
                                );
                            }
                        }
                    );
                }
            });
        </script>
    @endpush
@endsection