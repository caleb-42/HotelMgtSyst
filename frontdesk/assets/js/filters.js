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
    return function(input, startdate){
        today = startdate ?  new Date(startdate) :  new Date();
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
app.filter('arraytostring', function() {
    return function(input) {
        str = "";
        if(Array.isArray(input)){
            for(var i = 0; i < input.length; i++ ){
                (i != input.length - 1) ? (str += input[i] + ", ") : (str += input[i]);
            }
        }
        return str;
    }
});
app.filter('objInArray', function() {
    return function(input, obj, prop) {
        arr = input.find(function(elem){
            return elem[prop] == obj;
        });
        return arr;
    }
});
app.filter('intString', function() {
    return function(input) {
        return parseInt(input);
    }
});
app.filter('duplicatekey', function() {
    return function(input, obj) {
        arr = Object.keys(obj);
        for(var j = 0; j < arr.length; j++){
            for(var i = 0; i < input.length; i++){
                input[i][arr[j]] = input[i][obj[arr[j]]];
            }
        }
        //console.log(input);
        return input;
    }
});