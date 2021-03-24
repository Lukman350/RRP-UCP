$(() => {
  $("#form-createchar").submit((e) => {
    $("#btn-submit").prop("disabled", true);
    $("#btn-submit").html("Loading...");
    e.preventDefault();

    if ($("#form-createchar")[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      Ajax.post({
        url: "../scripts/char.php",
        data: $("#form-createchar").serialize(),
      }).then((res) => {
        if (res.status) {
          swal("Create Character", res.msg, "success").then(() => {
            window.location.reload();
          });
        } else {
          swal("Create Character", res.msg, "error");
          $("#btn-submit").prop("disabled", false);
          $("#btn-submit").html("Submit");
        }
      });
    }

    $("#form-createchar").addClass("was-validated");
  });

  $(document).on("click", "#delete-char", (e) => {
    const id = e.target.getAttribute("data-user");
    e.preventDefault();
    swal({
      title: "Yakin ?",
      text: "Anda ingin menghapus karakter id " + id + "?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return new Promise((resolve) => {
          Ajax.post({
            url: "../scripts/char.php",
            data: "delete=" + id,
          }).then((res) => {
            if (res.status) {
              swal("Delete Char", res.msg, "success").then(() => {
                window.location.reload();
              });
            } else {
              swal("Delete Char", res.msg, "error");
            }
          });
        });
      },
    });
  });
});
