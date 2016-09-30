$(function(){
    $("form.catalog-filter").submit(function(){
        $('#filter_portfolio .pseudo-select input').first().change();
        return false;
    });
});