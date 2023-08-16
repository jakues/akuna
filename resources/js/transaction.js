const TOKEN = import.meta.env.VITE_TOKEN;
const rootUrl = "/akuna/public/";

new DataTable("#data-table", {
    responsive: true,
    language: {
        lengthMenu: "Showing _MENU_ per pages",
        search: "_INPUT_",
        searchPlaceholder: " Cari Data",
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: rootUrl + "api/tx",
        type: "GET",
        beforeSend: function (request) {
            request.setRequestHeader("Authorization", "Bearer " + TOKEN);
        },
        dataSrc: "data",
    },
    columns: [
        {
            data: "id",
            name: "#",
        },
        {
            data: "tanggal_pembelian",
            name: "Tanggal",
        },
        {
            data: "customer",
            name: "Customer",
        },
        {
            data: "kode",
            name: "Kode",
        },
        {
            data: "alamat",
            name: "Alamat",
        },
        {
            data: "telp",
            name: "Telepon",
        },
        {
            data: "nama_barang",
            name: "Produk",
        },
        {
            data: "qty_pembelian",
            name: "Qty",
        },
        {
            data: "harga",
            name: "Harga",
        },
        {
            data: "total_harga",
            name: "Total",
        },
        {
            data: "actions",
            name: "Actions",
        },
    ],
});

