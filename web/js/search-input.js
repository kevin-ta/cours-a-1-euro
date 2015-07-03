jQuery.fn.extend({
    student: function() {
        return this
            .data('api', $('body').data('get-student-api'))
            .data('waiting', false)
            .data('searching', false)
            .data('query', '')
            .change(function(){
                var $this = $(this);
                if($this.data('query') == $this.val()) return;
                if($this.data('searching') == true){
                    $this.data('waiting', true);
                    return;
                }
                $this.data('searching', true);
                $('#spinner').show();
                $('#desc').show();
                $('#form').hide();
                setTimeout(function(){
                    $this.data('query', $this.val());
                    $.ajax($this.data('api').replace('-query-', $this.val()), {
                        error: function(){
                            $this.data('searching', false);
                            $('#spinner').hide();
                            if($this.data('waiting')){
                                $this.data('waiting', false);
                                $this.keyup();
                            }
                            $('#desc').find('[data-p=desc]').hide();
                            $('#desc').find('[data-p=error]').show();
                        },
                        success: function(data){
                            $this.data('searching', false);
                            $('#spinner').hide();
                            if($this.data('waiting')){
                                $this.data('waiting', false);
                                $this.keyup();
                            }
                            $this.val(data.id);
                            $this.blur();
                            $this.trigger('studentFound', [data]);
                            $('#desc').hide();
                            $('#form').show();
                            $('#name').html(data.first_name + ' ' + data.last_name);
                            if(data.hasOwnProperty('quote')){
                                $('#quote').html(data.quote);
                                $('#img').cropper("setImgSrc", $('#img').data('src') + data.path.substr(data.path.indexOf("../web/")+ 7));

                                $('label[for=file]').html('Choisir une autre photo');
                                $('#request').attr('href', $('#request').data('href').replace('-id-', data.id));
                            }
                            else{
                                $('#quote').html('');
                                $('#request').removeAttr('href');
                            }
                        },
                        dataType: 'json'
                    });
                }, 200);
            })
            .keyup(function(){
                $(this).change();
            });
    }
});
$(function(){
    $('#search').student().change();

    $('#img').cropper({
        aspectRatio: 472/551,
        minWidth: 200,
        data: {
            x: 0, y: 0,
            width: 472, height: 551
        },
        done: function(data) {
            $('#x').val(data.x);
            $('#y').val(data.y);
            $('#w').val(data.width);
            $('#h').val(data.height);
        }
    });
});