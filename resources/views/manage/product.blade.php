<!DOCTYPE html>
<html lang="en" class="bg-slate-50">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/dataTables.tailwindcss.min.css', 'resources/js/app.js', 'resources/js/dataTables.tailwindcss.min.js'])
    <title>akuna - manage</title>
</head>

<body class="bg-slate-50" data-theme="pastel">
<!-- navbar start -->
@include('etc.navbar')
<!-- navbar end -->
@include('etc.alert')

<div class="flex justify-between mt-5 mx-5">
    <div>
        <button id="add-product-btn" class="btn btn-info text-slate-50 mx-5"><i
                class="fa-solid fa-plus"></i>Tambah Produk
        </button>
        <button id="import-btn" class="btn btn-success text-slate-50 mx-5"><i
                class="fa-solid fa-file-arrow-up"></i></i>Import
        </button>
    </div>
    <!-- modal add start -->
    <dialog id="product_modal" class="modal">
        <form method="dialog" class="modal-box max-w-5xl h-2/3">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            <h3 id="modal-heading" class="font-bold text-xl mb-5"></h3>
            <div class="mx-5">
                <!-- product form start -->
                <form method="POST" id="product-form">
                    <input type="hidden" name="id" id="id">
                    <!-- Category start -->
                    <div class="form-control w-full mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Select Category</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="category" class="select select-bordered select-primary"
                                data-role="select" id="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Face" name="Face" onclick="handleCategory(this.value)">Face</option>
                            <option value="Hair" name="Hair" onclick="handleCategory(this.value)">Hair</option>
                            <option value="Soap" name="Soap" onclick="handleCategory(this.value)">Soap & Wash
                            </option>
                            <option value="Toothpaste" name="Toothpaste" onclick="handleCategory(this.value)">
                                Toothpaste
                            </option>
                            <option value="Deodorant" name="Deodorant" onclick="handleCategory(this.value)">
                                Deodorant
                            </option>
                            <option value="Balm" name="Balm" onclick="handleCategory(this.value)">Traditional
                                Balm
                            </option>
                            <option value="Butter" name="Butter" onclick="handleCategory(this.value)">Butter
                            </option>
                            <option value="Cream" name="Cream" onclick="handleCategory(this.value)">Cream
                            </option>
                            <option value="Kitchen" name="Kitchen" onclick="handleCategory(this.value)">Kitchen
                            </option>
                            <option value="Laundry" name="Laundry" onclick="handleCategory(this.value)">Laundry
                            </option>
                            <option value="Leather" name="Leather" onclick="handleCategory(this.value)">Leather
                                Treatment
                            </option>
                            <option value="DIY" name="DIY" onclick="handleCategory(this.value)">DIY</option>
                            <option value="custom" name="custom" onclick="handleCategory(this.value)">Other (Please
                                specify below)
                            </option>
                        </select>
                        <!-- Other Category -->
                        <div id="custom" class="" style="display: none;">
                            <label class="label mx-3">
                                <span class="label-text">Enter Category</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text" placeholder="e.g. Shampoo"
                                   class="input input-bordered input-primary w-full" name="custom-category"
                                   id="custom-category" value="">
                        </div>
                    </div>
                    <!-- Category end -->
                    <!-- Product start -->
                    <div class="form-control w-full mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Enter Product Name</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text" placeholder="e.g. Shampoo Bar"
                               class="input input-bordered input-primary w-full" name="product" id="product"
                               value="" required>
                    </div>
                    <!-- Product end -->
                    <!-- Quantity start -->
                    <div class="flex justify-between">
                        <div class="form-control mb-3" style="width: 48%;">
                            <label class="label mx-3">
                                <span class="label-text">Enter Product Netto</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="number" class="input input-bordered input-primary w-full"
                                   placeholder="e.g. 100" name="netto" id="netto" value="" required>
                        </div>
                        <div class="form-control mb-3" style="width: 48%;">
                            <label class="label mx-3">
                                <span class="label-text">Unit</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <select name="unit" id="unit" class="select select-bordered select-primary"
                                    required>
                                <option value="" disabled selected>Select an unit</option>
                                <option value="gr" name="gram">gram</option>
                                <option value="ml" name="ml">mL</option>
                                <option value="pcs" name="pcs">pcs</option>
                            </select>
                        </div>
                    </div>
                    <!-- Quantity end -->
                    <!-- Harga start -->
                    <div class="form-control mb-3">
                        <label class="label mx-3">
                            <span class="label-text">Enter Product Price</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <div class="join">
                            <button class="btn btn-active btn-ghost join-item rounded-r-full">Rp.</button>
                            <input type="number" class="input input-bordered input-primary join-item w-full"
                                   placeholder="e.g. 65000" name="harga" id="harga" value="" required>
                        </div>
                    </div>
                    <!-- Harga end -->
                    <div class="flex justify-end mt-5">
                        <button type="submit" class="btn btn-accent btn-submit" name="product-submit">Save</button>
                        <button type="reset" class="btn btn-active btn-ghost ml-5">Reset</button>
                    </div>
                </form>
                <!-- product form end -->
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <!-- end modal add -->
    {{-- modal import start --}}
    <dialog id="import_modal" class="modal">
        <form method="dialog" class="modal-box max-w-3xl">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            <h3 id="" class="font-bold text-xl mb-5">Import Data Product</h3>
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
    <a href='/manage/products/export' class="btn btn-neutral text-slate-50 mx-5"><i
            class="fa-solid fa-file-export"></i>Export</a>
</div>

<!-- table start -->
<section class="m-10 min-h-screen">
    <table id="product-table" class="display" style="width:100%" data-theme="pastel">
        <thead>
        <tr>
            <th>#</th>
            <th>Kategori Produk</th>
            <th>Nama Produk</th>
            <th>Netto</th>
            <th>Unit</th>
            <th>Harga</th>
            <th>Tanggal Input</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</section>
<!-- table end -->

<!-- script -->
@vite('resources/js/product.js')
@include('etc.script')
<script src="https://kit.fontawesome.com/8c1bad6c0c.js" crossorigin="anonymous"></script>
<!-- script -->
</body>

</html>
