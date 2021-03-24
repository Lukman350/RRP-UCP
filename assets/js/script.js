$(() => {
  $("#form-login").submit((e) => {
    $("#btn-submit").prop("disabled", true);
    $("#btn-submit").html("Loading...");
    e.preventDefault();

    if ($("#form-login")[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      Ajax.post({
        url: "scripts/login.php",
        data: $("#form-login").serialize(),
      }).then((res) => {
        if (res.status) {
          swal("Login", res.msg, "success").then(() => {
            window.location.href = "./dashboard/";
          });
        } else {
          swal("Login", res.msg, "error");
          $("#btn-submit").prop("disabled", false);
          $("#btn-submit").html("Login");
        }
      });
    }
    $("#form-login").addClass("was-validated");
  });

  $("#form-register").submit((e) => {
    $("#btn-submit").prop("disabled", true);
    $("#btn-submit").html("Loading...");
    e.preventDefault();

    if ($("#form-register")[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      Ajax.post({
        url: "scripts/register.php",
        data: $("#form-register").serialize(),
      }).then((res) => {
        if (res.status) {
          swal("Register", res.msg, "success").then(() => {
            window.location.href = "./login";
          });
        } else {
          swal("Register", res.msg, "error");
          $("#btn-submit").prop("disabled", false);
          $("#btn-submit").html("Register");
        }
      });
    }
    $("#form-register").addClass("was-validated");
  });

  $("#form-activation").submit((e) => {
    $("#submit").prop("disabled", true);
    $("#submit").html("Loading...");
    e.preventDefault();

    Ajax.post({
      url: "scripts/register.php",
      data: $("#form-activation").serialize(),
    }).then((res) => {
      if (res.status) {
        swal("Account Activation", res.msg, "success").then(() => {
          window.location.href = "./login";
        });
      } else {
        swal("Account Activation", res.msg, "error");
        $("#submit").prop("disabled", false);
        $("#submit").html("Click Me!");
      }
    });
  });

  $("#form-forgotpass").submit((e) => {
    $("#submit-forgot").prop("disabled", true);
    $("#submit-forgot").html("Loading...");
    e.preventDefault();

    if ($("#form-forgotpass")[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      Ajax.post({
        url: "scripts/forgot.php",
        data: $("#form-forgotpass").serialize(),
      }).then((res) => {
        if (res.status) {
          swal("Lupa Passowrd", res.msg, "success").then(() => {
            window.location.reload();
          });
        } else {
          swal("Lupa Password", res.msg, "error");
          $("#submit-forgot").prop("disabled", false);
          $("#submit-forgot").html("Reset Password");
        }
      });
    }
    $("#form-forgotpass").addClass("was-validated");
  });

  $("#form-resetpass").submit((e) => {
    $("#submit-reset").prop("disabled", true);
    $("#submit-reset").html("Loading...");
    e.preventDefault();

    if ($("#form-resetpass")[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      Ajax.post({
        url: "scripts/forgot.php",
        data: $("#form-resetpass").serialize(),
      }).then((res) => {
        if (res.status) {
          swal("Reset Password", res.msg, "success").then(() => {
            window.location.href = "./login";
          });
        } else {
          swal("Reset Password", res.msg, "error");
          $("#submit-reset").prop("disabled", false);
          $("#submit-reset").html("Reset Password");
        }
      });
    }

    $("#form-resetpass").addClass("was-validated");
  });
});
