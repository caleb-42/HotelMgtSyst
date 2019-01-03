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
            dd = String(dd).length > 1 ? dd : ('0' + dd);
            mm = today.getMonth() + 1;
            mm = String(mm).length > 1 ? mm : ('0' + mm);
            yy = today.getFullYear();
            today = yy + '-' + mm + '-' + dd;
            return today;
        }
        today.setDate(today.getDate() + parseInt(input));
        dd = today.getDate();
        dd = String(dd).length > 1 ? dd : ('0' + dd);
        mm = today.getMonth() + 1;
        mm = String(mm).length > 1 ? mm : ('0' + mm);
        yy = today.getFullYear();
        today = yy + '-' + mm + '-' + dd;
        return today;
    }
});
app.filter('dateGetInterval', function(){
    return function(input, startdate){
        var oneday = 24*60*60*1000;
        var firstDate = new Date(startdate);
        var endDate = new Date(input);
        var diff = Math.round(Math.abs(
            (firstDate.getTime() - endDate.getTime())/(oneday)
        ));
        return diff;
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
        console.log(input);
        arr = [];
        for(var j = 0; j < input.length; j++){
            arr.push(input[j][obj.value]);
        }
        console.log(arr);
        dataSource = arr.slice();
        return dataSource;
    }
});
app.filter('explodeToList', function() {
    return function(input, delimiter) {
        if(!input){
            return [];
        }
        arr = input.split("/");

        return arr;
    }
});
app.filter('filterObj', function() {
    return function(input, id, prop) {
        obj = {};
        prop.forEach(function(elem){
            obj[elem] = null;
        });
        input.forEach(function(elem){
            if(elem[prop[0]] == id){
                obj = elem;
            }
        });

        return obj;
    }
});