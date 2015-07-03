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