app.filter('nairacurrency', function(){
    return function(input){
        if(input){
            return "N " + input;
        }
    }
});
app.filter('objtoarray', function(){
    return function(input){
        array = $.map(input, function(value, index){
            return [value];
        });
        return array;
    }
});
app.filter('intervalGetDate', function(){
    return function(input){
        if(!input){
            return '';
        }
        today = new Date();
        today.setDate(today.getDate() + parseInt(input));
        dd = today.getDate();
        mm = today.getMonth() + 1;
        yy = today.getFullYear();
        today = dd + '-' + mm + '-' + yy;
        return today;
    }
});