<!doctype html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./resources/css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>

<body class="h-full">

    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-20 w-auto" src="{{asset('public/assets/admin/img/wipay_voucher_payment.png')}}"
                alt="Your Company">
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Pay using Wipay Voucher.</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white pb-8 pt-4 px-4 shadow sm:rounded-lg sm:px-10">
                <form id="form" class="space-y-6">
                    @csrf
                    <div>
                        <label for="voucher" class="block text-sm font-medium text-gray-700">Voucher Code</label>
                        <div class="mt-1">
                            <input id="payment_id" name="payment_id" type="hidden" value="{{ $payment_id }}"/>
                            <input id="voucher" name="voucher" type="text" required
                                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <svg id="loader" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Pay
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ERROR MODAL --}}
    <div id="modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Something Went Wrong!</h3>
                <div class="mt-2">
                    <p id="modal-text" class="text-sm text-gray-500">An error occurred.</p>
                </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                <button id="cancelButton" type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto sm:text-sm">Cancel</button>
                <button id="retryButton" type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Retry</button>
            </div>
            </div>
        </div>
        </div>
    </div>


</body>

<script>
    document.getElementById("cancelButton").onclick = function () {
        location.href = "{{ route('payment-fail') }}";
    };
    document.getElementById("retryButton").onclick = function () {
        window.location.reload();
    };

    const form = document.getElementById('form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const payload = new FormData(form);

        console.log([...payload]);

        var loader = document.getElementById('loader');
        loader.style.display = 'block';

        var modal = document.getElementById('modal');
        var modalText = document.getElementById('modal-text');

        fetch('{{ route('wipay.voucher-pay') }}', {
            method: 'POST',
            body: payload,
        })
            .then((response) => {
                loader.style.display = "none";
                if (!response.ok) {
                    modal.style.display = 'block';
                    modalText.innerHTML = 'Network response was not OK';
                }

                return response.json();
            })
            .then((data) => {
                console.log(data);
                modal.style.display = 'block';
                modalText.innerHTML = data['error'];
            })
            .catch((err) => {
                loader.style.display = "none";
                console.log(err);
                if (err) {
                    modal.style.display = 'block';
                    modalText.innerHTML = 'Sorry, an error occurred while proccessing form request!';
                }
            });
    });
</script>

</html>
