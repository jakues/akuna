const TOKEN = import.meta.env.VITE_TOKEN;
const rootUrl = "/";

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
            url: '/manage/tx/import',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                // Show a success alert using your logic
                $("#greenMsg").text('Berhasil import data.');
                showAlert($("#greenAlert"), loadingBarGreen);
                setTimeout(function() {
                    hideAlert($("#greenAlert"), loadingBarGreen);
                }, 4000);
                $("#data-table").DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Show an error alert using your logic
                $("#redMsg").text('Gagal import data.');
                showAlert($("#redAlert"), loadingBarRed);
                setTimeout(function() {
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

    // select2 for search product
    $(".select-category").select2({
        placeholder: "Silahkan ketik produk lalu pilih",
        dropdownParent: $("#data_modal"),
        minimumInputLength: 4,
        ajax: {
            url: rootUrl + "/api/product",
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

    // Function to calculate total harga based selected product and qty
    $("#qty").on("input", function () {
        var qtyInput = $("#qty").val();
        var selectedData = $(".select-category").select2("data")[0];
        var product = selectedData ? selectedData.text : "";
        var productSplit = product.split(" - ");
        var harga_product = productSplit[1].replace("Rp.", "");
        var total = parseFloat(qtyInput) * parseFloat(harga_product);
        $("#total").val(total.toFixed(2));
    });

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
        $("#alamat").val("");
        $("#telp").val("");
        //$(".select-category").val("");
        $(".select-category").val([]).trigger("change");
        $("#variant").val("");
        $("#essence").val("");
        $("#qty").val("");
        $("#total").val("");
    }

    function saveChanges(id) {
        var tanggal = $("#tanggal").val();
        var customer = $("#customer").val();
        var alamat = $("#alamat").val();
        var telp = $("#telp").val();
        var variant = $("#variant").val();
        var essence = $("#essence").val();
        var qty_pembelian = $("#qty").val();

        // parse product here
        var selectedData = $(".select-category").select2("data")[0];
        var product = selectedData ? selectedData.text : "";
        var productSplit = product.split(" - ");
        var nama_barang = productSplit[0] + " - " + variant + "," + essence;
        var harga_product = productSplit[1].replace("Rp.", "");
        var total = qty_pembelian * harga_product;

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
            var url = "/api/tx/" + id;
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
                alamat: alamat,
                telp: telp,
                nama_barang: nama_barang,
                qty_pembelian: qty_pembelian,
                harga: harga_product,
                total_harga: total,
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
