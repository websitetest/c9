var Menubar = function(id) {
    
    this.id = id;
    var menubar;
    var btns;
    var active = false;
    
    this.init = function() {
        
        menubar = byId(id);
        btns = getElemAllIn(menubar, '.menubar-btn');
        
        for(var i = 0; i < btns.length; i++) {
            
            (function(i, menu) {
                btns[i].addEventListener('click', function() {
                    menu.btnClick(btns[i]);
                }, false);
                btns[i].addEventListener('blur', function() {
                    menu.btnBlur(btns[i]);
                }, false);
                btns[i].addEventListener('mouseover', function() {
                    menu.btnMouseOver(btns[i]);
                }, false);
                btns[i].addEventListener('mouseout', function() {
                    menu.btnMouseOut(btns[i]);
                }, false);
            })(i, this);
        }
    };
    
    this.btnClick = function(btn) {
        
        toggleClass(btn, 'menu-open');
        
        var li = findParent(btn, 'li');
        var menu = getElemAllIn(li, '.menubar-menu')[0];
        
        toggleClass(menu, 'open');
        
        active = true;
    };
    
    this.btnBlur = function(btn) {
        
        this.closeAll();
        active = false;
    };
    
    this.btnMouseOver = function(btn) {
        
        if(active) {
            this.openOnly(btn);
        }
    };
    
    this.btnMouseOut = function(btn) {
        
    };
    
    this.openOnly = function(btn) {
        
        this.closeAll();
        this.openMenu(btn);
    };
    
    this.openMenu = function(btn) {
        
        addClass(btn, 'menu-open');
        
        var li = findParent(btn, 'li');
        var menu = getElemAllIn(li, '.menubar-menu')[0];
        
        addClass(menu, 'open');
        
        active = true;
    };
    
    this.closeAll = function() {
        
        var menus = getElemAllIn(menubar, '.menubar-menu');
        for(var i = 0; i < menus.length; i++) {
            removeClass(menus[i], 'open');
        }
        
        var bt = getElemAllIn(menubar, '.menubar-btn');
        for(var b = 0; b < bt.length; b++) {
            removeClass(bt[b], 'menu-open');
        }
    };
    
    this.init();
    
    
};