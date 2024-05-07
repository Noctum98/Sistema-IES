$(document).ready(function () {
    $(".ver_modal").on("click", function (e) {
        e.preventDefault();
        $("#showMateria .modal-content").html("");
        let url = $(this).data('url');

        $.ajax({
            method: "GET",
            url: url,
            success: function (response) {
                $("#showMateria .modal-content").html(response)
                $('#showMateria').modal('show');
            }
        })
    })

});
