const Ajax = {
  post(options) {
    return new Promise((resolve, reject) => {
      options.dataType = "JSON";
      options.success = resolve;
      options.error = reject;
      $.post(options);
    });
  },
  get(options) {
    return new Promise((resolve, reject) => {
      options.dataType = "JSON";
      options.success = resolve;
      options.error = reject;
      $.get(options);
    });
  },
};
