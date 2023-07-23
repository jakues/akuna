const TOKEN = "";

new DataTable("#product-table", {
    responsive: true,
    language: {
        lengthMenu: "Showing _MENU_ per pages",
        search: "_INPUT_",
        searchPlaceholder: " Cari Data",
    },
    processing: true,
    serverside: true,
    ajax: {
        url: "/api/products",
        type: "GET",
        beforeSend: function (request) {
            request.setRequestHeader("Authorization", "Bearer " + TOKEN);
        },
        dataSrc: "data",
    },
    columns: [
        {
            data: "id_product",
            name: "#",
        },
        {
            data: "category_product",
            name: "Kategori Produk",
        },
        {
            data: "name_product",
            name: "Nama Produk",
        },
        {
            data: "netto_product",
            name: "Netto",
        },
        {
            data: "unit",
            name: "Unit",
        },
        {
            data: "harga_product",
            name: "Harga",
        },
        {
            data: "tanggal_input",
            name: "Tanggal Input",
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
            "X-CSSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Open modal for add-product-btn
    $("#add-product-btn").on("click", function () {
        clearFormFields();
        product_modal.showModal();
        $("#modal-heading").text("Tambah Produk");
    });

    // Open modal for edit-btn
    $("#product-table").on("click", ".edit-btn", function () {
        var productId = $(this).data("id");
        $("#modal-heading").text("Update Produk : #" + productId);
        // Fetch data to show current value
        fetchData(productId);
        // Show modal
        product_modal.showModal();
    });

    $("#product-table").on("click", ".delete-btn", function () {
        var productId = $(this).data("id");
        var greenMsg = "Berhasil hapus produk";
        var redMsg = "Gagal hapus produk";
        if (confirm("Apakah ingin menghapus data #" + productId + " ?")) {
            $.ajax({
                url: "/api/products/" + productId,
                method: "DELETE",
                headers: {
                    Authorization: "Bearer " + TOKEN,
                },
                success: function (response) {
                    console.log(response);
                    // show green alert
                    $("#greenMsg").text(greenMsg + " #" + productId);
                    showAlert($("#greenAlert"), loadingBarGreen);
                    setTimeout(() => {
                        hideAlert($("#greenAlert"), loadingBarGreen);
                    }, 4000);
                    $("#product-table").DataTable().ajax.reload();
                },
                error: function (err) {
                    console.error("Error: ", err);
                    // show red alert
                    $("#redMsg").text(redMsg + " #" + productId);
                    showAlert($("#redAlert"), loadingBarRed);
                    setTimeout(() => {
                        hideAlert($("#redAlert"), loadingBarRed);
                    }, 4000);
                },
            });
        }
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

    // Function to fetch product data by ID and populate the modal form
    function fetchData(productId) {
        $.ajax({
            url: "/api/products/id=" + productId,
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

    // Function to populate the modal form with product data
    function populateModalForm(productData) {
        // Set the form fields based on the productData
        $("#category").val(productData.category_product);
        $("#product").val(productData.name_product);
        $("#netto").val(productData.netto_product);
        $("#unit").val(productData.unit);
        $("#harga").val(productData.harga_product);
    }

    // Function to clear the form fields manually
    function clearFormFields() {
        $("#category").val("");
        $("#custom-category").val("");
        $("#product").val("");
        $("#netto").val("");
        $("#unit").val("");
        $("#harga").val("");
    }

    function isAdd() {
        return $("#id").val() === "";
    }

    function saveChanges(id) {
        var selectedCategory = $("#category").val();
        var category_product;
        if (selectedCategory === "custom") {
            category_product = $("#custom-category").val();
        } else {
            category_product = selectedCategory;
        }
        var name_product = $("#product").val();
        var netto_product = $("#netto").val();
        var unit = $("#unit").val();
        var harga_product = $("#harga").val();

        if (!id) {
            // tambah produk
            var id_product = $("#id").val();
            var url = "/api/products";
            var method = "POST";
            var greenMsg = "Berhasil menambah produk.";
            var redMsg = "Gagal menambah produk.";
        } else {
            // udpdate produk
            $("#id").val(id);
            var id_product = $("#id").val();
            var url = "/api/products/" + id;
            var method = "PUT";
            var greenMsg = "Berhasil update produk.";
            var redMsg = "Gagal update produk.";
        }

        $.ajax({
            url: url,
            method: method,
            headers: {
                Authorization: "Bearer " + TOKEN,
            },
            data: {
                id_product: id_product,
                category_product: category_product,
                name_product: name_product,
                netto_product: netto_product,
                unit: unit,
                harga_product: harga_product,
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
                $("#product-table").DataTable().ajax.reload();
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

    $(".btn-submit").click(function (e) {
        e.preventDefault();
        var productId = isAdd() ? $("#id").val() : "";

        saveChanges(productId);
    });
});
