<!DOCTYPE html>
<html lang="en" class="bg-slate-50">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/dataTables.tailwindcss.min.css', 'resources/css/select2.min.css', 'resources/js/app.js'])
    <title>akuna - manage</title>
</head>

<body class="bg-slate-50" data-theme="pastel">
    @include('etc.navbar')
    @include('etc.alert')

    <div class="flex justify-between mt-5 mx-5">
        <button id="add-data-btn" class="btn btn-info text-slate-50 mx-5"><i class="fa-solid fa-plus"></i>Tambah
            Data</button>
        {{-- modal start --}}
        <dialog id="data_modal" class="modal">
            <form method="dialog" class="modal-box max-w-5xl h-4/5">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                <h3 id="modal-heading" class="font-bold text-xl mb-5"></h3>
                <div class="mx-5">
                    {{-- form start --}}
                    <form method="POST" id="product-form">
                        <input type="hidden" name="id" id="id">
                        <div class="flex justify-between">
                            {{-- date start --}}
                            <div class="form-control mb-3 w-1/5">
                                <label class="label mx-3">
                                    <span class="label-text">Tanggal Pembelian</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="date" class="input input-bordered input-primary w-full" name="tanggal"
                                    id="tanggal" value="">
                            </div>
                            {{-- date end --}}
                            {{-- customer start --}}
                            <div class="form-control mb-3 w-3/4">
                                <label class="label mx-3">
                                    <span class="label-text">Nama Customer</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" placeholder="e.g. Vladimir Putin"
                                    class="input input-bordered input-primary w-full" name="customer" id="customer"
                                    value="">
                            </div>
                            {{-- customer end --}}
                        </div>
                        {{-- alamat start --}}
                        <div class="form-control w-full mb-3">
                            <label class="label mx-3">
                                <span class="label-text">Alamat</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <textarea placeholder="e.g. Caturtunggal, Depok, Sleman Regency, Special Region of Yogyakarta 55281, Indonesia"
                                class="textarea textarea-bordered textarea-primary textarea-sm w-full" id="alamat"></textarea>
                        </div>
                        {{-- alamat end --}}
                        {{-- telp start --}}
                        <div class="form-control w-full mb-3">
                            <label class="label mx-3">
                                <span class="label-text">Telepon</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" placeholder="e.g. 621234567890"
                                class="input input-bordered input-primary w-full" name="telp" id="telp"
                                value="">
                        </div>
                        {{-- telp end --}}
                        {{-- product start --}}
                        <div class="form-control w-full mb-3">
                            <label class="label mx-3">
                                <span class="label-text">Pilih Produk</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <select name="category" class="select-category select select-bordered select-primary">
                            </select>
                        </div>
                        {{-- product end --}}
                        {{-- variant start --}}
                        <div class="flex justify-between">
                            <div class="form-control mb-3" style="width: 48%;">
                                <label class="label mx-3">
                                    <span class="label-text">Variant</span>
                                </label>
                                <input type="text" class="input input-bordered input-primary w-full"
                                    placeholder="jika ada" name="variant" id="variant" value="">
                            </div>
                            <div class="form-control mb-3" style="width: 48%;">
                                <label class="label mx-3">
                                    <span class="label-text">Essence</span>
                                </label>
                                <input type="text" class="input input-bordered input-primary w-full"
                                    placeholder="jika ada" name="essence" id="essence" value="">
                            </div>
                        </div>
                        {{-- variant end --}}
                        {{-- qty and total start --}}
                        <div class="flex justify-between">
                            <div class="form-control mb-3" style="width: 48%;">
                                <label class="label mx-3">
                                    <span class="label-text">Kuantitas</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="number" class="input input-bordered input-primary w-full"
                                    placeholder="jika ada" name="qty" id="qty" value="">
                            </div>
                            <div class="form-control mb-3" style="width: 48%;">
                                <label class="label mx-3">
                                    <span class="label-text">Total Harga</span>
                                </label>
                                <input type="number" class="input input-bordered input-primary w-full"
                                    placeholder="" name="total" id="total" value="" readonly>
                            </div>
                        </div>
                        {{-- qty and total end --}}
                        <div class="flex justify-end mt-5">
                            <button type="submit" class="btn btn-accent btn-submit"
                                name="product-submit">Save</button>
                            <button type="reset" class="btn btn-active btn-ghost ml-5">Reset</button>
                        </div>
                    </form>
                    {{-- form end --}}
                </div>
            </form>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
        {{-- modal end --}}
        <a href='#' class="btn btn-neutral text-slate-50 mx-5"><i
                class="fa-solid fa-file-export"></i>Export</a>
    </div>

    {{-- table start --}}
    <section class="m-10 min-h-screen">
        <table id="data-table" class="display" style="width:100%" data-theme="pastel">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </section>
    {{-- table end --}}

    {{-- script --}}
    @vite('resources/js/dashboard.js')
    <script src="https://kit.fontawesome.com/8c1bad6c0c.js" crossorigin="anonymous"></script>
    {{-- script --}}
</body>

</html>
