$('.first-upper').on('keyup', function (e) {
    var txt = $(this).val();
    $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
      return $1.toUpperCase( );
    }));
  });