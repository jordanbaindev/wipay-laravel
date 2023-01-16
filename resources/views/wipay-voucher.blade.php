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
        <img class="mx-auto h-12 w-auto" src="https://bafasports.com/wp-content/uploads/2019/03/Wipay-logo-v2.png"
            alt="Your Company">
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Pay using Wipay Voucher.</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="voucher" class="block text-sm font-medium text-gray-700">Voucher</label>
                    <div class="mt-1">
                        <input id="voucher" name="voucher" type="text" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Pay</button>
                </div>
            </form>
        </div>
    </div>
  </div>

</body>

</html>
