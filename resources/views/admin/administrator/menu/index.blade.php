<!-- resources/views/child.blade.php -->

@extends('admin.administrator.layout')

@section('title', 'Manage Akun')



@section('content')
    <div class="w-full flex flex-col justify-center items-center ">
        @if (session()->has('success'))
            <div class="mb-3 inline-flex w-full items-center rounded-lg bg-success-100 px-6 py-5 text-base text-success-700"
                role="alert">
                <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-3 inline-flex w-full items-center rounded-lg bg-danger-100 px-6 py-5 text-base text-danger-700"
                role="alert">
                <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <ul>

                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Todo Title --}}
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800">Manage Menu</p>
        {{-- Todo Create --}}
        <!-- Button trigger modal -->
        <div class="w-full">

            <button type="button"
                class="mt-5 ml-7 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                data-te-toggle="modal" data-te-target="#exampleModal" data-te-ripple-init data-te-ripple-color="light">
                Create
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
                                Create Menu
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
                        <form action="{{ route('menu.add') }}" method="post" class="flex flex-col gap-1"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="relative flex-auto p-4" data-te-modal-body-ref>
                                <div class="relative mb-3" data-te-input-wrapper-init>
                                    <input type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput2" placeholder="Form control lg" required autofocus
                                        name="nama" />
                                    <label for="exampleFormControlInput2"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Nama
                                    </label>
                                </div>
                                <div class="relative mb-3">
                                    <select required name="kategori"
                                        class="appearance-none w-full py-2 px-4 border border-gray-300 rounded-md leading-tight focus:outline-none focus:border-blue-500">
                                        <option value="" selected disabled hidden>Pilih Kategori</option>
                                        <option value="Makanan">Food</option>
                                        <option value="Minuman">Drink</option>
                                        <option value="Dessert">Dessert</option>
                                    </select>
                                </div>
                                <div class="relative mb-3" data-te-input-wrapper-init>
                                    <input type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput2" placeholder="Form control lg" required
                                        name="deskripsi" />
                                    <label for="exampleFormControlInput2"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Deskripsi
                                    </label>
                                </div>
                                <div class="relative mb-3" data-te-input-wrapper-init>
                                    <input type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleFormControlInput2" placeholder="Form control lg" required
                                        name="harga" />
                                    <label for="exampleFormControlInput2"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Harga
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileMultiple"
                                        class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Gambar</label>
                                    <input
                                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                        type="file" id="formFileMultiple" multiple required
                                        accept="image/png, image/gif, image/jpeg, image/jpg" name="image_url" />
                                </div>
                                <div class="relative mb-3">
                                    {{-- <label data-te-select-label-ref>Toko</label> --}}
                                    <select required name="id_toko"
                                        class="appearance-none w-full py-2 px-4 border border-gray-300 rounded-md leading-tight focus:outline-none focus:border-blue-500">
                                        <option value="" selected disabled hidden>Pilih Toko</option>
                                        @forelse ($tokos as $index => $toko)
                                            <option value="{{ $toko->id }}">{{ $toko->nama }}</option>
                                        @empty
                                            <option>Belum ada toko</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>

                            <!--Modal footer-->
                            <div
                                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                <button type="button"
                                    class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                                    data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                                    Close
                                </button>
                                <button type="submit"
                                    class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                    data-te-ripple-init data-te-ripple-color="light">
                                    Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Todo Table --}}
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden w-[90vw] min-w-[620px] ">
                    <table class="min-w-full text-center text-sm font-light">
                        <colgroup>
                            <col style="width: 4.5%;" /> <!-- No -->
                            <col style="width: 20%;" /> <!-- Nama -->
                            <col style="width: 10%;" /> <!-- No -->
                            <col style="width: 25%;" /> <!-- Nama -->
                            <col style="width: 15%;" /> <!-- Pemilik -->
                            <col style="width: 10.5%;" /> <!-- Deskripsi -->
                            <col style="width: 10%;" /> <!-- Alamat -->
                            <col style="width: 10%;" /> <!-- Action -->
                        </colgroup>
                        <thead
                            class="border-b bg-cyan-400 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                            <tr>
                                <th scope="col" class=" px-6 py-4 border">No</th>
                                <th scope="col" class=" px-6 py-4 border">Nama</th>
                                <th scope="col" class=" px-6 py-4 border">Kategori</th>
                                <th scope="col" class=" px-6 py-4 border">Deskriosi</th>
                                <th scope="col" class=" px-6 py-4 border">Harga</th>
                                <th scope="col" class=" px-6 py-4 border">Gambar</th>
                                <th scope="col" class=" px-6 py-4 border">ID Toko</th>
                                <th scope="col" class=" px-6 py-4 border">Action</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse ($menus as $index => $menu)
                                {{-- {{ $menu }} --}}
                                <tr class="{{ $index % 2 === 0 ? 'even:bg-white' : 'odd:bg-slate-50' }}">
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $menu->nama }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $menu->kategori }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $menu->deskripsi }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $menu->harga }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 border">
                                        <img alt="image"
                                            class="block h-full min-w-[75px] max-w-[115px] rounded object-cover object-center"
                                            src="/img/menu/{{ $menu->image_url }}" />
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 border">{{ $menu->id_toko }}</td>
                                    <td
                                        class="whitespace-nowrap  px-6 py-4 border flex flex-row justify-center items-center gap-3">
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                            id="deleteForm-{{ $menu->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="hover:text-[#FF0000] text-danger-500 text-xl"
                                                onclick="confirmDelete({{ $menu->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </form>

                                        <a href="{{ route('menu.edit', $menu->id) }}"
                                            class="hover:text-[#0000FF] text-blue-500 text-xl -mt-3">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="whitespace-nowrap px-6 py-4 border text-center">Data belum
                                        ada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            function confirmDelete(id) {
                if (confirm('Apakah Anda yakin ingin menghapus?')) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            }
        </script>
    </div>
@endsection
