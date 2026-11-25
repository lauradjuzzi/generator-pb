import './bootstrap';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";

document.addEventListener('DOMContentLoaded', function () {

    const dateRange = document.getElementById('date_range');
    const dateFrom = document.getElementById('date_from');
    const dateUntil = document.getElementById('date_until');

    if (dateRange && dateFrom && dateUntil) {
        flatpickr(dateRange, {
            mode: 'range',
            dateFormat: 'd-m-Y',
            allowInput: false,

            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    dateFrom.value = instance.formatDate(
                        selectedDates[0],
                        'Y-m-d'
                    );

                    dateUntil.value = '';
                } else if (selectedDates.length === 2) {
                    dateFrom.value = instance.formatDate(
                        selectedDates[0],
                        'Y-m-d'
                    );

                    dateUntil.value = instance.formatDate(
                        selectedDates[1],
                        'Y-m-d'
                    );
                } else {
                    dateFrom.value = '';
                    dateUntil.value = '';
                }
            }
        });
    }


    const editDateRange = document.getElementById('edit-date-range');
    const editDateFrom = document.getElementById('edit-date-from');
    const editDateUntil = document.getElementById('edit-date-until');

    if (editDateRange && editDateFrom && editDateUntil) {
        flatpickr(editDateRange, {
            mode: 'range',
            dateFormat: 'd-m-Y',
            allowInput: false,

            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    editDateFrom.value = instance.formatDate(
                        selectedDates[0],
                        'Y-m-d'
                    );

                    editDateUntil.value = '';
                } else if (selectedDates.length === 2) {
                    editDateFrom.value = instance.formatDate(
                        selectedDates[0],
                        'Y-m-d'
                    );

                    editDateUntil.value = instance.formatDate(
                        selectedDates[1],
                        'Y-m-d'
                    );
                } else {
                    editDateFrom.value = '';
                    editDateUntil.value = '';
                }
            }
        });
    }

});