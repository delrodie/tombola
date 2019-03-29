jQuery(document).ready(function() {
    var searchRequest = null;
    $("#search").keyup(function() {
        var minlength = 8;
        var that = this;
        var value = $(this).val();
        var entitySelector = $("#entitiesNav").html('');
        if (value.length >= minlength ) {
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
                url: "{{ path('recherche') }}",
                data: {
                    'code' : value
                },
                dataType: "text",
                success: function(msg){
                    if (value==$(that).val()) {
                        var result = JSON.parse(msg);
                        $.each(result, function(key, arr) {
                            $.each(arr, function(id, value) {
                                if (key == 'resultats') {
                                    if (id != 'error') {
                                        entitySelector.append(
                                            '<span style="font-size: 1.2em; font-weight: bold;">FE-LI-CI-TA-TION !!! </span><br><br>' +
                                            'Cliquez sur votre code pour voir votre gain <br><br>' +
                                            '<span style="font-size: 1.2em; font-weight: bold"> <a href="/tombola/'+id+'-premier-tirage">'+value+'</a></span><br>'
                                        );
                                    } else {
                                        entitySelector.append('<strong>'+value+'</strong>');
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});
