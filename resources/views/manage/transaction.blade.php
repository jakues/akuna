<!DOCTYPE html>
<html lang="en" class="bg-slate-50">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-22a9a34e.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-fa74f9f9.css') }}">
    <title>manage - transaction</title>
</head>

<body class="bg-slate-50" data-theme="pastel">
@include('etc.navbar')
@include('etc.alert')

<div class="flex justify-between mt-5 mx-5">
    <div>
        <button id="add-data-btn" class="btn btn-info text-slate-50 mx-5"><i class="fa-solid fa-plus"></i>Tambah Data
        </button>
        <button id="import-btn" class="btn btn-success text-slate-50 mx-5"><i
                class="fa-solid fa-file-arrow-up"></i></i>Import
        </button>
    </div>
    {{-- modal input start --}}
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
                        <div class="form-control mb-3 w-1/2">
                            <label class="label mx-3">
                                <span class="label-text">Nama Customer</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" placeholder="e.g. Vladimir Putin"
                                   class="input input-bordered input-primary w-full" name="customer" id="customer"
                                   value="">
                        </div>
                        {{-- customer end --}}
                        {{-- kode start --}}
                        <div class="form-control mb-3 w-3/12">
                            <label class="label mx-3">
                                <span class="label-text">Kode</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" placeholder="e.g. Shopee"
                                   class="input input-bordered input-primary w-full" name="kode" id="kode"
                                   value="">
                        </div>
                        {{-- kode end --}}
                    </div>
                    {{-- alamat start --}}
                    <div class="form-control w-full mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Alamat</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea
                            placeholder="e.g. Caturtunggal, Depok, Sleman Regency, Special Region of Yogyakarta 55281, Indonesia"
                            class="textarea textarea-bordered textarea-primary textarea-sm w-full"
                            id="alamat"></textarea>
                    </div>
                    {{-- alamat end --}}
                    <div class="flex justify-between">
                    {{-- telp start --}}
                    <div class="form-control w-4/12 mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Telepon</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text" placeholder="e.g. 621234567890"
                               class="input input-bordered input-primary w-full" name="telp" id="telp"
                               value="">
                    </div>
                    {{-- telp end --}}
                    {{-- count product start --}}
                    <div class="form-control w-3/5 mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Masukkan jumlah produk</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="range" min="0" max="10" class="range range-secondary" step="1"/>
                        <div class="w-full flex justify-between text-xs px-2">
                            <span></span>
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                            <span>6</span>
                            <span>7</span>
                            <span>8</span>
                            <span>9</span>
                            <span>10</span>
                        </div>
                    </div>
                    {{-- end count product --}}
                    </div>
                    {{-- collapse product start --}}
                    <div id="collapseContainer" class="mt-5"></div>
                    {{-- end collapse product --}}
                    <div class="flex justify-end mt-5">
                        <button type="submit" class="btn btn-accent btn-submit"
                                name="product-submit">Save
                        </button>
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
    {{-- end modal input --}}
    {{-- modal import start --}}
    <dialog id="import_modal" class="modal">
        <form method="dialog" class="modal-box max-w-3xl">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            <h3 id="" class="font-bold text-xl mb-5">Import Data Transaction</h3>
            <div class="mx-5">
                <form id="importForm" method="POST" enctype="multipart/form-data">
                    <div class="form-control w-full">
                        <label class="label mx-5">
                            <span class="label-text">Pick a file</span>
                            <span class="label-text-alt">Format must <span class="text-error">.xlsx</span></span>
                        </label>
                        <input type="file"
                               class="file-input file-input-accent file-input-bordered file-input-md w-full"
                               id="XlsxFile" name="XlsxFile"/>
                    </div>
                    <div class="flex justify-end mt-5">
                        <button type="submit" class="btn btn-accent import-submit">Submit</button>
                        <button type="reset" class="btn btn-active btn-ghost ml-5">Reset</button>
                    </div>
                </form>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    {{-- end modal import --}}
    <a href="{{ route('admin.transaction.export') }}" class="btn btn-neutral text-slate-50 mx-5"><i
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
            <th>Kode</th>
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
@include('etc.script')
@include('etc.requirements')
<script src="{{ asset('build/assets/transaction-ef74a1ee.js') }}"></script>
{{-- script --}}
</body>

</html>
