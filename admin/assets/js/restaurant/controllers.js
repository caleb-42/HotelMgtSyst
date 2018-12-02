restaurantApp.controller("restaurant", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Products: {
                name: 'Products',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            },
            Customers: {
                name: 'Customers',
                options: {
                    rightbar: false
                }
            },
            Sales: {
                name: 'Sales',
                options: {
                    rightbar : {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            },
            Stocks: {
                name: 'Stocks',
                options: {
                    rightbar : false
                }
            },
            Users: {
                name: 'Users',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            }
        },
        selected: {
            name: 'Products',
            options: {
                rightbar: {
                    present: true,
                    rightbarclass: 'w-30',
                    primeclass: 'w-70'
                }
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.productstock = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_items.php", {})
            }
        },
        addProduct: function (jsonprod) {
            jsonprod.discount_rate = 0;
            jsonprod.discount_criteria = 0;
            jsonprod.discount_available = "";
            console.log("new product", jsonprod);

            jsonPost.data("../php1/admin/restaurant_admin/admin/add_item.php", {
                new_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        updateProduct: function (jsonprod) {
            jsonprod.id = $scope.productstock.jslist.selected;
            jsonprod.new_shelf_item = "";
            console.log("new product", jsonprod);
            jsonPost.data("../php1/admin/restaurant_admin/admin/edit_item.php", {
                update_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        deleteProduct: function () {
            jsonprod = {};
            jsonprod.items = [$scope.productstock.jslist.selectedObj];
            console.log("new product", jsonprod);
            jsonPost.data("../php1/admin/restaurant_admin/admin/del_item.php", {
                del_items: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        }
        /* croppie : {
            inputImage: "/assets/img/4.png",
            outputImage: null,

            onUpdate: function (data) {
                //console.log(data);
            }
        } */
    };
    $scope.stock = {
        /* itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/restaurant_items.php", {})
            }
        }, */
        activateStockModal : function(){
            if($scope.productstock.jslist.selectedObj.shelf_item == 'no'){
                $scope.stock.modal = 'none';
                return
            }else{
                $scope.stock.modal = 'modal';
            }; 
            $rootScope.settings.modal.active = 'Stock'; 
            $rootScope.settings.modal.name = 'Add Stock'; 
            $rootScope.settings.modal.size = 'md';
        },
        addStock: function (jsonstock) {
            jsonstock.item_id = $scope.productstock.jslist.selectedObj.id;
            
            jsonstock.item = $scope.productstock.jslist.selectedObj.item;
            
            jsonstock.category = $scope.productstock.jslist.selectedObj.category;
            
            console.log("new stock", jsonstock);
            jsonPost.data("../php1/admin/restaurant_admin/admin/add_stock.php", {
                new_stock: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        /* updateStock: function (jsonstock) {
            jsonstock.id = $scope.productstock.jslist.selected;
            console.log("new product", jsonstock);
            jsonPost.data("../php1/admin/restaurant_admin/admin/edit_item.php", {
                update_item: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        deleteStock: function () {
            jsonstock = {};
            jsonstock.items = [$scope.productstock.jslist.selectedObj];
            console.log("new product", jsonstock);
            jsonPost.data("../php1/admin/restaurant_admin/admin/del_item.php", {
                del_items: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        } */
        /* croppie : {
            inputImage: "/assets/img/4.png",
            outputImage: null,

            onUpdate: function (data) {
                //console.log(data);
            }
        } */
    };
    $scope.details = {
        discount: {
            selected_discount: "item",
            select_discount:function(type){
                $scope.details.discount.selected_discount = type;
                $scope.details.discount.jslist.createList()
            },
            itemlist: function (type) {
                if(type == "total"){
                    prod ="all";
                }else{
                    prod = $scope.productstock.jslist.selectedObj ? $scope.productstock.jslist.selectedObj.item : "sprite"
                }
                url = "../php1/admin/restaurant_admin/admin/list_discount.php";
                return {
                    jsonfunc: jsonPost.data(url, {
                        item: prod
                    })
                }
            },
            addDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.productstock.jslist.selectedObj.item;
                jsondiscount.discount_item = prod;
                console.log("new discount", jsondiscount);
                url = "../php1/admin/restaurant_admin/admin/add_discount.php";
                jsonPost.data(url, {
                    new_discount: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $rootScope.settings.modal.msgprompt(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            updateDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.productstock.jslist.selectedObj.item;

                jsondiscount.discount_item = prod;
                
                jsondiscount.discount_id = $scope.details.discount.jslist.selected;
                console.log("new discount", jsondiscount);
                url = "../php1/admin/restaurant_admin/admin/edit_discount.php";
                jsonPost.data(url, {
                    edit_discounts: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $rootScope.settings.modal.msgprompt(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            deleteDiscount: function () {
                jsondiscnt = {};
                jsondiscnt.discounts = [$scope.details.discount.jslist.selectedObj];
                console.log("new discount", jsondiscnt);
                jsonPost.data("../php1/admin/restaurant_admin/admin/del_discount.php", {
                    del_discounts: $filter('json')(jsondiscnt)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            }
        }
    }
    $scope.stockHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_stock_transaction.php", {})
            }
        }
    }
    $scope.listsales = {
        itemlist: function (ref) {
            //console.log('ewere');
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_sales.php", ref)
            }
        }
    };
    $scope.salesHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_transactions.php", {})
            }
        }
    };
    $scope.customers = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_customers.php", {}),
                /* jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_customers.php", {}) */
            }
        },
        addCustomer: function (jsoncust) {
            console.log("new cust", jsoncust);

            jsonPost.data("../php1/admin/restaurant_admin/admin/add_customer.php", {
                new_customer: $filter('json')(jsoncust)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.customers.jslist.createList();
            });
        },
        updateCustomer: function (jsoncust) {
            console.log("new cust", jsoncust);
            jsoncust.customer_id = $scope.customers.jslist.selected;
            jsonPost.data("../php1/admin/restaurant_admin/admin/update_customer.php", {
                update_customer: $filter('json')(jsoncust)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.customers.jslist.createList();
            });
        },
        deleteCustomer: function () {
            jsoncust = {};
            jsoncust.customers = [$scope.customers.jslist.selectedObj];
            console.log("new users", jsoncust);
            jsonPost.data("../php1/admin/restaurant_admin/admin/del_customers.php", {
                del_customers: $filter('json')(jsoncust)
            }).then(function (response) {
                //$scope.customers.jslist.toggleOut();
                console.log(response);
                $scope.customers.jslist.createList();
                //$scope.customers.jslist.toggleIn();
            });
        }
    };
    $scope.users = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("../php1/admin/restaurant_admin/admin/add_user.php", {
                new_user: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
            });
        },
        updateUser: function (jsonuser) {
            jsonuser.id = $scope.users.jslist.selected;
            console.log("new product", jsonuser);
            jsonPost.data("../php1/admin/restaurant_admin/admin/edit_user.php", {
                update_user: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        },
        deleteUser: function () {
            jsonuser = {};
            jsonuser.users = [$scope.users.jslist.selectedObj];
            console.log("new users", jsonuser);
            jsonPost.data("../php1/admin/restaurant_admin/admin/del_user.php", {
                del_users: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        }
    };
    $scope.sessions = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/restaurant_admin/admin/list_sessions.php", {})
            }
        }
    }
}]);
