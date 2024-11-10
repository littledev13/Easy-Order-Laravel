<!-- resources/views/layouts/app.blade.php -->

<html>

<head>
    <title>Koki | Easy Order</title>
    @vite('resources/js/tw-elements.umd.min.js')
    @vite('resources/css/app.css')
    @vite('resources/css/all.css')
    {{-- Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mx-auto print:w-fit print:mx-0 print:my-0">
        <!-- Button trigger modal -->
        <button type="button"
            class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] invisible absolute print:hidden"
            data-te-toggle="modal" data-te-target="#exampleModal" data-te-ripple-init data-te-ripple-color="light"
            id="notif">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div data-te-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div data-te-modal-dialog-ref
                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div
                    class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <!--Modal title-->
                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="exampleModalLabel">
                            Pesanan Baru
                        </h5>
                        <!--Close button-->
                        <button type="button"
                            class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-te-modal-dismiss aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!--Modal body-->
                    <div class="relative flex-auto p-4" data-te-modal-body-ref id="pesanMasuk">
                        <pre>No Nota &ensp;&ensp;&ensp;: <span id="no_nota"></span></pre>
                        <pre>Pembeli &ensp;&ensp;&ensp;: <span id="pembeli"></span></pre>
                        <pre>Status &ensp;&ensp;&ensp;: <span id="status"></span></pre>
                        <pre>Tanggal &ensp;&ensp;&ensp;: <span id="tanggal"></span></pre>


                    </div>

                    <!--Modal footer-->
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <button type="button" onclick="location.reload();"
                            class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                            data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                            Close
                        </button>
                        {{-- <button type="button"
                            class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                            data-te-ripple-init data-te-ripple-color="light">
                            Save changes
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
        @section('header')
            <nav class="w-full sticky top-0 left-0 flex flex-row justify-between items-center print:hidden mt-3">
                <h2 class="text-3xl text-[#101024] px-3">
                    Easy<sub>order</sub>
                </h2>

                <a href="/logout.php"
                    class="w-fit h-fit rounded px-2 py-1 flex flex-row gap-1 items-center hover:cursor-pointer shadow-md bg-red-400 hover:bg-red-500 text-white scale-[.80]">
                    <i class="fa-solid fa-right-from-bracket"></i>

                    <p>Logout</p>
                </a>
            </nav>
        @show
        @yield('content')
    </div>
    @vite('resources/js/main.js')
    <script type="module">
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('f655067aadb26c536c56', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-kokiChannel');
        channel.bind('my-kokiEvent', function(data) {
            console.log(data.message);
            let objekTanggal = new Date(data.message[0].updated_at);
            let tanggalHasil = objekTanggal.toISOString().slice(0, 19).replace("T", " ");
            document.getElementById('tanggal').innerText = tanggalHasil;
            document.getElementById('status').innerText = data.message[0].status;
            document.getElementById('pembeli').innerText = data.message[0].pembeli;
            document.getElementById('no_nota').innerText = data.message[0].no_nota;
            document.getElementById('notif').click();
            // Your provided code

        })
    </script>
</body>

</html>
