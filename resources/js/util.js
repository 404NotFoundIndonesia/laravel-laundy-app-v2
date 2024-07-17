import Swal from 'sweetalert2';

export const dateHumanFormat = (dateString) => {
    if (!dateString) return '-';

    const date = new Date(dateString);
    const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
};

export const currency = (value, currency) => {
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: currency,
    });
    return formatter.format(value);
};

export const rupiahCurrency = (value) => {
    return currency(value, 'IDR');
};

export const currencySymbol = (currency) => {
    const symbol = {
        'USD': '$',
        'EUR': '€',
        'GBP': '£',
        'JPY': '¥',
        'AUD': 'A$',
        'CAD': 'C$',
        'CHF': 'CHF',
        'CNY': '¥',
        'SEK': 'kr',
        'NZD': 'NZ$',
        'INR': '₹',
        'BRL': 'R$',
        'RUB': '₽',
        'ZAR': 'R',
        'TRY': '₺',
        'MXN': '$',
        'SGD': 'S$',
        'HKD': 'HK$',
        'NOK': 'kr',
        'KRW': '₩',
        'IDR': 'Rp',
        'MYR': 'RM',
        'PHP': '₱',
        'THB': '฿',
        'VND': '₫',
        'MMK': 'K',
        'KHR': '៛',
        'LAK': '₭',
        'BND': 'B$',
        'AED': 'د.إ',
        'SAR': 'ر.س',
        'QAR': 'ر.ق',
        'KWD': 'د.ك',
        'BHD': 'ب.د',
        'OMR': 'ر.ع',
        'IRR': '﷼',
        'JOD': 'د.ا',
        'LBP': 'ل.ل',
    };
    return symbol[currency];
};

export const snakeCaseToTitleCase = (input) => {
    return input
        .split('_')
        .map(word => word[0].toUpperCase() + word.slice(1))
        .join(' ');
};

export const digitFormatter = (value) => new Intl.NumberFormat('id-ID').format(value);

export const validateNumber = (form, field) => {
    const value = form[field];
    form[field] = digitFormatter(value.replace(/[^0-9]/g, ''));
};

export const deleteConfirmation = (callback) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#10b981",
        confirmButtonText: "Yes, delete it!",
        cancelButtonColor: "#1f2937",
        cancelButtonText: "No, cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};
