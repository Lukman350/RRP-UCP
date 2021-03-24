$(() => {
  $(".nav-item").click((e) => {
    document.querySelectorAll(".nav-item").forEach((nav) => {
      if (nav.className == "nav-item active") {
        nav.className = "nav-item";
      }
    });

    e.target.className += " active";
  });

  function startTime() {
    const hari = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const bulan = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const today = new Date();
    let date = today.getDate();
    let day = hari[today.getDay()];
    let month = bulan[today.getMonth()];
    let year = today.getFullYear();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();

    if (h >= 0 && h <= 9) {
      h = "0" + h;
    }

    if (m >= 0 && m <= 9) {
      m = "0" + m;
    }

    if (s >= 0 && s <= 9) {
      s = "0" + s;
    }

    $("#dateAndTime").html(`
      ${day}, ${date} ${month} ${year} ${h}:${m}:${s}
    `);
    setTimeout(() => {
      startTime();
    }, 1000);
  }

  startTime();
});