$(document).ready(function () {
    const loadingBarGreen = $(".loadingBarGreen");
    const loadingBarRed = $(".loadingBarRed");
    var selectedValue;
    var productData = [];

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Show modal and reset value on import modal
    $('#import-btn').click(function (e) {
        e.preventDefault();
        import_modal.showModal();
        $('#XlsxFile').val('');
    });

    // import button
    $('.import-submit').click(function (e) {
        e.preventDefault();
        var fileInput = $('#XlsxFile')[0];
        var formData = new FormData($('#importForm')[0]);
        formData.append('XlsxFile', fileInput.files[0]);

        $.ajax({
            type: 'POST',
            url: rootUrl + 'manage/tx/import',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                // Show a success alert using your logic
                $("#greenMsg").text('Berhasil import data.');
                showAlert($("#greenAlert"), loadingBarGreen);
                setTimeout(function () {
                    hideAlert($("#greenAlert"), loadingBarGreen);
                }, 4000);
                $("#data-table").DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Show an error alert using your logic
                $("#redMsg").text('Gagal import data.');
                showAlert($("#redAlert"), loadingBarRed);
                setTimeout(function () {
                    hideAlert($("#redAlert"), loadingBarRed);
                }, 4000);
            }
        });
    });

    // Open modal for add button
    $("#add-data-btn").on("click", function () {
        clearFormFields();
        data_modal.showModal();
        $("#modal-heading").text("Tambah data");
    });

    // Open modal for edit-btn
    $("#data-table").on("click", ".edit-btn", function () {
        var id = $(this).data("id");
        $("#modal-heading").text("Update Produk : #" + id);
        // Fetch data to show current value
        fetchData(id);
        // Show modal
        data_modal.showModal();
    });

    // Delete button
    $("#data-table").on("click", ".delete-btn", function () {
        var id = $(this).data("id");
        var greenMsg = "Berhasil hapus data.";
        var redMsg = "Gagal hapus data.";
        if (confirm("Apakah ingin menghapus data #" + id + " ?")) {
            $.ajax({
                url: rootUrl + "api/tx/" + id,
                method: "DELETE",
                headers: {
                    Authorization: "Bearer " + TOKEN,
                },
                success: function (response) {
                    console.log(response);
                    // show green alert
                    $("#greenMsg").text(greenMsg + " #" + id);
                    showAlert($("#greenAlert"), loadingBarGreen);
                    setTimeout(() => {
                        hideAlert($("#greenAlert"), loadingBarGreen);
                    }, 4000);
                    $("#data-table").DataTable().ajax.reload();
                },
                error: function (err) {
                    console.error("Error: ", err);
                    // show red alert
                    $("#redMsg").text(redMsg + " #" + id);
                    showAlert($("#redAlert"), loadingBarRed);
                    setTimeout(() => {
                        hideAlert($("#redAlert"), loadingBarRed);
                    }, 4000);
                },
            });
        }
    });

    $('.range').on('input', function (e) {
        e.preventDefault();
        selectedValue = parseInt($(this).val());
        const collapseContainer = $('#collapseContainer');
        collapseContainer.empty();
        var sum = 0;

        if (selectedValue >= 1) {
            for (let i = 1; i <= selectedValue; i++) {
                const collapseHtml = `
                        <details class="collapse-product-${i} mt-5 collapse bg-base-200 collapse-arrow border border-base-300">
                        <summary class="collapse-title text-md font-medium">Product ${i}</summary>
                        <div class="collapse-content">
                            <!-- product start -->
                            <div class="form-control w-full mb-3">
                                <label class="label mx-3">
                                    <span class="label-text">Pilih Produk</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="category${i}" class="select-category select select-bordered select-primary">
                                </select>
                            </div>
                            <!-- product end -->
                            <!-- variant start -->
                            <div class="flex justify-between">
                                <div class="form-control mb-3" style="width: 48%;">
                                    <label class="label mx-3">
                                        <span class="label-text">Variant</span>
                                    </label>
                                    <input type="text" class="input input-bordered input-primary w-full"
                                           placeholder="jika ada" name="variant${i}" id="variant${i}" value="">
                                </div>
                                <div class="form-control mb-3" style="width: 48%;">
                                    <label class="label mx-3">
                                        <span class="label-text">Essence</span>
                                    </label>
                                    <input type="text" class="input input-bordered input-primary w-full"
                                           placeholder="jika ada" name="essence${i}" id="essence${i}" value="">
                                </div>
                            </div>
                            <!-- variant end -->
                            <!-- qty and total start -->
                            <div class="flex justify-between">
                                <div class="form-control mb-3" style="width: 48%;">
                                    <label class="label mx-3">
                                        <span class="label-text">Kuantitas</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="number" class="input input-bordered input-primary w-full"
                                           placeholder="e.g. 5" name="qty${i}" id="qty${i}" value="">
                                </div>
                                <div class="form-control mb-3" style="width: 48%;">
                                    <label class="label mx-3">
                                        <span class="label-text">Total Harga</span>
                                    </label>
                                    <input type="number" class="input input-bordered input-primary w-full"
                                           placeholder="" name="total${i}" id="total${i}" value="">
                                </div>
                            </div>
                            <!-- qty and total end -->
                        </div>
                    </details>
                    `;
                collapseContainer.append(collapseHtml);
                var selectCategory = $(`.collapse-product-${i} .select-category`);

                selectCategory.select2({
                    placeholder: "Silahkan ketik produk lalu pilih",
                    dropdownParent: $("#data_modal"),
                    minimumInputLength: 4,
                    ajax: {
                        url: rootUrl + "api/product",
                        method: "GET",
                        dataType: "json",
                        headers: {
                            Authorization: "Bearer " + TOKEN,
                        },
                        processResults: function (data) {
                            // Map the fetched data to Select2 format
                            return {
                                results: data.map(function (product) {
                                    var text =
                                        product.name_product +
                                        " " +
                                        product.netto_product +
                                        product.unit +
                                        " - Rp." +
                                        product.harga_product;
                                    return {
                                        id: product.id_product,
                                        text: text,
                                    };
                                }),
                            };
                        },
                        cache: true,
                    },
                });

                $('.collapse-content').on('input', `#variant${i}, #essence${i}, #qty${i}`, function () {
                    const index = i; // Use the current loop index

                    var selectedData = $(`.collapse-product-${index} .select-category`).select2("data")[0];
                    var productSplit = selectedData.text.split(" - ");
                    var productName = productSplit[0];
                    var variant = $(`#variant${index}`).val();
                    var essence = $(`#essence${index}`).val();
                    var qty = $(`#qty${index}`).val();
                    var harga_product = parseFloat(productSplit[1].replace("Rp.", ""));
                    var total = parseFloat(qty) * harga_product;

                    productData[index - 1] = {
                        id: selectedData.id,
                        name_product: productName,
                        variant: variant,
                        essence: essence,
                        qty: qty,
                        harga_product: harga_product,
                        total: total
                    };
                });
                calculateTotal(i);
            }
        }
    });

    function combineProductNames() {
        return productData.map(product => {
            var name = product.name_product;
            if (product.variant) {
                name += ` - ${product.variant}`;
            }
            if (product.essence) {
                name += `, ${product.essence}`;
            }
            return name;
        }).join(" ; ");
    }

    // Function to calculate total
    function calculateTotal(i) {
        // Calculate total harga based on selected product and qty
        $(`#qty${i}`).on("input", function () {
            var qtyInput = $(this).val();
            var selectedData = $(`.collapse-product-${i} .select-category`).select2("data")[0];
            var product = selectedData ? selectedData.text : "";
            var productSplit = product.split(" - ");
            var harga_product = productSplit[1].replace("Rp.", "");
            var total = parseFloat(qtyInput) * parseFloat(harga_product);
            $(`#total${i}`).val(total.toFixed(2));
        });
    }

    // Function to hide alert and loading bar
    function hideAlert(alert, loading) {
        loading.removeClass("loading-animation");
        alert.addClass("hidden");
    }

    // Function to show alert and loading bar
    function showAlert(alert, loading) {
        alert.removeClass("hidden");
        loading.addClass("loading-animation");
    }

    // Function to fetch data tx by id
    function fetchData(id) {
        $.ajax({
            url: rootUrl + "api/tx/id=" + id,
            method: "POST",
            headers: {
                Authorization: "Bearer " + TOKEN,
            },
            success: function (response) {
                console.log(response);
                populateModalForm(response);
            },
            error: function (err) {
                console.error("Error: ", err);
            },
        });
    }

    // Function to populate the modal form
    function populateModalForm(data) {
        $("#id").val(data.id);
        $("#tanggal").val(data.tanggal_pembelian);
        $("#customer").val(data.customer);
        $("#kode").val(data.kode);
        $("#alamat").val(data.alamat);
        $("#telp").val(data.telp);
        $("#qty").val(data.qty_pembelian);
        $("#total").val(data.total_harga);
    }

    // Function to clear the form fields manually
    function clearFormFields() {
        $("#id").val("");
        $("#tanggal").val("");
        $("#customer").val("");
        $("#kode").val("");
        $("#alamat").val("");
        $("#telp").val("");
        $(".range").val("0");
    }

    function saveChanges(id) {
        var tanggal = $("#tanggal").val();
        var customer = $("#customer").val();
        var kode = $("#kode").val();
        var alamat = $("#alamat").val();
        var telp = $("#telp").val();
        var sumTotal = 0;
        var qtyValues = [];
        var hargaValues = [];

        for (let j = 1; j <= selectedValue; j++) {
            if (productData[j - 1]) {
                qtyValues.push(productData[j - 1].qty);
                hargaValues.push(productData[j - 1].harga_product);
                sumTotal += parseFloat(productData[j - 1].total);
            }
        }

        var productString = combineProductNames();
        var qtyString = qtyValues.join(" ; ");
        var hargaString = hargaValues.join(" ; ");

        if (!id) {
            // tambah data
            var id = "";
            var url = rootUrl + "api/tx";
            var method = "POST";
            var greenMsg = "Berhasil menambah data.";
            var redMsg = "Gagal menambah data";
        } else {
            // update data
            var id = $("#id").val();
            var url = rootUrl + "api/tx/" + id;
            var method = "PUT";
            var greenMsg = "Berhasil update data.";
            var redMsg = "Gagal update data.";
        }

        $.ajax({
            url: url,
            method: method,
            headers: {
                Authorization: "Bearer " + TOKEN,
            },
            data: {
                id: id,
                tanggal_pembelian: tanggal,
                customer: customer,
                kode: kode,
                alamat: alamat,
                telp: telp,
                nama_barang: productString,
                qty_pembelian: qtyString,
                harga: hargaString,
                total_harga: sumTotal,
            },
            success: function (response) {
                console.log(response);
                // show green alert
                $("#greenMsg").text(greenMsg);
                showAlert($("#greenAlert"), loadingBarGreen);
                setTimeout(() => {
                    hideAlert($("#greenAlert"), loadingBarGreen);
                }, 4000);

                clearFormFields();
                $("#data-table").DataTable().ajax.reload();
            },
            error: function (err) {
                console.error("Error: ", err);
                // show red alert
                $("#redMsg").text(redMsg);
                showAlert($("#redAlert"), loadingBarRed);
                setTimeout(() => {
                    hideAlert($("#redAlert"), loadingBarRed);
                }, 4000);
            },
        });
    }

    function isAdd() {
        return $("#id").val() === "";
    }

    $(".btn-submit").click(function (e) {
        e.preventDefault();
        var id = isAdd() ? "" : $("#id").val();

        saveChanges(id);
    });
});
