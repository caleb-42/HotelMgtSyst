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
        today = new Date();
        if(!input){
            dd = today.getDate();
            mm = today.getMonth() + 1;
            yy = today.getFullYear();
            today = yy + '-' + mm + '-' + dd;
            return today;
        }
        today.setDate(today.getDate() + parseInt(input));
        dd = today.getDate();
        mm = today.getMonth() + 1;
        yy = today.getFullYear();
        today = yy + '-' + mm + '-' + dd;
        return today;
    }
});
app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});