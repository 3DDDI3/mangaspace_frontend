import Swal from 'sweetalert2';

$(function () {
    let offset = $("#table-record-header").val();

    $("thead tr th").on("click", function (e) {
        if (!$(this).hasClass("sorting"))
            return;

        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        if ($(this).hasClass("sorting_asc") || $(this).hasClass("sorting_desc")) {
            if ($(this).hasClass("sorting_asc")) {
                /**
                 * Сортировка по убыванию
                 */
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_asc");
                $(this).addClass("sorting_desc");

                let params = {
                    orderByDesc: $(this).data("field"),
                    offset: offset,
                }

                if ($("input[name='chapter-search']").val() != "")
                    params.search = $("input[name='chapter-search']").val();

                axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles`, { params })
                    .then((response) => {
                        updateTable(response, title);
                        updatePaginationList(response, title);
                        updateTableInfo(response);
                    });
            }
            else {
                /**
                 * Сортировка по возрастанию
                 */
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_desc");
                $(this).addClass("sorting_asc");

                let params = {
                    orderByAsc: $(this).data("field"),
                    offset: offset,
                }

                if ($("input[name='chapter-search']").val() != "")
                    params.search = $("input[name='chapter-search']").val();


                axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles`, { params })
                    .then((response) => {
                        updateTable(response, title);
                        updatePaginationList(response, title);
                        updateTableInfo(response);
                    });
            }
        } else {
            $("thead tr th").removeClass("sorting_asc");
            $("thead tr th").removeClass("sorting_desc");
            $(this).addClass("sorting_asc");

            let params = {
                orderByAsc: $(this).data("field"),
                offset: offset,
            }

            if ($("input[name='chapter-search']").val() != "")
                params.search = $("input[name='chapter-search']").val();

            axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles`, { params })
                .then((response) => {
                    updateTable(response, title);
                    updatePaginationList(response, title);
                    updateTableInfo(response);
                });
        }
    });

    /**
     * Функционал кнопки удаления
     */
    $("a.image-delete-btn").on("click", function () {
        // Toastify({
        //     text: "This is toast in top left",
        //     duration: 3000,
        //     close: true,
        //     gravity: "top",
        //     position: "left",
        //     backgroundColor: "#4fbe87",
        // }).showToast()

        // let toastLive = $("#liveToast");
        // $(toastLive).find(".toast-body").text('asda');
        // const toast = new bootstrap.Toast(toastLive);
        // toast.show();

        Swal.fire({
            icon: "warning",
            title: "Вы действительно хотите удалить изображение",
            showCancelButton: true,
            confirmButtonText: "Удалить",
            cancelButtonText: `Отмена`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.delete(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${$(this).data("slug")}`)
                    .then((response) => { });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });


    $(".dataTable-bottom").on("click", ".page-item", function (e) {
        e.preventDefault();

        if ($(this).hasClass("active"))
            return;

        let page = $(this).find(".page-link").attr("href").match(/\?page=(\d+)/)[1];
        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        $(".page-item").removeClass("active");
        $(this).addClass("active");

        let params = {
            page: page,
            offset: offset,
        };

        if ($("th.sorting_asc").data("field") != undefined)
            params.orderByAsc = $("th.sorting_asc").data("field");

        if ($("th.sorting_desc").data("field") != undefined)
            params.orderByDesc = $("th.sorting_desc").data("field");

        axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles`, { params })
            .then((response) => {
                updateTable(response, title);
                updatePaginationList(response, title);
                updateTableInfo(response);
            }).catch((error) => {

            });
    });

    $("input[name='title-search']").on("input", function () {
        $("thead th").removeClass("sorting_desc");
        $("thead th").removeClass("sorting_asc");

        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        let params = {
            search: $(this).val(),
            offset: offset,
        }

        axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles`, { params })
            .then((response) => {
                updateTable(response, title);
                updatePaginationList(response, title);
                updateTableInfo(response);
            });
    });

    $("tbody a.delete-btn").on("click", function () {
        Swal.fire({
            icon: "warning",
            title: "Вы действительно хотите удалить главу",
            showCancelButton: true,
            confirmButtonText: "Удалить",
            cancelButtonText: `Отмена`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.delete(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${$(this).data("slug")}`)
                    .then((response) => { });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

});


/**
 * Обновление списка пагинации
 * @param {*} response 
 * @param {*} title 
 */
function updatePaginationList(response, title) {
    $(".table-responsive .dataTable-pagination .page-item").remove();

    response.data.meta.links.forEach((el) => {
        /**
         * Формирование списка страниц
         */
        if (el.label != "&laquo; Previous" && el.label != "Next &raquo;") {
            if (el.active) {
                $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                    `   
                    <li class="page-item" aria-disabled="true">
                        <span class="page-link active">
                            ${el.label}
                        </span>
                    </li>
                `
                );
            }
            else {
                $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                    `
                        <li class="page-item">
                            <a class="page-link" href="${location.origin}/admin/titles?page=${el.label}">
                                ${el.label}
                            </a>
                        </li>
                    `
                );
            }

        }

        if (el.label == "&laquo; Previous" && el.url != null) {
            $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                `
                    <li class="pager page-item">
                        <a class="page-link" href="${location.origin}/admin/titles/${el.url.split("/")[el.url.split("/").length - 1]}" rel="prev"
                            aria-label="">&lsaquo;</a>
                    </li>
                `
            )
        }

        if (el.label == "Next &raquo;" && el.url != null) {
            $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                `
                    <li class="pager page-item">
                            <a class="page-link" href="${location.origin}/admin/titles/${el.url.split("/")[el.url.split("/").length - 1]}" rel="next"
                                aria-label="">&rsaquo;</a>
                    </li>
                `
            );
        }
    });
}

/**
 * Измененеи плашки с кол-вом записей в таблице
 */
function updateTableInfo(response) {
    $(".table-responsive .dataTable-info .fw-semibold").eq(0).text(response.data.meta.from);
    $(".table-responsive .dataTable-info .fw-semibold").eq(1).text(response.data.meta.to);
    $(".table-responsive .dataTable-info .fw-semibold").eq(2).text(response.data.meta.total);
}


/**
 * Обновление таблицы
 * @param {*} response 
 * @param {string} title 
 * @returns 
 */
function updateTable(response, title) {
    let chapter = response.data.data;

    $("table tbody tr").remove();

    if (chapter.length == 0) {
        $("table tbody").append(
            `
                <tr class="odd">
                    <td valign="top" colspan="6" class="dataTables_empty text-center">
                        Не удалось найти совпадения
                    </td>
                </tr>
            `
        );
        return;
    }

    chapter.forEach((item) => {
        $("table tbody").append(
            `
            <tr>
                <td>
                    <a href="/admin/titles/${item.slug}">
                        ${item.name}
                    </a>
                </td>
                <td>${item.type}</td>
                <td><span class="badge bg-secondary">${item.translateStatus}</span></td>
                <td><span class="badge bg-secondary">${item.titleStatus}</span></td>
                <td>${item.releaseYear}</td>
                <td>
                    <div class="btn-group d-flex justify-content-end column-gap-2 ps-2"
                        role="group" aria-label="Basic example">
                        <a href="/admin/titles/${item.slug}"
                            class="action-btn edit-btn btn icon btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a class="action-btn delete-btn btn icon btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            `
        );
    });
}