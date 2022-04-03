$('[name="all_permission"]').on('click', function() {

        if($(this).is(':checked')) {
            $.each($('.permission'), function() {
                $(this).prop('checked',true);
            });
        } else {
            $.each($('.permission'), function() {
                $(this).prop('checked',false);
            });
        }
        
});
$('.permission').on('click', function() {
        if($('[name="all_permission"]').is(':checked')) {
            $('[name="all_permission"]').prop('checked',false);
        }
});
$('.read-notification').click(function(e){
    e.preventDefault();
    var arr = $('input[name="read[]"]:checked').map(function(){
        return $(this).val();
      }).get();
      if(!$.isEmptyObject(arr)){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method:'POST',
            url:"notifications/readall",
            data:{arr:arr},
            beforeSend: function () {
                $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
            },
            success:function(response){
                
                switch(response.status){
                    case 'success': swal("",response.msg,"success").then((value) => {
                        window.location.reload();
                    });
                                    break;
                    case 'warning': swal("",response.msg,"warning").then((value) => {
                        window.location.reload();
                    });
                                    break;
                    default: swal("",response.msg,"info").then((value) => {
                        window.location.reload();
                    });
                        
                }
            },error(error){
                
                swal("Sorry!", "Sorry! internal error has occured");
            },complete: function () {
               $('.overlay').remove();
            },
        });
        //ajax ends
      }
      else{
        swal("Sorry!", "Sorry! Please, select rows");
      }
        
    

    
});
    


    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for glyphicon and font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var glyph = $this.hasClass('glyphicon')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (glyph) {
        $this.toggleClass('glyphicon-star')
        $this.toggleClass('glyphicon-star-empty')
      }

      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    });


  $('.delete-notification').click(function(e){
    e.preventDefault();
    var arr = $('input[name="read[]"]:checked').map(function(){
        return $(this).val();
      }).get();
      if(!$.isEmptyObject(arr)){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method:'POST',
            url:"notifications/destroy/all",
            data:{arr:arr},
            beforeSend: function () {
                $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
            },
            success:function(response){
                
                switch(response.status){
                    case 'success': swal("",response.msg,"success").then((value) => {
                        window.location.reload();
                    });
                                    break;
                    case 'warning': swal("",response.msg,"warning").then((value) => {
                        window.location.reload();
                    });
                                    break;
                    default: swal("",response.msg,"info").then((value) => {
                        window.location.reload();
                    });
                        
                }
            },error(error){
                
                swal("Sorry!", "Sorry! internal error has occured");
            },complete: function () {
               $('.overlay').remove();
            },
        });
        //ajax ends
      }
      else{
        swal("Sorry!", "Sorry! Please, select rows");
      }
    
});


